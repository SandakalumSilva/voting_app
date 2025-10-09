<?php 
namespace App\Interfaces;

interface UserInterface
{
   public function edit();
   public function update($request);
   public function delete($request);
   public function enrollment();
   public function userEnrollment($request);
}