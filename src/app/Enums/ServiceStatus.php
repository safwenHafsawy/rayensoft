<?php

namespace App\Enums;


enum ServiceStatus:string {
    case SUCCESS = 'success';
    case FAILURE = 'failure';
}