<?php
// php artisan db:seed --class=Database\Seeders\Instansi\InstansiUpdate
namespace Database\Seeders\Instansi;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Instansi;
use App\Traits\ManagementRoler;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Service\Control\ManagementCrud;

class InstansiUpdate extends Seeder
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
        $instansi = Instansi::all();
        foreach ($instansi as $key => $value) {
            $request = new \Illuminate\Http\Request();
            $up_instansi = $request->replace([
                "kode_instansi" => Str::random(5),
                "nama_instansi" => $faker->name,
                "alamat" => $faker->phoneNumber,
                "koordinat" => "'" . $faker->latitude(0.5, 101.4) . "'",
                'username'    => $faker->userName,
                'email' => $faker->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                "pin" => "22202",
                "code_reference" => Str::random(40),
                "role" => "instansi",
            ]);
            $id = $value->id;
            $up = $data->generate_data_update($up_instansi, $id);
        }
    }
}
