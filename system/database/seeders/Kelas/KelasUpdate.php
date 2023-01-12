<?php
// php artisan db:seed --class=Database\Seeders\Orantua\OrantuaUpdate
namespace Database\Seeders\Orantua;

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

class OrantuaUpdate extends Seeder
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
            $request = new \Illuminate\Http\Request();
            $events = $faker->dateTimeBetween('-30 days', '+30 days');
            $get_ortu = \App\Models\OrangTua::where("instansi_id", $value->id)->get();
            foreach ($get_ortu as $k => $v) {
                $ortu = new ManagementCrud("OrangTua");
                $ortu->setTesting();
                $orantua =  $request->replace([
                    "kode_instansi" => $value->kode_instansi,
                    "instansi_id" => $value->id, // di isi hanya pada testing, value ini akan terisi by auth
                    "nama_lengkap" => $faker->name,
                    "jenis_kelamin" => $faker->randomElement(['LAKI-LAKI', 'PEREMPUAN']),
                    "tempat_lahir" => $faker->address,
                    "tanggal_lahir" => $events->format('Y-m-d'),
                    "alamat_lengkap" => $faker->address,
                    "no_telepon" => $faker->phoneNumber(),
                    "agama" => "Islam",
                    "provinsi" => "Riau",
                    "kabupaten" => "Kuantan Singingi",
                    "kecamatan" => "Kuantan Tengah",
                    "kelurahan" => "desa dummy",
                    'username'    => $faker->userName,
                    'email' => $faker->unique()->safeEmail(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    "pin" => "1234",
                    "code_reference" => Str::random(40),
                    "role" => "orangtua",
                ]);
                $id = $v->id;
                $ortu->generate_data_update($orantua, $id);
            }
        }
    }
}
