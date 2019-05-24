<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
       DB::table('users')->insert([
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
       ]);
       //' $2y$10$U71KoWDx3QkXRP4P24Sfd.W3et1CjnfAM4b7jntvxKRdcUyPEsPuK'
   }
}
