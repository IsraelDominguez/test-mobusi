<?php


namespace App\AdComponents;


interface AdComponentInterface
{
    //public function validate() : bool;

    public function setEntityFromJson($json);
}