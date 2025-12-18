<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\EnrollmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Cloudinary\Cloudinary;


class UserRepository implements UserInterface
{
    public function edit()
    {
        $user = Auth::user();
        $departments = Department::all();
        return view('voting.dashbord.profile.index', compact('user', 'departments'));
    }

    // public function update($request)
    // {
    //     $user = Auth::user();

    //     try {
    //         DB::beginTransaction();

    //         $user->department = $request->department;

    //         // If a new image is uploaded
    //         if ($request->hasFile('profile_image')) {
    //             $oldPath = $user->profile_image;

    //             // Delete old image if stored locally on the public disk
    //             if (
    //                 $oldPath &&
    //                 !Str::startsWith($oldPath, ['http://', 'https://']) &&
    //                 Storage::disk('public')->exists($oldPath)
    //             ) {
    //                 Storage::disk('public')->delete($oldPath);
    //             }

    //             // Store new image: storage/app/public/profile_images/
    //             $newPath = $request->file('profile_image')->store('profile_images', 'public');
    //             $user->profile_image = $newPath;
    //         }

    //         $user->save();

    //         AuditLog::create([
    //             'user_id' => Auth::user()->id,
    //             'action'  => 'Update Profile',
    //             'details' => json_encode($user),
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'message' => 'Profile updated successfully',
    //         ], 200);
    //     } catch (Throwable $e) {
    //         DB::rollBack();

    //         Log::error('User profile update failed', [
    //             'user_id'  => optional($user)->id,
    //             'error'    => $e->getMessage(),
    //         ]);

    //         flash()->error('Could not update your profile. Please try again.');
    //         return back()->withInput();
    //     }
    // }

    public function update($request)
    {
        $user = Auth::user();

        try {
            DB::beginTransaction();

            $user->department = $request->department;

            // If a new image is uploaded
            if ($request->hasFile('profile_image')) {
                $oldPath = $user->profile_image;

                // Delete old image from Cloudinary if it's a URL
                if ($oldPath && str_starts_with($oldPath, 'http')) {
                    try {
                        $cloudinary = new Cloudinary([
                            'cloud' => [
                                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                                'api_key'    => env('CLOUDINARY_API_KEY'),
                                'api_secret' => env('CLOUDINARY_API_SECRET'),
                            ],
                        ]);

                        // Extract public_id from the URL
                        $parsedUrl = parse_url($oldPath, PHP_URL_PATH);
                        $publicId = pathinfo($parsedUrl, PATHINFO_FILENAME);

                        $cloudinary->uploadApi()->destroy("profile_images/$publicId");
                    } catch (Throwable $e) {
                        Log::warning("Failed to delete old Cloudinary image: " . $e->getMessage());
                    }
                }

                // Upload new image to Cloudinary
                $file = $request->file('profile_image');
                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key'    => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET'),
                    ],
                ]);

                $uploadedFile = $cloudinary->uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'profile_images', // optional folder
                ]);

                $user->profile_image = $uploadedFile['secure_url'];
            }

            $user->save();

            AuditLog::create([
                'user_id' => Auth::user()->id,
                'action'  => 'Update Profile',
                'details' => json_encode($user),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Profile updated successfully',
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('User profile update failed', [
                'user_id'  => optional($user)->id,
                'error'    => $e->getMessage(),
            ]);

            flash()->error('Could not update your profile. Please try again.');
            return back()->withInput();
        }
    }

    public function delete($request)
    {
        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Delete user profile image if it exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
            Auth::logout();
            // Delete the user
            $user->delete();

            AuditLog::create([
                'user_id' => Auth::user()->id,
                'action'  => 'Update Profile',
                'details' => json_encode($user),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Account deleted successfully',
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('User account deletion failed', [
                'user_id'  => optional($user)->id,
                'error'    => $e->getMessage(),
            ]);

            flash()->error('Could not delete your account. Please try again.');
            return back();
        }
    }

    public function enrollment()
    {
        $user = Auth::user();

        return view('voting.dashbord.profile.enrollment', compact('user'));
    }

    public function userEnrollment($request)
    {
        $user = Auth::user();

        if ($user->role == 'voter') {
            $userStatus = 'election_officer';
        } elseif ($user->role == 'candidate') {
            $userStatus = 'election_officer';
        }

        $enrollmentRequest = EnrollmentRequest::create([
            'user_id' => $user->id,
            'user_become_status' => $userStatus,
            'status' => 'pending',
            'reason' => $request->reason,
        ]);

        AuditLog::create([
            'user_id' => Auth::user()->id,
            'action'  => 'User Request Enrollment',
            'details' => json_encode($enrollmentRequest),
        ]);

        return response()->json([
            'message' => 'Enrollment request submitted successfully',
        ], 200);
    }
}
