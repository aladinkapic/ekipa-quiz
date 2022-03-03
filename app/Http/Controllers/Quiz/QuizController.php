<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Players\Player;
use App\Models\Quiz\Answer;
use App\Models\Quiz\Question;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\Set;
use Illuminate\Http\Request;

class QuizController extends Controller{
    protected $_path = 'app.quiz.';
    protected $_players = [], $_letters = ['A', 'B', 'C', 'D'];

    public function index(){
        return view($this->_path.'index', [
            'quizzes' => Quiz::get()
        ]);
    }
    public function live($id){
        $set = Set::where('quiz_id', $id)->where('finished', 0)->first();
        $question = Question::where('set_id', $set->id)->whereNull('answer')->first();

        $finished = Set::where('quiz_id', $id)->where('finished', 1)->get();

        return view($this->_path.'live', [
            'player' => Player::where('id', $set->player_id)->first(),
            'question' => $question,
            'letters' => $this->_letters,
            'set' => $set,
            'finished' => $finished
        ]);
    }
    public function answerQuestion(Request $request){
        $totalPoints = 0; $counter = 0;

        try{
            $question = Question::where('id', $request->question)->first();
            $question->update(['answer' => $request->answer]);

            $newQuestion = Question::where('set_id', $request->set)->whereNull('answer')->first();
            $data = [
                'question' => $newQuestion,
                'answers'  => isset($newQuestion) ? Answer::where('question_id', $newQuestion->id)->get() : '',
                'done'     => isset($newQuestion) ? false : true
            ];

            $answer = Answer::where('id', $request->answer)->first();

            if(!$newQuestion) Set::where('id', $request->set)->update(['finished' => 1]);

            $questions =  Question::where('set_id', $request->set)->where('answer', '!=', NULL)->get();
            foreach ($questions as $q){
                $correct = false;
                foreach ($q->answerRel as $answ){
                    if($answ->correct == 1 and $answ->id == $q->answer) $correct = true;
                }

                if($q->answer != null){
                    if($q->answer != 0) $counter++;
                    $totalPoints += $counter;
                }else break;
            }

            Set::where('id', $request->set)->update(['points' => $totalPoints]);

            return json_encode([
                'code' => '0000',
                'correct' => isset($answer) ? $answer->correct : '',
                'joker' => ($request->answer == 0) ? true : false,
                'data' => $data,
                'left' => Question::where('set_id', $request->set)->whereNull('answer')->count(),
                'points' => $totalPoints
            ]);
            dd($question, $answer);
            dd($request->all());
        }catch (\Exception $e){
            dd($e);
            return json_encode([
                'code' => '4004',
                'message' => 'Došlo je do greške, pokušajte ponovo!'
            ]);
        }
    }
}
