<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model{
    protected $table = 'quiz__sets_questions_categories';
    protected $guarded = ['id'];
}
