<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dosenpa>
 */
class DosenpaFactory extends Factory
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

            'nama' => $this->faker->name,
            'nidn' => $this->faker->unique()->randomNumber(8),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'user_id' => 1,
            'foto' => 'foto-dosenpa/default.png',



        ];
    }
}
