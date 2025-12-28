<?php
namespace App\Interfaces;

interface NominationInterface
{    
   public function createNomination($request);
   public function getNominations($id);
   public function allNominations();
}