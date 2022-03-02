<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller{
    protected $_path = 'app.quiz.';
    public function index(){
        return view($this->_path.'index', [
            'quizzes' => Quiz::get()
        ]);
    }
    public function live($id){
        return view($this->_path.'live');
    }
}
