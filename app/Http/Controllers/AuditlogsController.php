<?php

namespace App\Http\Controllers;

use App\Interfaces\AuditlogInterface;
use Illuminate\Http\Request;

class AuditlogsController extends Controller
{
    protected $auditlogRepository;
    public function __construct(AuditlogInterface $auditlogRepository)
    {
        $this->auditlogRepository = $auditlogRepository;
    }

    public function index()
    {
        return $this->auditlogRepository->index();
    }
    public function getLogs()
    {
        return $this->auditlogRepository->getLogs();
    }
    public function downloadLogs()
    {
        return $this->auditlogRepository->downloadLogs();
    }
}
