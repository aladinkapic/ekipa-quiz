<?php

namespace App\Models\Quiz;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model{
    use SoftDeletes;
    protected $table = 'quiz';
    protected $guarded = ['id'];

    public function setRel(){
        return $this->hasMany(Set::class, 'quiz_id', 'id');
    }
    public function dateFormat(){ return Carbon::parse($this->date)->format('d.m.Y'); }
}
