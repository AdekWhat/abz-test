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
              // $table->foreign('user_id')->references('id')->on('positions')->onDelete('cascade');
              $table->timestamp('employment_date');
              $table->smallInteger('hierarchy');
              // todo change phone number
              $table->longText('phone_number');
              $table->string('email');
              // TODO: change onDelete
              $table->foreignId('head_id')->nullable()->unsigned()->constrained('employees')->change()->onDelete('cascade');
              $table->double('salary', 11, 2);
              //$table->photo
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
        //
    }
}
