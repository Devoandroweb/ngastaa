<?php

namespace Database\Factories\Pegawai;

use App\Models\Pegawai\Keluarga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai\Keluarga>
 */
class KeluargaFactory extends Factory
{
    protected $model = Keluarga::class;
    public function definition()
    {
        return [
            "nip"=>"001000",
            "status"=>"suami/istri",
            "nama"=>$this->faker->name("woman"),
            "tempat_lahir"=>$this->faker->city(),
            "tanggal_lahir"=>$this->faker->date("Y-m-d"),
            "status_kehidupan"=>"hidup",
            "alamat"=>$this->faker->address(),
        ];
    }
}
