<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
	$tags = ['nudle', 'handle', 'idol', 'doll', 'ladle'];
        foreach ($tags as $tag) App\Tag::create(['name' => $tag]);

        DB::table('users')->truncate();
        DB::table('users')->insert([
          [
            'name' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => bcrypt('testuser0123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ],
          [
            'name' => '阿戸　民',
            'email' => '175b005gp12@gmail.com',
            'password' => bcrypt('adminadmin'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
          ]
        ]);

    }
}
