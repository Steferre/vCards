<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker::create();
        $faker = $this->faker;

        for ($i=0; $i < 50; $i++) {
            $newRecord[$i] = $faker;

            DB::table('users')->insert([
                'name' => $newRecord[$i]->name(),
                'email' => $newRecord[$i]->email(),
                'password' => $newRecord[$i]->password(8, 12),
            ]);

            DB::table('promoters')->insert([
                'email_2' => $newRecord[$i]->email(),
                'phone' => $newRecord[$i]->phoneNumber(),
                'phone_2' => $newRecord[$i]->phoneNumber(),
                'role' => $newRecord[$i]->word(),
                'description' => $newRecord[$i]->text(50),
                'code' => $newRecord[$i]->randomNumber(5, true),
                'group' => $newRecord[$i]->randomLetter(),
                'userId' => ($i + 1),
            ]);

        }
    }
}
