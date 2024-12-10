<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(), 
            'path' => 'files/LXx3hmNGSZLhlWS0vKiAzgfaAEGwIjkcuEq0KaXj.svg', 
            'extension' => 'svg',
            'size' => '2345',
        ];
    }
}
