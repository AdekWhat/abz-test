<?php

namespace Database\Factories;

use App\Models\Employees;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class EmployeesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employees::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

      // $factory->define(\App\Models\Employees::class, function (Faker\Generator $faker) {
      $position = \App\Models\Positions::pluck('id')->toArray();
      //
        return [
            'full_name' => $this->faker->name(),
            // 'position' => $this->faker->numberBetween(1, \App\Models\Positions::count()),
            'position' =>$this->faker->randomElement($position),
            'employment_date' => $this->faker->dateTimeBetween('-2 months', '-1 days'),
            'head_id' => null,
            'phone_number' => $this->faker->tollFreePhoneNumber(),
            'email' => $this->faker->email(),
            'salary' => mt_rand(10000,100000),
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),



        ];
    }
}
