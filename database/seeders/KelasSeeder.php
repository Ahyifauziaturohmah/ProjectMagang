<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $UserData = [
            [
                'id'=>'1',
                'nama_kelas'=>'Copy Writer',
            ],
            [
                'id'=>'2',
                'nama_kelas'=>'Web Developer Fullstack',
            ],
            [
                'id'=>'3',
                'nama_kelas'=>'Web Developer Laravel',
            ],
        ];

        foreach($UserData as $key => $val){
            Kelas::create($val);
        }
    
    }
}
