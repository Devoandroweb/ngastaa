<?php

namespace Database\Factories\Pegawai;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai\RiwayatPmk>
 */
class RiwayatPmkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "nip"=>"001000",
            "jenis_pmk"=>"negeri",
            "instansi"=>$this->faker->company(),
        ];
    }
}
