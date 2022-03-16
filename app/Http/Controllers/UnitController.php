<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Unitpeople;
use App\Models\Unitvehicle;
use App\Models\Unitpet;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function getInfo($id){
        $array = ['error'=>''];

        //verificar ID
        $unit = Unit::find($id);
        if($unit){

            //pegar informações sobre a unidade
            $people = Unitpeople::where('id_unit', $id)->get();
            $vehicle = Unitvehicle::where('id_unit', $id)->get();
            $pet = Unitpet::where('id_unit', $id)->get();
            foreach($people as $pkey => $pValue){
                $people[$pkey]['birthdate'] = date('d/m/Y',strtotime($pValue['birthdate']));
            }
            $array['people'] = $people;
            $array['vehicle'] = $vehicle;
            $array['pet'] = $pet;
        }else{
            $array['error'] = 'Propriedade Inexistente';
            return $array;
        }

        return $array;
    }
    public function addPerson($id, Request $request){
        $array = ['error'=>''];
        $rules = [
            'name' =>'required',
            'birthdate'=>'required|date'
        ];

        $validator = Validator::make($request->all(),$rules);

        if(!$validator->fails()){
            $name = $request->input('name');
            $birthdate = $request->input('birthdate');

            $newPerson = new Unitpeople();
            $newPerson->id_unit = $id;
            $newPerson->name = $name;
            $newPerson->birthdate = $birthdate;
            $newPerson->save();

        }else{
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }
    public function addVehicle($id, Request $request){
        $array = ['error'=>''];
        $rules = [
            'name' =>'required',
            'color'=>'required',
            'plate'=>'required',
        ];

        $validator = Validator::make($request->all(),$rules);

        if(!$validator->fails()){
            $name = $request->input('name');
            $color = $request->input('color');
            $plate = $request->input('plate');

            $newVehicle = new Unitvehicle();
            $newVehicle->id_unit = $id;
            $newVehicle->title = $name;
            $newVehicle->color = $color;
            $newVehicle->plate = $plate;
            $newVehicle->save();

        }else{
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }
    public function addPet($id, Request $request){
        $array = ['error'=>''];
        $rules = [
            'name' =>'required',
            'race'=>'required'
        ];

        $validator = Validator::make($request->all(),$rules);

        if(!$validator->fails()){
            $name = $request->input('name');
            $race = $request->input('race');

            $newPet = new Unitpet();
            $newPet->id_unit = $id;
            $newPet->name = $name;
            $newPet->race = $race;
            $newPet->save();

        }else{
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }
    public function removePerson($id, Request $request){
        $array = ['error'=>''];

        $idpeople = $request->input('id');
        if($idpeople){
           Unitpeople::where('id', $idpeople)->where('id_unit', $id)->delete();
        }else{
            $array['error'] = 'id inexistente';
            return $array;
        }

        return $array;
    }
    public function removePet($id, Request $request){
        $array = ['error'=>''];

        $idpet = $request->input('id');
        if($idpet){
           Unitpet::where('id', $idpet)->where('id_unit', $id)->delete();
        }else{
            $array['error'] = 'id inexistente';
            return $array;
        }

        return $array;
    }
    public function removeVehicle($id, Request $request){
        $array = ['error'=>''];

        $idvehicle = $request->input('id');
        if($idvehicle){
           Unitvehicle::where('id', $idvehicle)->where('id_unit', $id)->delete();
        }else{
            $array['error'] = 'id inexistente';
            return $array;
        }

        return $array;
    }
}
