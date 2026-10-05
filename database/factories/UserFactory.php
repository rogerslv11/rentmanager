<?php

namespace Database\Factories;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->numerify('(##) #####-####'),
            'is_active' => true,
            'is_super_admin' => false,
            'locale' => 'pt_BR',
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }

    public function superAdmin(): static
    {
        return $this->state(fn () => [
            'organization_id' => null,
            'is_super_admin' => true,
            'email' => 'admin@rentmanager.test',
        ]);
    }

    public function demo(): static
    {
        return $this->state(fn () => [
            'email' => 'demo@rentmanager.test',
            'password' => Hash::make('password'),
        ]);
    }
}
