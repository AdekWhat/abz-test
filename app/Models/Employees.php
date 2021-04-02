<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employees extends Model
{
    use HasFactory;

    public $timestamps = false;



    public function __construct(array $attributes = array())
    {
    parent::__construct($attributes);


      $this->hierarchy = mt_rand(1,5);
      // $this->image_url = 'storage/default_avatars/1.jpg';


    }



    public static function employeesGet()
    {
      $employees = DB::table('employees')
        ->join('positions', 'positions.id', '=', 'employees.position')
        ->select('employees.*', 'positions.name')
        ->get()->toArray();

      return $employees;
    }

    public static function findEmployee($id)
    {
      $employee = DB::table('employees')
        ->join('positions', 'positions.id', '=', 'employees.position')
        ->select('employees.*', 'positions.name')
        ->where('employees.id', $id)
        ->get();

      return $employee;

    }


    public function position()
    {
      return $this->belongsTo(Position::class, 'name');
    }

      /**
    @var array
    **/
    protected $fillable = [
        'full_name',
        'image_url',
        'employment_date',
        'phone_number',
        'position',
        'email',
        'salary',
    ];

    /**
     @var array
    **/
    protected $hidden = [
      'position',
    ];


}
