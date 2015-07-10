<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends LaravelController
{
    use DispatchesJobs, ValidatesRequests;
}
