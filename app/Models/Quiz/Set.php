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
        return $this->hasMany(Question::class, 'set_id', 'id');
    }
    public function playerRel(){
        return $this->hasOne(Player::class, 'id', 'player_id');
    }
}
