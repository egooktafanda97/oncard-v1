<?php
// php artisan db:seed --class=Database\Seeders\Produk\Produk
namespace Database\Seeders\Produk;

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

class Produk extends Seeder
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
            $__produk = new ManagementCrud("Produk");
            $pathJson =  config('generator_crud_config.scema_path');
            $__produk->instance($pathJson);
            $__produk->setNameSpaceModel("\App\Models\\");
            $__produk->setTesting();

            $request = new \Illuminate\Http\Request();
            $events = $faker->dateTimeBetween('-30 days', '+30 days');
            $kantin = \App\Models\Kantin::all();
            foreach ($kantin as $key => $vasls) {
                for ($i = 0; $i < 15; $i++) {
                    $_prod =  $request->replace([
                        "kode_instansi" => $value->kode_instansi,
                        "instansi_id" => $value->id, // di isi hanya pada testing, value ini akan terisi by auth
                        "user_id" => $vasls->users->id,
                        "nama" => $faker->name,
                        "jenis" => $faker->name,
                        "kategori" => $faker->name,
                        "harga" => "'" . $faker->randomDigit . "'",
                        "satuan" => $faker->randomElement(['dus', 'pcs', "pak"]),
                        "deskripsi" => $faker->realText(80),
                        // "gambar" => $faker->image('public/storage/images', 400, 300, null, false),
                        "stok" => 100,
                        "status" => true
                    ]);
                    // dd($_prod);
                    $pr = $__produk->generate_data_insert($_prod);
                    if (empty($pr['data']))
                        dd($pr);
                }
            }
        }
    }
}
