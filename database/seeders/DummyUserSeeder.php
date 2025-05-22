<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $UserData = [
            [
                'name'=>'Kak Mentor',
                'email'=>'mentor@winnicode.com',
                'role'=>'mentor',
                'password'=>bcrypt(('123456'))
            ],
            [
                'name'=>'Kak Magang',
                'email'=>'magang@winnicode.com',
                'role'=>'magang',
                'password'=>bcrypt(('123456'))
            ],
        ];

        foreach($UserData as $key => $val){
            User::create($val);
        }
    }
}
