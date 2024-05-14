<?php

namespace Database\Factories\Pegawai;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai\RiwayatPendidikan>
 */
class RiwayatPendidikanFactory extends Factory
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
            "kode_pendidikan"=>$this->faker->randomNumber(5),
            "tanggal_lulus"=>$this->faker->date("Y-m-d"),
            "nomor_ijazah"=>$this->faker->randomNumber(),
            "nama_sekolah"=>$this->faker->company(),
            "is_akhir"=>1
        ];
    }
}
