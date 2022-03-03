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
        $question = Question::where('set_id', $set->id ?? 0)->whereNull('answer')->first();

        $finished = Set::where('quiz_id', $id)->where('finished', 1)->get();

        return view($this->_path.'live', [
            'player' => Player::where('id', $set->player_id ?? 0)->first(),
            'question' => $question,
            'letters' => $this->_letters,
            'set' => $set,
            'finished' => $finished,
            'quiz' => Quiz::where('id', $id)->first()
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

            if(!$newQuestion or (isset($answer) and $answer->correct == 0)) Set::where('id', $request->set)->update(['finished' => 1]);
            $totalPoints = Set::where('id', $request->set)->first()->getTotalPoints();

            Set::where('id', $request->set)->update(['points' => $totalPoints]);

            return json_encode([
                'code' => '0000',
                'correct' => isset($answer) ? $answer->correct : '',
                'joker' => ($request->answer == 0) ? true : false,
                'data' => $data,
                'left' => Question::where('set_id', $request->set)->whereNull('answer')->count(),
                'points' => $totalPoints
            ]);
        }catch (\Exception $e){
            dd($e);
            return json_encode([
                'code' => '4004',
                'message' => 'Došlo je do greške, pokušajte ponovo!'
            ]);
        }
    }

    public function highScore(Request $request){
        try{
            $data = [];
            $sets = Set::where('quiz_id', $request->id)->whereNotNull('player_id')->get();

            foreach ($sets as $set){
                array_push($data, [
                    'avatar' => $set->playerRel->avatarRel->image ?? '',
                    'name' => $set->playerRel->name ?? '',
                    'points' => $set->getTotalPoints()
                ]);
            }

            return json_encode([
                'code' => '0000',
                'data' => $data
            ]);
        }catch (\Exception $e){ return json_encode([ 'code' => '0000' ]); }
    }
    public function finishQuiz(Request $request){
        try{
            Set::where('id', $request->id)->update(['finished' => 1]);
        }catch (\Exception $e){}
    }
}
