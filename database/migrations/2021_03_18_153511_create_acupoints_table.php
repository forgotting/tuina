<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcupointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acupoints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('body_x');
            $table->integer('body_y');
            $table->integer('ear_x');
            $table->integer('ear_y');
            $table->enum('parts', ['body', 'ear']);
            $table->tinyInteger('is_enabled')->default(1);
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
        Schema::dropIfExists('acupoints');
    }
}
