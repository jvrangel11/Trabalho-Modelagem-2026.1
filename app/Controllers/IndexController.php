<?php

namespace App\Controllers;

use App\Core\App;
use Exception;

class IndexController
{
    public function index()
    {
        return view('admin/index');
    }
}