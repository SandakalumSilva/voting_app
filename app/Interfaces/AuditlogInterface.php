<?php 
namespace App\Interfaces;

interface AuditlogInterface
{
    public function index();
    public function getLogs();
    public function downloadLogs();
}