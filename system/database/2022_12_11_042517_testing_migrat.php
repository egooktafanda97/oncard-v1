<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {{class}} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $filds = [];
    public function __construct()
    {
        $this->filds = json_decode(file_get_contents(base_path("Crud/" . $class . ".json")), true)['migration'];
    }
    public function up()
    {
        Schema::create({{table}}, function (Blueprint {{table}}) {
            $table->bigIncrements('id');
            foreach ($filds as $key => $value) {
                if(!empty($value['size'])){
                    $table->{$value['type']}($key,$value['size']);
                }else{
                    $table->{$value['type']}($key)
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
