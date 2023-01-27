<?php

namespace Modules\Space\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Modules\Space\Models\BusCompanies;
use Modules\Space\Models\BusStops;
use Modules\Location\Models\Location;

class BusStopsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusStops::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locations = Location::pluck('id')->toArray();

        return [
            'name'=>$this->faker->city,
            'code'=>$this->faker->unique()->randomNumber(3),
            'location_id'=>$this->faker->randomElement($locations),
            'description'=>$this->faker->text,
            'address'=>$this->faker->address,
            'map_lat'=>$this->faker->latitude,
            'map_lng'=>$this->faker->longitude,
            'map_zoom'=>$this->faker->numberBetween(8,10),
        ];
    }
}
