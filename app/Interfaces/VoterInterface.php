<?php 
namespace App\Interfaces;
interface VoterInterface
{
    public function index();
    public function election( $election);
    public function vote($request);
    public function otpVerify($id);
    public function otpVerifyPost($request);
}