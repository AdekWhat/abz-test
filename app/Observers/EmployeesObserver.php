<?php

namespace App\Observers;

use App\Models\Employees;

class EmployeesObserver
{
  public function created(Employees $employees)
    {


        $employees->image_url = 'storage/default_avatars/1.jpg';
        $employees->save();
    }


}
