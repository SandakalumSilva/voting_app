<?php

namespace App\Providers;

use App\Interfaces\AdminInterface;
use App\Interfaces\AuditlogInterface;
use App\Interfaces\DepartmentInterface;
use App\Interfaces\ElectionInterface;
use App\Interfaces\ElectionOfficerInterface;
use App\Interfaces\NominationInterface;
use App\Interfaces\NominationRequestInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\VoterInterface;
use App\Repositories\AdminRepository;
use App\Repositories\AuditlogRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\ElectionOfficerRepository;
use App\Repositories\ElectionRepository;
use App\Repositories\NominationRepository;
use App\Repositories\NominationRequestRepository;
use App\Repositories\UserRepository;
use App\Repositories\VoterRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VoterInterface::class, VoterRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        $this->app->bind(ElectionOfficerInterface::class, ElectionOfficerRepository::class);
        $this->app->bind(DepartmentInterface::class, DepartmentRepository::class);
        $this->app->bind(ElectionInterface::class, ElectionRepository::class);
        $this->app->bind(AuditlogInterface::class, AuditlogRepository::class);
        $this->app->bind(NominationInterface::class, NominationRepository::class);
        $this->app->bind(NominationRequestInterface::class, NominationRequestRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
