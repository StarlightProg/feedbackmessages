<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::fake('messages');

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('admin'),
        ]);

        \App\Models\User::where('name','admin')->get()[0]->assignRole(Role::where('name','admin')->get()[0]);
        
        \App\Models\User::factory(10)->create();
        \App\Models\Message::factory(500)->create();
        
    }
}
