<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class Instansi extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "kode_instansi" => Str::random(5),
            "nama_instansi" => $this->faker->name,
            "alamat" => $this->faker->phoneNumber,
            "koordinat" => $this->faker->latitude(0.5, 101.4),
            'username'    => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "pin" => "1234",
            "code_reference" => Str::random(40),
            "role" => "instansi",
        ];
    }
}
