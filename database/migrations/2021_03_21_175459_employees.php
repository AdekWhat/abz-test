<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Employees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('employees', function (Blueprint $table) {
              $table->id();
              $table->string('full_name');
              $table->foreignId('position')->constrained('positions')->onDelete('cascade');
              $table->date('employment_date');
              $table->smallInteger('hierarchy');
              $table->longText('phone_number');
              $table->string('email');
              $table->foreignId('head_id')->nullable()->unsigned()->constrained('employees')->change();
              $table->double('salary', 11, 2);
              $table->string('image_url', 80)->nullable();
              $table->timestamps();
          });


      }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
