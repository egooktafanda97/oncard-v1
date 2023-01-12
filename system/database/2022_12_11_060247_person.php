<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Person extends Migration
{
    public $filds = [];
    public function __construct()
    {
        $this->filds = json_decode(file_get_contents(app_path("Crud/Person.json")), true);
    }
    public function up()
    {
        $table = $this->filds['table'];
        $migrates = $this->filds['migration'];
        Schema::create($table, function (Blueprint $table) use ($migrates) {
            $table->bigIncrements('id');
            foreach ($migrates as $key => $value) {
                if (!empty($value['size'])) {
                    $table->{$value['type']}($key, $value['size']);
                } else {
                    $table->{$value['type']}($key);
                }
            }
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
