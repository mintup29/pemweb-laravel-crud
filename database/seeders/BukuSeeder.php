<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buku::create([
            'judul' => 'Bintang',
            'penulis' => 'Tere Liye',
            'penerbit' => 'Gramedia Pustaka Utama',
            'genre' => 'Fiksi petualangan, Fantasi',
        ]);

        Buku::create([
            'judul' => 'Bumi',
            'penulis' => 'Tere Liye',
            'penerbit' => 'Gramedia Pustaka Utama',
            'genre' => 'Fiksi petualangan, Fantasi',
        ]);
        // Buku::firstOrCreate(
        //     ['judul' => 'Bintang'],
        //     ['penulis' => 'Tere Liye'],
        //     ['penerbit' => 'Gramedia Pustaka Utama'],
        //     ['genre' => 'Fiksi petualangan, Fantasi']
        // );

        // Buku::firstOrCreate(
        //     ['judul' => 'Komet'],
        //     ['penulis' => 'Tere Liye'],
        //     ['penerbit' => 'Gramedia Pustaka Utama'],
        //     ['genre' => 'Fiksi petualangan, Fantasi']
        // );
    }
}
