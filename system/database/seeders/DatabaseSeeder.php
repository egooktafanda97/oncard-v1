<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // php artisan migrate:refresh --seed
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // \DB::unprepared(file_get_contents(storage_path("sql/wilayah.sql")));
        // referensi permision
        // https://spatie.be/docs/laravel-permission/v5/basic-usage/middleware


        $this->call([
            UsersTableSeeder::class,
            // \Database\Seeders\Instansi\InstansiCreate::class,
            // \Database\Seeders\Kelas\Kelas::class,
            // \Database\Seeders\Siswa\Siswa::class,
            // \Database\Seeders\Orantua\Orantua::class,
            // \Database\Seeders\Guru\Guru::class,
            // \Database\Seeders\Kantin\Kantin::class,
            // \Database\Seeders\Produk\Produk::class
        ]);
        $dir = new \DirectoryIterator(config('generator_crud_config.scema_path_dirname'));
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $f = explode(".", $fileinfo->getFilename());
                \Artisan::call('module:make-model ' . $f[0] . ' V1');
                \Artisan::call('module:make-controller ' . $f[0] . ' V1');
            }
        }


        $this->command->info('Country table seeded!');
    }
}
