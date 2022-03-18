<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //colum values

            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'website' => $this->faker->domainName,
            'email' => $this->faker->email,
            //'user_id' => User::factory()
            'user_id' => User::pluck('id')->random()
        ];
    }
}
