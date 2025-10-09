<?php

namespace App\Repositories;

use App\Interfaces\AuditlogInterface;
use App\Models\AuditLog;
use Illuminate\Support\Carbon;
use TCPDF;
use Yajra\DataTables\Facades\DataTables;

class AuditlogRepository implements AuditlogInterface
{
    public function index()
    {
        return view('voting.dashbord.auditlog.index');
    }

    public function getLogs()
    {
        $auditLogs = AuditLog::with('user')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc');

        return DataTables::of($auditLogs)
            ->addIndexColumn()
            ->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->first_name . ' ' . $row->user->last_name : 'N/A';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->make(true);
    }

    public function downloadLogs()
    {
        // $auditLogs = AuditLog::with('user')
        //     ->where('created_at', '>=', Carbon::now()->subDays(30))
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        // $filename = 'audit_logs_' . now()->format('Ymd_His') . '.csv';
        // $filePath = storage_path('app/' . $filename);

        // $file = fopen($filePath, 'w');
        // fputcsv($file, ['ID', 'User Name', 'Action', 'Description', 'Created At']);

        // foreach ($auditLogs as $log) {
        //     fputcsv($file, [
        //         $log->id,
        //         $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'N/A',
        //         $log->action,
        //         $log->description,
        //         $log->created_at->format('Y-m-d H:i:s'),
        //     ]);
        // }

        // fclose($file);

        // return response()->download($filePath)->deleteFileAfterSend(true);

        $auditLogs = AuditLog::with('user')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'audit_logs_' . now()->format('Ymd_His') . '.pdf';

        // Create new PDF instance
        $pdf = new TCPDF();
        $pdf->SetCreator('Laravel App');
        $pdf->SetAuthor('Your App Name');
        $pdf->SetTitle('Audit Logs');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Table header
        $html = '<h3>Audit Logs (Last 30 Days)</h3>
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr style="background-color:#f2f2f2;">
                    <th width="10%">ID</th>
                    <th width="20%">User Name</th>
                    <th width="50%">Action</th>
                    <th width="20%">Created At</th>
                </tr>
            </thead>
            <tbody>';

        // Table body
        foreach ($auditLogs as $log) {
            $html .= '<tr>
            <td width="10%">' . $log->id . '</td>
            <td width="20%">' . ($log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'N/A') . '</td>
            <td width="50%">' . $log->action . '</td>
            <td width="20%">' . $log->created_at->format('Y-m-d H:i:s') . '</td>
        </tr>';
        }

        $html .= '</tbody></table>';

        // Write content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output as download
        $pdf->Output($filename, 'D'); // 'D' = download, 'I' = inline view
    }
}
