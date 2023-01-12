<?php
// php artisan db:seed --class=Database\Seeders\Kantin\Kantin
namespace Database\Seeders\Kantin;

use App\Models\Instansi;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Traits\ManagementRoler;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Service\Control\ManagementCrud;

class Kantin extends Seeder
{
    use ManagementRoler;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $instansi = Instansi::all();
        foreach ($instansi as $key => $value) {
            for ($i = 0; $i < 3; $i++) {
                $knt = new ManagementCrud("Kantin");
                $pathJson =  config('generator_crud_config.scema_path');
                $knt->instance($pathJson);
                $knt->setNameSpaceModel("\App\Models\\");
                $knt->setTesting();
                $request = new \Illuminate\Http\Request();
                $events = $faker->dateTimeBetween('-30 days', '+30 days');
                $_kantin =  $request->replace([
                    "kode_instansi" => $value->kode_instansi,
                    "instansi_id" => $value->id, // di isi hanya pada testing, value ini akan terisi by auth
                    "nama_kantin" => $faker->name,
                    "pemilik_kantin" => $faker->name,
                    "alamat_lengkap" => $faker->address,
                    "no_telepon" => $faker->phoneNumber(),
                    "alamat_lengkap" => $faker->address,
                    "keterangan"    => $faker->realText(80),
                    "kelurahan" => "desa dummy",
                    'username'    => $faker->userName,
                    'email' => $faker->unique()->safeEmail(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    "pin" => "1234",
                    "code_reference" => Str::random(40),
                    "role" => "kantin",
                ]);
                $kan = $knt->generate_data_insert($_kantin);
                if (empty($kan['data']))
                    dd($kan);
                if (!$roler = $this->newRole("api", "kantin"))
                    return false;
                $m = User::find($kan['data']['user_id']);
                $this->createRole($m, $roler);
            }
        }
    }
}
