<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// *********************
use App\Service\Control\Controller as ControlSource;

class Kelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pathJson =  config('generator_crud_config.scema_path');
        $migrate = new ControlSource("Kelas");
        $migrate->instance($pathJson);
        Schema::create(strtoupper(from_camel_case('Kelas')), function (Blueprint $table) use ($migrate) {
            $migrate->migration($table);
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
        Schema::dropIfExists(strtoupper('Kelas'));
    }
}
