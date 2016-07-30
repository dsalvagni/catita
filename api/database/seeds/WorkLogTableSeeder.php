<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\User;
use Faker\Factory as Faker;

class WorkLogTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            \App\Models\WorkLog::create([
                'description' => $faker->text,
                'started_at' => $faker->dateTimeBetween('+0 days +0 hours', '+10 days +4 hours'),
                'finished_at' => $faker->dateTimeBetween('+10 days +5 hours', '+20 days +23 hours'),
                'user_id' => App\Models\User::find(rand(1,2))->id
            ]);
        }

    }
}