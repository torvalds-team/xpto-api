<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Location extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('location', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->timestamp('created_at')->useCurrent();
        });
        $id_location = \DB::table('location')->insertGetId(['name' => 'PHPRio']);
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('price');
            $table->integer('id_location')->unsigned();
            $table->foreign('id_location')->references('id')->on('location');
            $table->timestamp('created_at')->useCurrent();
        });
        \DB::table('product')->insert([
            'name' => 'Camisa',
            'price' => 1000,
            'id_location' => $id_location
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('product');
        Schema::drop('location');
    }
}
