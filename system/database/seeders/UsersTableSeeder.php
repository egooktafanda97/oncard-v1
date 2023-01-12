<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
// use App\Models\RegisterGis;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_super_admin = Role::create(['guard_name' => 'api', 'name' => 'super-admin']);
        $_admin = Role::create(['guard_name' => 'api', 'name' => 'admin']);
        $faker = \Faker\Factory::create();
        $s_admin = User::create([
            "kode_instansi" => Str::random(5),
            'username'    => "super_admin",
            'email' => "super_admin@gmail.com",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "pin" => "1234",
            "code_reference" => Str::random(40),
            "role" => "instansi",
        ]);
        $s_admin->assignRole($_super_admin);

        $admin = User::create([
            "kode_instansi" => Str::random(5),
            'username'    => "admin",
            'email' => "admin@gmail.com",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "pin" => "1234",
            "code_reference" => Str::random(40),
            "role" => "instansi",
        ]);
        $admin->assignRole($_admin);
    }
}



// // reset cahced roles and permission
// app()[PermissionRegistrar::class]->forgetCachedPermissions();

// // create permissions
// Permission::create(['name' => 'view posts']);
// Permission::create(['name' => 'create posts']);
// Permission::create(['name' => 'edit posts']);
// Permission::create(['name' => 'delete posts']);
// Permission::create(['name' => 'publish posts']);
// Permission::create(['name' => 'unpublish posts']);

// //create roles and assign existing permissions
// $writerRole = Role::create(['name' => 'writer']);
// $writerRole->givePermissionTo('view posts');
// $writerRole->givePermissionTo('create posts');
// $writerRole->givePermissionTo('edit posts');
// $writerRole->givePermissionTo('delete posts');

// $adminRole = Role::create(['name' => 'admin']);
// $adminRole->givePermissionTo('view posts');
// $adminRole->givePermissionTo('create posts');
// $adminRole->givePermissionTo('edit posts');
// $adminRole->givePermissionTo('delete posts');
// $adminRole->givePermissionTo('publish posts');
// $adminRole->givePermissionTo('unpublish posts');

// $superadminRole = Role::create(['name' => 'super-admin']);
// // gets all permissions via Gate::before rule

// // create demo users
// $user = User::factory()->create([
//     'name' => 'Example user',
//     'email' => 'writer@qadrlabs.com',
//     'password' => bcrypt('12345678')
// ]);
// $user->assignRole($writerRole);

// $user = User::factory()->create([
//     'name' => 'Example admin user',
//     'email' => 'admin@qadrlabs.com',
//     'password' => bcrypt('12345678')
// ]);
// $user->assignRole($adminRole);

// $user = User::factory()->create([
//     'name' => 'Example superadmin user',
//     'email' => 'superadmin@qadrlabs.com',
//     'password' => bcrypt('12345678')
// ]);
// $user->assignRole($superadminRole);