<?php
// php artisan db:seed --class=Database\Seeders\Kantin\KantinUpdate
namespace Database\Seeders\Kantin;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kantin;
use App\Traits\ManagementRoler;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Service\Control\ManagementCrud;

class KantinUpdate extends Seeder
{
    use ManagementRoler;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_data = new ManagementCrud("Kantin");
        $pathJson =  config('generator_crud_config.scema_path');
        $_data->instance($pathJson);
        $_data->setNameSpaceModel("\App\Models\\");
        $_data->setTesting();
        $faker = \Faker\Factory::create();
        $kantin = Kantin::all();
        foreach ($kantin as $key => $value) {
            $request = new \Illuminate\Http\Request();
            $_kantin =  $request->replace([
                "kode_instansi" => $value->kode_instansi,
                "instansi_id" => $value->id, // di isi hanya pada testing, value ini akan terisi by auth
                "nama_kantin" => $faker->name . "-update",
                "pemilik_kantin" => $faker->name,
                "alamat_lengkap" => $faker->address,
                "no_telepon" => $faker->phoneNumber(),
                "alamat_lengkap" => $faker->address,
                "keterangan"    => $faker->realText(80),
                "kelurahan" => "desa dummy",
                'username'    => $faker->userName,
                'email' => $faker->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                "pin" => "1234"
            ]);
            $id = $value->id;
            $up = $_data->generate_data_update($_kantin, $id);
        }
    }
}
