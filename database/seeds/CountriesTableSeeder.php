<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $countries = [
           'Egypt' => 'EG',
           'Saudia' => 'SA',
           'England' => 'EN',
           'German' => "GM",
           'Gaban' => "GB",
       ];
       collect($countries)->each(function ($code, $name){
         Country::create([
            'code' => $code,
            'name' => $name
         ]);
       });
    }
}
