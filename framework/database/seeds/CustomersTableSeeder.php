<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 2000;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('customer')->insert([ //,
                'name' => $faker->unique()->name,
                'address' => $faker->address,
                'city' => $faker->city,
                'zip_code' => $faker->postcode,
                'email' => $faker->unique()->email,
            ]);
        }
    }
}
