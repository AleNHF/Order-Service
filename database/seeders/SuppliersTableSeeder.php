<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 21) as $index) {
            DB::table('suppliers')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'cellphone' => $faker->phoneNumber,
                'company' => $faker->company,
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            ]);
        }
    }
}
