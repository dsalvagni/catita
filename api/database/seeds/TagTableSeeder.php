<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\User;
use Faker\Factory as Faker;

class TagTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            \App\Models\Tag::create([
                'description' => $faker->text,
                'user_id' => App\User::find(rand(1,2))->id
            ]);
        }

    }
}