<?php

namespace App\Models\Quiz;

use App\Models\Players\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Set extends Model{
    use SoftDeletes;
    protected $table = 'quiz__sets';
    protected $guarded = ['id'];

    public function questionRel(){
        return $this->hasMany(Question::class, 'set_id', 'id')->orderBy('id');
    }
    public function playerRel(){
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    public function getTotalPoints(){
        try{
            $counter = 0; $totalPoints = 0;

            foreach ($this->questionRel as $question){
                $correct = false;
                foreach ($question->answerRel as $answ){
                    if($answ->correct == 1 and $answ->id == $question->answer) $correct = true;
                }

                if($question->answer != null){
                    if($correct) {
                        $counter++;
                        $totalPoints += $counter;
                    }
                }else break;
            }
            return $totalPoints;
        }catch (\Exception $e){ return 0; }
    }
    public function numberOfQuestion(){
        $counter = 1;
        try{
            foreach ($this->questionRel as $question){
                if($question->answer != null) $counter++;
            }
        }catch (\Exception $e){}
        return $counter;
    }
    public function usedJoker(){
        foreach ($this->questionRel as $question){
            if($question->answer === 0) return 1;
        }
        return 0;
    }
}
