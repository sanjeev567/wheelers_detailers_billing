<?php

use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stateList = [
            [
                'state' => 'Andhra Pradesh',
                'code' => 'ap'
            ],
            [
                'state' => 'Arunachal Pradesh',
                'code' => 'ar'
            ],
            [
                'state' => 'Assam',
                'code' => 'as'
            ],
            [
                'state' => 'Bihar',
                'code' => 'br'
            ],
            [
                'state' => 'Chhattisgarh',
                'code' => 'cg'
            ],
            [
                'state' => 'Goa',
                'code' => 'ga'
            ],
            [
                'state' => 'Gujarat',
                'code' => 'gj'
            ],
            [
                'state' => 'Haryana',
                'code' => 'hr'
            ],
            [
                'state' => 'Himachal Pradesh',
                'code' => 'hp'
            ],
            [
                'state' => 'Jammu and Kashmir',
                'code' => 'jk'
            ],
            [
                'state' => 'Jharkhand',
                'code' => 'jh'
            ],
            [
                'state' => 'Karnataka',
                'code' => 'ka'
            ],
            [
                'state' => 'Kerala',
                'code' => 'kl'
            ],
            [
                'state' => 'Madhya Pradesh',
                'code' => 'mp'
            ],
            [
                'state' => 'Maharashtra',
                'code' => 'mh'
            ],
            [
                'state' => 'Manipur',
                'code' => 'mn'
            ],
            [
                'state' => 'Meghalaya',
                'code' => 'ml'
            ],
            [
                'state' => 'Mizoram',
                'code' => 'mz'
            ],
            [
                'state' => 'Nagaland',
                'code' => 'nl'
            ],
            [
                'state' => 'Odisha',
                'code' => 'od'
            ],
            [
                'state' => 'Punjab',
                'code' => 'pb'
            ],
            [
                'state' => 'Rajasthan',
                'code' => 'rj'
            ],
            [
                'state' => 'Sikkim',
                'code' => 'sk'
            ],
            [
                'state' => 'Tamil Nadu',
                'code' => 'tn'
            ],
            [
                'state' => 'Telangana',
                'code' => 'ts'
            ],
            [
                'state' => 'Tripura',
                'code' => 'ts'
            ],
            [
                'state' => 'Uttar Pradesh',
                'code' => 'up'
            ],
            [
                'state' => 'Uttarakhand',
                'code' => 'uk'
            ],
            [
                'state' => 'West Bengal',
                'code' => 'wb'
            ],
            [
                'state' => 'Delhi',
                'code' => 'dl'
            ],
        ];

        foreach ($stateList as $state) {
            \DB::Table('states')->insert($state);
        }
    }
}
