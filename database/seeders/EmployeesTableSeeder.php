<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employees;
use App\Models\Positions;
use Carbon\Carbon;
use Propaganistas\LaravelPhone\PhoneNumber;
use Faker\Generator;
use Illuminate\Support\Facades\DB;
use Illuminate\Container\Container;
use Illuminate\Support\Str;




class EmployeesTableSeeder extends Seeder
{

  protected $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */

     public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }



    public function run()
    {
        DB::table('positions') ->insert([
          'name' => $this->faker->jobTitle(),
        ],
      );

      for ($i = 1; $i < 6; $i++)
      {
        DB::table('employees') ->insert([
          'full_name' => $this->faker->name(),
          'position' => 1,
          'employment_date' => $this->faker->date(),
          'hierarchy' => $i,
          'head_id' =>  $head_id = $i == 1 ? Null : $i - 1,
          'phone_number' => $this->faker->e164PhoneNumber(),
          'email' => $this->faker->email(),
          'salary' => mt_rand(1000,100000),
        ],
      );
    }
  }
}
