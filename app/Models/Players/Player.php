<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model{
    use SoftDeletes;
    protected $table = 'players';
    protected $guarded = ['id'];

    public function avatarRel(){
        return $this->hasOne(Avatar::class, 'id', 'avatar');
    }
}
