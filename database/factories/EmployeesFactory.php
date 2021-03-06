<?php

namespace Database\Factories;

use App\Models\Employees;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Propaganistas\LaravelPhone\PhoneNumber;

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
      $hierarchy = mt_rand(1,5);
      if($hierarchy > 1){
      $head = Employees::where('hierarchy',$hierarchy-1)->get()->pluck('id')->random();
      }else{
          $head = null;
      }

        return [

            'full_name' => $this->faker->name(),
            'position' =>$this->faker->randomElement($position),
            'employment_date' => $this->faker->date(),
            'hierarchy' => $hierarchy,
            'head_id' =>  $head,
            'phone_number' => $this->faker->e164PhoneNumber(),
            'email' => $this->faker->email(),
            'salary' => mt_rand(1000,100000),




        ];
    }

    //  Try to develop binary tree
    // public function tresTree()
    // {
    //   if Employees.count < 1 :
    //     set first employee
    //   func dfs($db_copy, start_emp_id, visited_arr)
    //   {
    //
    //   }
    //
    //
    //
    // }

}
