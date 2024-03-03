<?php

namespace App\Traits;
use Illuminate\Support\Facades\Auth;
trait AuthorizeCheck{
    public function authorizeCheck($permission){
        if(!Auth::user()->can($permission)){
            throw new \Illuminate\Auth\Access\AuthorizationException();
        }
    }
}