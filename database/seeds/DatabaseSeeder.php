<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run(){
       static $password;
       foreach (range(1,10) as $index) {
       $faker = Faker::create();
       $name = $faker->name;

       $avatarLocation = 'images/profiles/default/';
       $avatarArray = array('blue','red','yellow','green','purple');
       shuffle($avatarArray);
       $avatar = $avatarArray[0];
       $fileUrl = $avatarLocation . $avatar . '.jpg';

       DB::table('users')->insert([
           'name' => $name,
           'email' => $faker->unique()->safeEmail,
           'slug' => str_slug($name),
           'avatar' => $fileUrl,
           'password' => $password ?: $password = bcrypt('secret'),
           'remember_token' => str_random(10),
           'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);
       DB::table('profiles')->insert([
           'user_id' => $index,
           'location' => $faker->city,
           'about' => $faker->text($maxNbChars = 200),
           'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);
       DB::table('projects')->insert([
           'user_id' => $index,
           'name' => $faker->company,
           'description' => $faker->catchPhrase,
           'source' => $faker->domainName,
           'slug'=> str_slug($faker->company),
           'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);
       DB::table('statuses')->insert([
           'project_id' => $faker->numberBetween($min = 1, $max = 10),
           'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
           'image' => $faker->imageUrl(200, 200, 'cats'),
           'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);
       DB::table('statuses')->insert([
           'project_id' => $faker->numberBetween($min = 1, $max = 10),
           'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
           'image' => $faker->imageUrl(200, 200, 'cats'),
           'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
           'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
       ]);
      }
     }
}
