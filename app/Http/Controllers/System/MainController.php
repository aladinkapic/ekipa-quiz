<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller{
    protected $_path = 'app.system.';

    public function index (){
        return view($this->_path.'index');
    }
}
