<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = model('UserModel');
        $model->insert([
            'username' => 'admin',
            'useremail' => 'nurulfir@gmail.com',
            'userpassword' => password_hash('nurulfir28', PASSWORD_DEFAULT),
        ]);
    }
}
