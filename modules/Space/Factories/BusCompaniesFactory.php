<?php
namespace Modules\Space\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Modules\Space\Models\BusCompanies;
use Modules\Media\Models\MediaFile;

class BusCompaniesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusCompanies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imgBusCompaniesFactoryImage = DB::table('media_files')->where('file_name','like','space-%')->get()->pluck(['id'])->toArray();
        return [
            'name'=>$this->faker->city,
            'image_id'=>$this->faker->randomElement($imgBusCompaniesFactoryImage)
        ];
    }

}
