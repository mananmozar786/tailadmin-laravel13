<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'India',
                'short_code' => 'IN',
                'phone_code' => '91',
                'states' => [
                    [
                        'name' => 'Maharashtra',
                        'state_code' => 'MH',
                        'cities' => ['Mumbai', 'Pune', 'Nagpur', 'Nashik']
                    ],
                    [
                        'name' => 'Gujarat',
                        'state_code' => 'GJ',
                        'cities' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot']
                    ],
                    [
                        'name' => 'Delhi',
                        'state_code' => 'DL',
                        'cities' => ['New Delhi', 'North Delhi', 'South Delhi']
                    ]
                ]
            ],
            [
                'name' => 'United States',
                'short_code' => 'US',
                'phone_code' => '1',
                'states' => [
                    [
                        'name' => 'California',
                        'state_code' => 'CA',
                        'cities' => ['Los Angeles', 'San Francisco', 'San Diego', 'Sacramento']
                    ],
                    [
                        'name' => 'New York',
                        'state_code' => 'NY',
                        'cities' => ['New York City', 'Buffalo', 'Rochester', 'Albany']
                    ],
                    [
                        'name' => 'Texas',
                        'state_code' => 'TX',
                        'cities' => ['Houston', 'Austin', 'Dallas', 'San Antonio']
                    ]
                ]
            ],
            [
                'name' => 'United Kingdom',
                'short_code' => 'GB',
                'phone_code' => '44',
                'states' => [
                    [
                        'name' => 'England',
                        'state_code' => 'ENG',
                        'cities' => ['London', 'Manchester', 'Birmingham', 'Liverpool']
                    ],
                    [
                        'name' => 'Scotland',
                        'state_code' => 'SCT',
                        'cities' => ['Edinburgh', 'Glasgow', 'Aberdeen']
                    ]
                ]
            ]
        ];

        foreach ($locations as $countryData) {
            $states = $countryData['states'];
            unset($countryData['states']);
            
            $country = Country::firstOrCreate(['name' => $countryData['name']], $countryData);

            foreach ($states as $stateData) {
                $cities = $stateData['cities'];
                unset($stateData['cities']);
                $stateData['country_id'] = $country->id;
                
                $state = State::firstOrCreate(['name' => $stateData['name'], 'country_id' => $country->id], $stateData);

                foreach ($cities as $cityName) {
                    City::firstOrCreate(['name' => $cityName, 'state_id' => $state->id]);
                }
            }
        }
    }
}
