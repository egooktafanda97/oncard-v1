<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Service\Control\Controller as ControlSource;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $pathJson =  config('generator_crud_config.scema_path');
        $migrate = new ControlSource("User");
        $migrate->instance($pathJson);
        Schema::create('users', function (Blueprint $table) use ($migrate) {
            $migrate->migration($table);
            $table->rememberToken();
            $table->timestamps();
            if ($migrate->getSoftDeletesStatus())
                $table->softDeletes();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
