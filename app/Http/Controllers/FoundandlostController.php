<?php

namespace App\Http\Controllers;

use App\Models\Foundandlost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoundandlostController extends Controller
{
    public function getAll(){
       $array = ['error'=>''];

       $lost = Foundandlost::where('status', 'LOST')
       ->orderBy('datecreated', 'DESC')
       ->orderBy('id', 'DESC')
       ->get();

       $recovered = Foundandlost::where('status', 'RECOVERED')
       ->orderBy('datecreated', 'DESC')
       ->orderBy('id', 'DESC')
       ->get();

        foreach($lost as $lostKey => $lostValue){
            $lost[$lostKey]['datecreated'] = date('d/m/Y', strtotime($lostValue['datecreated']));
            $lost[$lostKey]['photo'] = asset('storage/'.$lostValue['photo']);
        }

        foreach($recovered as $recKey => $recValue){
            $recovered[$recKey]['datecreated'] = date('d/m/Y', strtotime($recValue['datecreated']));
            $recovered[$recKey]['photo'] = asset('storage/'.$recValue['photo']);
        }

        $array['lost'] = $lost;
        $array['recovered'] = $recovered;
        return $array;
    }
    public function insert(Request $request){
        $array = ['error'=>''];
        $rules = [
            'description' => 'required',
            'where' => 'required',
            'photo' => 'required|file|mimes:jpg,png'
        ];

        $validator = Validator::make($request->all(), $rules);
        if(!$validator->fails()){
            $description = $request->input('description');
            $where = $request->input('where');
            $file = $request->file('photo')->store('public');
            $file = explode('public/', $file);
            $photo = $file[1];

            $newLost = new Foundandlost();
            $newLost->status = 'LOST';
            $newLost->photo = $photo;
            $newLost->description = $description;
            $newLost->where = $where;
            $newLost->datecreated = date('Y-m-d');
            $newLost->save();

        }else{
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    public function update($id, Request $request){
        $array = ['error'=>''];

        $status = $request->input('status');
        if($status && in_array($status, ['lost', 'recovered'])){

            $item = Foundandlost::find($id);
            if($item){
                $item->status = $status;
                $item->save();
            }else{
                $array['error'] = 'Item inexistente';
                return $array;
            }
        }else{
            $array['error'] = 'Status inexistente';
            return $array;
        }

        return $array;
    }
}
