<?php

use Illuminate\Database\Seeder;
use Modules\User\Entities\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create([
          'name' => 'Ruver Dornelas',
          'email' => 'ruverd@gmail.com',
          'phone' => '240-360-6361',
          'admin' => true,
          'password' => Hash::make('Walnut80#'),
        ]);

        factory(User::class)->create([
            'name' => 'Fernanda Salvanha',
            'email' => 'nandasalvanha@gmail.com',
            'phone' => '240-360-6360',
            'admin' => true,
            'password' => Hash::make('33843401'),
          ]);
    }
}
