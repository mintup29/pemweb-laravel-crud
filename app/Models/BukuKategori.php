<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuKategori extends Model
{
    use HasFactory;

    protected $fillable = ['bukus_id', 'kategoris_id'];

    public function kategori(){
        return $this->hasOne(Kategori::class, 'id', 'kategoris_id');
    }
}
