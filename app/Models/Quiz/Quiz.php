<?php

namespace App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model{
    use SoftDeletes;
    protected $table = 'quiz';
    protected $guarded = ['id'];

    public function setRel(){
        return $this->hasMany(Set::class, 'quiz_id', 'id');
    }
}
