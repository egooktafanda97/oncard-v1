<?php
// php artisan db:seed --class=Database\Seeders\Siswa\SiswaUpdate
namespace Database\Seeders\Siswa;

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

class SiswaUpdate extends Seeder
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
            $data = new ManagementCrud("Siswa");
            $pathJson =  config('generator_crud_config.scema_path');
            $data->instance($pathJson);
            $data->setNameSpaceModel("\App\Models\\");
            $data->setTesting();

            $events = $faker->dateTimeBetween('-30 days', '+30 days');
            $data->setTesting();
            $data_siswa = \App\Models\Siswa::where("instansi_id", $value->id)->get();
            $indexs = 1;
            $_kelas = \App\Models\Kelas::whereInstansiId($value->id)->get();
            $__id_kls = "";
            foreach ($_kelas as $x => $xx) {
                if (rand(0, 1) == 1)
                    $__id_kls = $xx->id;
            }
            foreach ($data_siswa as $ky => $s_val) {
                $status = rand(0, 1);
                $us_siswa = [
                    "kode_instansi" => $value->kode_instansi,
                    "instansi_id" => $value->id,
                    "kelas_id" => $__id_kls,
                    "nama_lengkap" => $faker->name . " - " . "update",
                    "jenis_kelamin" => $faker->randomElement(['LAKI-LAKI', 'PEREMPUAN']),
                    "tempat_lahir" =>  $faker->address,
                    "tanggal_lahir" => $events->format('Y-m-d'),
                    "alamat_lengkap" => $faker->address,
                    "agama" => "Islam",
                    "provinsi" => "Riau",
                    "kabupaten" => "Kuantan Singingi",
                    "kecamatan" => "Kuantan Tengah",
                    "kelurahan" => "desa dummy",
                    "status_siswa" => "active",
                    'username'    => $faker->userName,
                    'email' => $faker->unique()->safeEmail(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    "pin" => "22202",
                    "code_reference" => Str::random(40),
                    "role" => "siswa",
                ];
                if (rand(0, 1) == 1) {
                    $get_ortu = \App\Models\OrangTua::whereId(rand(0, 20))->first();
                    if (!$get_ortu) {
                        $ortu = new ManagementCrud("OrangTua");
                        $pathJson =  config('generator_crud_config.scema_path');
                        $ortu->instance($pathJson);
                        $ortu->setNameSpaceModel("\App\Models\\");
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
                        $or = $ortu->generate_data_insert($orantua);
                        if (empty($or['data']))
                            dd($or);
                        if (!$roler = $this->newRole("api", "orangtua"))
                            return false;
                        $m = User::find($or['data']['user_id']);
                        $this->createRole($m, $roler);
                        $us_siswa += ["orangtua_id" => $or["data"]["id"]];
                    } else {
                        $us_siswa += ["orangtua_id" => $get_ortu->id];
                    }
                }
                $siswa = $request->replace($us_siswa);
                $id = $s_val->id;
                $data->generate_data_update($siswa, $id);
            }
        }
    }
}
