<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Buku,
    Kategori,
    BukuKategori
};
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function index(){
        $bukus = Buku::get();
        $kategoris = Kategori::get();
        return view('main', compact('bukus', 'kategoris'));
    }

    public function store(Request $request){
        $request->validate([
            'judul' => 'required',
            // 'penulis' => 'required',
            // 'penerbit' => 'required',
            // 'genre' => 'required',
        ]);

        $path = Storage::disk('public')->putFile('foto', $request->file('foto'));

        $buku = Buku::create([
            'judul' => $request['judul'],
            'penulis' => $request['penulis'],
            'penerbit' => $request['penerbit'],
            'genre' => $request['genre'],
            'foto' => $path,
        ]);
        
        if ($request->has('kategori')) {
            foreach ($request['kategori'] as $kategoriId) {
                BukuKategori::create([
                    'bukus_id' => $buku->id,
                    'kategoris_id' => (int) $kategoriId
                ]);
            }
        }
        return redirect('/')->with('status', 'Buku Created!');
    }

    public function update(Request $request, Buku $buku){
        $request->validate([
            'judul' => 'required',
            // 'penulis' => 'required',
            // 'penerbit' => 'required',
            // 'genre' => 'required',
        ]);

        if($request->has('foto')){
            $path = Storage::disk('public')->putFile('foto', $request->file('foto'));
            $buku->foto = $path;
        }

        $buku->judul = $request['judul'];
        $buku->penulis = $request['penulis'];
        $buku->penerbit = $request['penerbit'];
        $buku->genre = $request['genre'];
        $buku->save();
        
        BukuKategori::where('bukus_id', $buku->id)->delete();

        if ($request->has('kategori')) {
            foreach ($request['kategori'] as $kategoriId) {
                BukuKategori::create([
                    'bukus_id' => $buku->id,
                    'kategoris_id' => (int) $kategoriId
                ]);
            }
        }
        return redirect('/')->with('status', 'Buku Updated!');
    }

    public function destroy(Buku $buku) {
        BukuKategori::where('bukus_id', $buku->id)->delete();
        $buku->delete();
        
        return redirect('/')->with('status', 'Buku Deleted!');
    }
}
