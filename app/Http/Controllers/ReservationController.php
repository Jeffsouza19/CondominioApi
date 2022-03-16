<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnValueMap;

class ReservationController extends Controller
{
    public function getReservation(){
        $array = ['error'=>'', 'list'=>[ ]];
        $dayshelper = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui','Sex', 'Sab'];

        $areas = Area::where('allowed', 1)->get();

        foreach($areas as $area){
            $dayList = explode(',', $area['days']);

            $dayGroup = [];

            $lastDay = intval(current($dayList));
            $dayGroup[] = $dayshelper[$lastDay];
            array_shift($dayList);

            foreach($dayList as $day){
                if(intval($day) != $lastDay+1){
                    $dayGroup[] = $dayshelper[$lastDay];
                    $dayGroup[] = $dayshelper[$day];
                }
                $lastDay = intval($day);
            }

            $dayGroup[] = $dayshelper[end($dayList)];


            $dates = '';
            $close = 0;
            foreach($dayGroup as $group){
                if($close === 0){
                    $dates .= $group;
                }else{
                    $dates .= '-'.$group.',';
                }
                $close = 1 - $close;
            }
            $dates = explode(',', $dates);
            array_pop($dates);


            $start = date('H:i', strtotime($area['start_time']));
            $end = date('H:i', strtotime($area['end_time']));

            foreach($dates as $dkey => $dValue){
                $dates[$dkey].= ' '.$start.' às ' .$end;
            }
            $array['list'][] = [
                'id' => $area['id'],
                'cover' => asset('storage/'.$area['cover']),
                'title' => $area['title'],
                'dates' => $dates
            ];
        }


       return $array;
    }
}
