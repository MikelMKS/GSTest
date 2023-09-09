<?php

namespace Database\Factories;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    protected $model = Users::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->numerify('##########'),
            'token' => Str::random(140),
            'subscribed' => $this->faker->randomElement(['1','2','3','1,2','1,3','2,3','1,2,3']),
            'channels' => $this->faker->randomElement(['1','2','3','1,2','1,3','2,3','1,2,3']),
        ];
    }
}
