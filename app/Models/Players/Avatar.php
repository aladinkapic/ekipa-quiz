<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avatar extends Model{
    use SoftDeletes;
    protected $table = 'avatars';
    protected $guarded = ['id'];
}
