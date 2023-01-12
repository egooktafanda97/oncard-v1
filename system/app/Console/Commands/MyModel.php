<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MyModel extends GeneratorCommand
{
    /**
     * Execute the console command.
     *
     * @return int
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:mymodel {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service.';

    protected $type = 'class';

    protected function getStub()
    {
        return __DIR__ . '/stubs/mymodel.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }
    public function config($class)
    {

        return $this->config = json_decode(file_get_contents(app_path("Crud/" . $class . ".json")), true);
    }
    public function fildString($arr)
    {
        $str = "[";
        $inx = 0;
        foreach ($arr as $key => $value) {
            $inx++;
            $str .= "'" . $key . "'";
            $str .= $inx < count($arr) ? "," : "";
        }
        $str .= "]";
        return $str;
    }
    public function relationShipStrings($arr)
    {
        $str = "";
        foreach ($arr as $value) {
            $str .= "public function " . $value[0] . "(){ return " . "$" . "this->" .  $value[1] . "(" . $value[2] . ",'" . $value[3] . "');}";
        }
        return $str;
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        // echo $class;
        $config = $this->config($class);
        // Do string replacement
        if (!empty($config['relationShip'])) {
            $stet = str_replace('{{ relationShip }}', $this->relationShipStrings($config['relationShip']), $stub);
            $stet = str_replace('{{ class }}', $class, $stet);
        } else {
            $stet = str_replace('{{ class }}', $class, $stub);
        }
        return $stet;
    }
}
