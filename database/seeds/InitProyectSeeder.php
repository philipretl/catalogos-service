<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class InitProyectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@nuestroscatalogos.com',
            'phone' => '3012017499',
            'password' => Hash::make('12345678'),

        ]);

        DB::table('users')->insert([
            'name' => 'Sandra Noguera',
            'email' => 'sandra@nuestroscatalogos.com',
            'phone' => '3122081524',
            'password' => Hash::make('12345678'),

        ]);

        $roles = [
            'admin',
            'seller',
            'user',
            'zone_leader'
        ];

        foreach ($roles as $rol) {
            Role::create(['guard_name' => 'api', 'name' => $rol]);
        }

        $user = User::where('email', 'admin@nuestroscatalogos.com')->first();
        $user->assignRole('admin');

        $user = User::where('email', 'sandra@nuestroscatalogos.com')->first();
        $user->assignRole('seller');
    }
}
