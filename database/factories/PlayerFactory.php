<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'club_id' => function () {
                return ClubFactory::new()->create()->id;
            },
            'user_id' => function () {
                return UserFactory::new()->create()->id;
            },
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'dob' => $this->faker->date(),
            'photo' => $this->faker->imageUrl(),
        ];
    }
}
