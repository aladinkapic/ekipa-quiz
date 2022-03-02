<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model{
    use SoftDeletes;
    protected $table = 'quiz__sets_questions';
    protected $guarded = ['id'];

    public function answerRel(){
        return $this->hasMany(Answer::class, 'question_id', 'id');
    }
}
