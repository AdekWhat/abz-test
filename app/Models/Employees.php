<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;



class Employees extends Model
{
    use HasFactory;

    public $timestamps = true;



    // public function __construct(array $attributes = array())
    // {
    // parent::__construct($attributes);
    //
    //
    //   $this->hierarchy = mt_rand(1,5);
    //   $this->image_url = 'storage/default_avatars/1.jpg';
    //   dd("lol");
    //
    // }


    protected static function boot()
  {
      parent::boot();
      // $this->hierarchy = mt_rand(1,5);
      // $this->image_url = 'storage/default_avatars/1.jpg';

      static::deleting(function($model){
          $subordinates = Employees::where('head_id', $model->id)->get()->pluck("id")->toArray();
          // dd($subordinates);
          foreach($subordinates as $subordinate)
          {
            $new_head = Employees::where('hierarchy',$model->hierarchy)->get()->pluck('id')->random();

            Employees::where('id', $subordinate)->update(['head_id'=>$new_head]);
          }


      });
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
        ->leftJoin('employees as emp', 'emp.id', '=', 'employees.head_id')
        ->select('employees.*', 'positions.name as position_name', 'emp.full_name as head_name')
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
        'head_id'
    ];

    /**
     @var array
    **/
    protected $hidden = [
      'position',
    ];

    // public $casts = [
    //     'phone' =>  E164PhoneNumberCast::class.':UA',
    // ];


}
