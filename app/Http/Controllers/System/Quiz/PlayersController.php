<?php

namespace App\Http\Controllers\System\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Players\Avatar;
use App\Models\Players\Player;
use App\Models\Quiz\Set;
use Illuminate\Http\Request;

class PlayersController extends Controller{
    protected $_path = 'app.system.quiz.players.';
    public function create ($set_id){
        return view($this->_path.'create', [
            'set' => Set::find($set_id),
            'create' => true
        ]);
    }

    public function save (Request $request){
        try{
            $set = Set::where('id', $request->set_id)->first();
            $avatar = Avatar::where('gender', $request->gender)->where('used', 0)->first();

            $player = Player::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'avatar' => $avatar->id
            ]);

            $avatar->update(['used' => $player->id ]);
            Set::where('id', $request->set_id)->update(['player_id' => $player->id]);

            return $this::success(route('system.quiz.preview', ['id' => $set->quiz_id]));
        }catch (\Exception $e) { return $this::error($e->getCode(), $e->getMessage()); }
    }
    public function edit ($id){
        $player = Player::find($id);

        return view($this->_path.'create', [
            'set' => Set::find($player->setRel->id),
            'player' => $player,
            'edit' => true
        ]);
    }
    public function update (Request $request){
        try{
            $set = Set::where('id', $request->set_id)->first();
            $player = Player::where('id', $request->id)->first();

            /*
             *  Reset avatar
             */
            Avatar::where('id', $player->avatar)->update(['used' => 0]);
            $avatar = Avatar::where('gender', $request->gender)->where('used', 0)->first();

            $player = Player::where('id', $request->id)->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'avatar' => $avatar->id
            ]);

            $avatar->update(['used' => $request->id ]);

            return $this::success(route('system.quiz.preview', ['id' => $set->quiz_id ]));
        }catch (\Exception $e) { dd($e); return $this::error($e->getCode(), $e->getMessage()); }
    }
}
