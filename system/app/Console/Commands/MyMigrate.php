<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MyMigrate extends GeneratorCommand
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
    protected $signature = 'make:mymigration {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Migate.';

    protected $type = 'migrations';

    // public function __construct()
    // {
    //     $this->rootNamespace(base_path());
    // }

    protected function getStub()
    {
        return __DIR__ . '/stubs/mymigrate.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . "\Database\migrations";
    }
    public function config($class)
    {
        return $this->config = json_decode(file_get_contents(app_path("Crud/" . $class . ".json")), true);
    }



    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);
        // echo $class;

        $config = $this->config($class);

        // Do string replacement
        // $stet = str_replace('{{ fild }}', $this->fildString($config['fild']), $stub);
        $stet = str_replace('{{ class }}', $class,  $stub);

        return $stet;
    }
}
