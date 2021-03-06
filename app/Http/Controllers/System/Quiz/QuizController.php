<?php

namespace App\Http\Controllers\System\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz\Question;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\Set;
use Illuminate\Http\Request;

class QuizController extends Controller{
    protected $_path = 'app.system.quiz.';
    public function index(){
        return view($this->_path.'index', [
            'quizzes' => Quiz::get()
        ]);
    }
    public function create(){
        return view($this->_path.'create', [
            'create' => true
        ]);
    }
    public function save(Request $request){
        $request = $this::format($request);
        try{
            $quiz = Quiz::create(['date' => $request->date]);
            return $this::success(route('system.quiz.preview', ['id' => $quiz->id]));
        } catch (\Exception $e) {
            return $this::error($e->getCode(), $e->getMessage());
        }
    }
    public function preview($id){
        return view($this->_path.'create', [
            'preview' => true,
            'quiz' => Quiz::find($id)
        ]);
    }
    public function restartSets (){
        try{
            Set::where('id', '>', 0)->update([
                'finished' => 0,
                'points' => 0
            ]);

            Question::where('id', '>', 0)->update([
                'answer' => NULL
            ]);
        }catch (\Exception $e){ abort('500', 'Error has occured'); }
        return back();
    }
}
