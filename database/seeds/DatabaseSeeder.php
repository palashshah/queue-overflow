<?php

use App\Model\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        User::create([
            'name'     =>   'Admin',
            'email'    =>   'admin@admin.com',
            'password' =>   bcrypt('secret'),
            'is_admin' =>   true,
            'status'   =>   true,
            'reputation'=>  '100'
        ]);

        User::create([
            'name'     =>   'Demo User',
            'email'    =>   'demo@user.com',
            'password' =>   bcrypt('secret'),
            'is_admin' =>   false,
            'status'   =>   true,
            'reputation'=>  '10'
        ]);

        factory(App\Model\Question::class, 100)->create();
        factory(App\Model\Answer::class, 250)->create();
        factory(App\Model\Tag::class, 50)->create();
        factory(App\Model\Comment::class, 50)->create();
    }
}
