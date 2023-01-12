<?php
// php artisan db:seed --class=Database\Seeders\Kelas\Kelas
namespace Database\Seeders\Kelas;

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

class Kelas extends Seeder
{
    use ManagementRoler;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $kelas = [
        "I-A",
        "I-B",
        "I-C",
        "II-A",
        "II-B",
        "II-C",
        "III-A",
        "III-B",
        "III-C"
    ];
    public function run()
    {
        $faker = \Faker\Factory::create();
        $instansi = Instansi::all();
        $kls = new ManagementCrud("Kelas");
        $pathJson =  config('generator_crud_config.scema_path');
        $kls->instance($pathJson);
        $kls->setNameSpaceModel("\App\Models\\");
        $kls->setTesting();
        foreach ($instansi as $key => $value) {
            foreach ($this->kelas as $ks => $kl) {
                $request = new \Illuminate\Http\Request();
                $kelas =  $request->replace([
                    "kode_instansi" => $value->kode_instansi,
                    "instansi_id" => $value->id, // di isi hanya pada testing, value ini akan terisi by auth
                    "nama_kelas" => $kl,
                    "keterangan" => $faker->realText(180)
                ]);
                $or = $kls->generate_data_insert($kelas);
                if (empty($or['data']))
                    dd($or);
            }
        }
    }
}
