<?php

namespace App\Models\Players;

use App\Models\Quiz\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model{
    use SoftDeletes;
    protected $table = 'players';
    protected $guarded = ['id'];

    public function avatarRel(){
        return $this->hasOne(Avatar::class, 'id', 'avatar');
    }
    public function setRel(){
        return $this->hasOne(Set::class, 'player_id', 'id');
    }
}
