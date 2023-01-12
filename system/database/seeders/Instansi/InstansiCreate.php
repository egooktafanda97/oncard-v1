<?php

namespace Database\Seeders\Instansi;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Traits\ManagementRoler;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Service\Control\ManagementCrud;

class InstansiCreate extends Seeder
{
    use ManagementRoler;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = new ManagementCrud("Instansi");
        $pathJson =  config('generator_crud_config.scema_path');
        $data->instance($pathJson);
        $data->setNameSpaceModel("\App\Models\\");
        $data->setTesting();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 2; $i++) {
            $instansi = new \Illuminate\Http\Request();
            $instansi->replace([
                "kode_instansi" => Str::random(5),
                "nama_instansi" => $faker->name,
                "alamat" => $faker->address,
                "koordinat" => "'" . $faker->latitude(0.5, 101.4) . "'",
                'username'    => $faker->userName,
                'email' => $faker->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                "pin" => "1234",
                "code_reference" => Str::random(40),
                "role" => "instansi",
            ]);
            $s =  $data->generate_data_insert($instansi);
            if (!$roler = $this->newRole("api", "instansi"))
                return false;
            $m = User::find($s['data']['user_id']);
            $this->createRole($m, $roler);
        }
    }
}
