<?php

use Illuminate\Database\Seeder;

class SentinelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
        	
            /*$user = Sentinel::register([
                    'id'    => 15,
                    'email' => 'administrator@gmail.com',
                    'username' => 'administrator',
                    'password'  => 'suadmin',
                    'first_name'    => 'Super',
                    'last_name'     => 'Administrator',
                ], true);*/

                /*$user = App\Models\User::whereIn('id', ['2','5','6','7','8','9','10','11','12'])->update([
                    'password'  => bcrypt('demo'),
                ], true);*/
            
            /*$user = App\Models\User::whereIn('id', ['13','13'])->update([
                    'password'  => bcrypt('suadmin'),
                ], true);*/

            $user = App\Models\User::whereIn('id', ['1'])->update([
                    'password'  => bcrypt('demoadmin'),
                ], true);

        } catch (Exception $e) {
        	print "Error Exception ";
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
