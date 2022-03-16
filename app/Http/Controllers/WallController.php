<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wall;
use App\Models\Walllike;
use App\Models\User;

class WallController extends Controller
{
    public function getAll(){
        $array = ['error' => '', 'list' => ''];

        $user = auth()->user();

        $walls = Wall::all();

        foreach($walls as $wallKey => $wallValue){
            $walls[$wallKey]['likes'] = 0;
            $walls[$wallKey]['liked'] = false;

            $likes = Walllike::where('id_wall', $wallValue['id'])->count();
            $walls[$wallKey]['likes'] = $likes;

            $meLikes = Walllike::where('id_wall', $wallValue['id'])
            ->where('id_user', $user['id'])
            ->count();

            if($meLikes > 0){
                $walls[$wallKey]['liked'] = true ;
            }
        }
        $array['list'] = $walls;
        return $array;
    }

    public function like($id){
        $array = ['error' => ''];

        $user = auth()->user();

        $melikes = Walllike::where('id_wall', $id)
        ->where('id_user',$user['id'])
        ->count();

        if($melikes >0){
            Walllike::where('id_wall', $id)
            ->where('id_user',$user['id'])
            ->delete();
            $array['liked'] = false;
        }else{
            $newLike = new Walllike();
            $newLike->id_wall = $id;
            $newLike->id_user = $user['id'];
            $newLike->save();
            $array['liked'] = true;
        }

        $array['likes'] = Walllike::where('id_wall', $id)->count();

        return $array;
    }
}
