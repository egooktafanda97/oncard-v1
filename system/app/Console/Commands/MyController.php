<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MyController extends GeneratorCommand
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
    protected $signature = 'make:mycontroller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Controller.';

    protected $type = 'controller';

    // public function __construct()
    // {
    //     $this->rootNamespace(base_path());
    // }

    protected function getStub()
    {
        return __DIR__ . '/stubs/mycontroller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . "\Http\Controllers\api\Controll";
    }
    public function config($class)
    {
        return $this->config = json_decode(file_get_contents(app_path("Crud/" . $class . ".json")), true);
    }

    public function UseNameSpaceString($arr)
    {
        $str = "";
        foreach ($arr as $value) {
            $str .= "Use " . $value . ";";
        }
        return $str;
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        $config = $this->config($class);
        $stet = str_replace('{{ useModel }}', $this->UseNameSpaceString($config['useModel']), $stub);
        $stet = str_replace('{{ class }}', $class,  $stet);
        return $stet;
    }
}
