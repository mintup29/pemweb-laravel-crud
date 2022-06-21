<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'penulis', 'penerbit', 'genre'];

    public function bukuKategoris(){
        return $this->hasMany(BukuKategori::class, 'bukus_id', 'id');
    }

    public function hasKategoriById($id){
        if($this->bukuKategoris->whereIn('kategoris_id', $id)->first()) {
            return true;
        }
        
        return false;
    }
}
