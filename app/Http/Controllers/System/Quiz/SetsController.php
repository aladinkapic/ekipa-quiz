<?php

namespace App\Http\Controllers\System\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz\Answer;
use App\Models\Quiz\Category;
use App\Models\Quiz\Question;
use App\Models\Quiz\Set;
use Illuminate\Http\Request;

class SetsController extends Controller{
    protected $_path = 'app.system.quiz.sets.';
    public function create($quiz_id){
        try{
            $set = Set::create([
                'quiz_id' => $quiz_id
            ]);
            return redirect()->route('system.quiz.sets.preview', ['id' => $set->id ]);
        }catch (\Exception $e){}
    }
    public function preview ($id){
        return view($this->_path.'preview', [
            'set' => Set::find($id)
        ]);
    }
    public function newQuestion($set_id){
        return view($this->_path.'question', [
            'create' => true,
            'set' => Set::find($set_id),
            'categories' => Category::pluck('category', 'id')
        ]);
    }
    public function saveQuestion(Request $request){
        if(!isset($request->answer))  return $this::error( '4004', 'Niste unijeli ni jedan odgovor !');

        $foundCorrect = 0;
        for($i=0; $i<count($request->answer); $i++){
            if($request->correct[$i] == 1) $foundCorrect++;
        }
        if($foundCorrect != 1) return $this::error( '4004', 'Molimo Vas da unesete jedan tačan odgovor!');
        if(count($request->answer) != 4) return $this::error( '4004', 'Molimo Vas da unesete 4 ponuđenja odgovora!');

        try{
            $question = Question::create([
                'set_id' => $request->set_id,
                'question' => $request->question,
                'category' => $request->category
            ]);

            for($i=0; $i<count($request->answer); $i++){
                $answer = Answer::create([
                    'question_id' => $question->id,
                    'answer' => $request->answer[$i],
                    'correct' => $request->correct[$i]
                ]);
            }
            return $this::success(route('system.quiz.sets.preview', ['id' => $request->set_id]));
        } catch (\Exception $e) { return $this::error($e->getCode(), $e->getMessage()); }
    }
    public function deleteQuestion ($id){
        try{
            $question = Question::find($id);
            $set = $question->set_id;
            $question->delete();

            return redirect()->route('system.quiz.sets.preview', ['id' => $set]);
        }catch (\Exception $e){}
    }
    public function finishSet($id){
        try{
            $set = Set::where('id', $id)->update(['finished' => 1]);
            return back();
        }catch (\Exception $e){}
    }
}
