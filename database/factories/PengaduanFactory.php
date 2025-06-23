<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'mahasiswa_id' => 1,
            'isi_pengaduan' => $this->faker->sentence(10),
            'foto' => 'foto-pengaduan/default.png',
            'status' => 'proses'
        ];
    }
}
