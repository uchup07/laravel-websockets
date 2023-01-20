<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            'key' => Str::uuid(),
            'name' => 'Default',
            'secret' => bin2hex(random_bytes(32)),
            'host' => 'http://127.0.0.1',
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
        DB::table('clients')->insert([
            'key' => Str::uuid(),
            'name' => 'Vanilla Apps',
            'secret' => bin2hex(random_bytes(32)),
            'host' => 'http://rda.erajaya.com',
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
        DB::table('clients')->insert([
            'key' => Str::uuid(),
            'name' => 'ROP Apps',
            'secret' => bin2hex(random_bytes(32)),
            'host' => 'http://rda.erajaya.com',
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ]);
    }
}
