<?php

namespace Database\Factories\Pegawai;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai\RiwayatOrganisasi>
 */
class RiwayatOrganisasiFactory extends Factory
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
            "nama_organisasi"=>$this->faker->company(),
            "jenis_organisasi"=>"struktur"
        ];
    }
}
