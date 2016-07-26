<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\User;
use Faker\Factory as Faker;

class WorklogTagTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            (new \App\Models\WorkLog())->find($index)->tags()->attach([rand(1,3),rand(4,7),rand(8,10)]);
        }

    }
}