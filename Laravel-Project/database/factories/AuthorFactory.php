<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Author::class;
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'surname' => fake()->name(),
        ];
    }
    public function withUser($id)
    {
        return $this->state([
            'user_id' => $id
        ]);
    }
}
