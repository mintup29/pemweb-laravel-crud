<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class MainController extends Controller
{
    public function index(){
        $bukus = Buku::get();
        return view('main', compact('bukus'));
    }
}
