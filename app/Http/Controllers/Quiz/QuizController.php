<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller{
    protected $_path = 'app.quiz.';
    public function index(){
        return view($this->_path.'index');
    }
}
