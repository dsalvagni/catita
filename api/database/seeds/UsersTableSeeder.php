<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
             'name' => 'Daniel Salvagni',
             'email' => 'danielsalvagni@gmail.com',
             'password' => Hash::make('123secret')
         ]);

        User::create([
            'name' => 'Douglas Adams',
            'email' => 'adams@hitchhiker.com',
            'password' => Hash::make('greatsecret')
        ]);
    }
}