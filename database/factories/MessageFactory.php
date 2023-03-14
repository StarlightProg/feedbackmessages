<?php

namespace Database\Factories;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeFileName = Str::random(15);
        Storage::putFileAs('messages',UploadedFile::fake()->image(fake()->name()),$fakeFileName);
        return [
            'theme' => fake()->name(),
            'message' => fake()->realText(50),
            'file' => Storage::url($fakeFileName),
            'user_id' => random_int(2,11)
        ];
    }
}
