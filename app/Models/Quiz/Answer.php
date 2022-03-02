<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model{
    use SoftDeletes;
    protected $table = 'quiz__sets_questions_answers';
    protected $guarded = ['id'];
}
