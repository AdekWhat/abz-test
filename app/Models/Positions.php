<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;


    public $timestamps = false;

    
    public function assign()
    {
        return $this->hasMany(Employees::Class);

    }
    // public $timestamps = false;


    protected $fillable = [
        'name',
    ];



}
