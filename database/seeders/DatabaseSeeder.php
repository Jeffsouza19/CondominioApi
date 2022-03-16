<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            'name'=>'APT 100',
            'id_owner'=> '1',
        ]);
        DB::table('units')->insert([
            'name'=>'APT 101',
            'id_owner'=> '1',
        ]);
        DB::table('units')->insert([
            'name'=>'APT 102',
            'id_owner'=> '0',
        ]);
        DB::table('units')->insert([
            'name'=>'APT 103',
            'id_owner'=> '0',
        ]);
        DB::table('units')->insert([
            'name'=>'APT 104',
            'id_owner'=> '0',
        ]);
        DB::table('areas')->insert([
            'allowed'=>'1',
            'title' => 'Academia',
            'cover' => 'gym.jpg',
            'days' => '1,2,3,5,6',
            'start_time' => '06:00:00',
            'end_time' => '22:00:00'
        ]);
        DB::table('areas')->insert([
            'allowed'=>'1',
            'title' => 'Piscina',
            'cover' => 'pool.jpg',
            'days' => '1,2,4,5',
            'start_time' => '08:00:00',
            'end_time' => '18:00:00'
        ]);
        DB::table('areas')->insert([
            'allowed'=>'1',
            'title' => 'Churrasqueira',
            'cover' => 'barbecue',
            'days' => '4,5,6',
            'start_time' => '08:00:00',
            'end_time' => '18:00:00'
        ]);
        DB::table('walls')->insert([
            'title' => 'Aviso',
            'body' => 'ajsdbisafb ub fipafbew fpawuefb uw fbapwuf bp',
            'datecreated' => '2020-12-20 18:00:00'
        ]);
        DB::table('walls')->insert([
            'title' => 'Se Liga Geral',
            'body' => 'ajsdbisafb ub fipafbew fpawuefb uw fbapwuf bp',
            'datecreated' => '2020-12-20 18:00:00'
        ]);
    }
}
