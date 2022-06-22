@extends('layouts.app')
@section('content')

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <title>Praktikum 10</title>
  </head>
  <body>
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <span class="navbar-brand mb-0 h1">Rak Buku</span>
        </nav>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="main">
            @auth
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success mt-4" data-toggle="modal" data-target="#tambahModal">
                    + Tambah Buku
                </button>
            @endauth
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Foto Cover</th>
                        @auth
                            <th scope="col">Aksi</th>
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bukus as $buku)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$buku->judul}}</td>
                            <td>{{$buku->penulis}}</td>
                            <td>{{$buku->penerbit}}</td>
                            <td>{{$buku->genre}}</td>
                            <td>
                                @foreach ($buku->bukuKategoris as $bukuKategori)
                                   - {{$bukuKategori->kategori->nama}} <br>
                                @endforeach
                            </td>
                            <td>
                                @if($buku->foto)
                                    <img src="{{Storage::url($buku->foto)}}" alt="foto" style="width: 100px; height: auto;">
                                @endif
                            </td>
                             @auth
                            <td>
                               
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#editModal{{$buku->id}}">Edit</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$buku->id}}">Delete</button>
                                    </div>
                                
                            </td>
                            @endauth
                        </tr>
                            
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" action="{{url('/buku/create')}}">
                        @csrf
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control {{$errors->has('judul') ? 'is-invalid' : ''}}" id="judul" placeholder="Masukkan Judul Buku" name="judul">
                             @if($errors->has('judul'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('judul') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <input type="text" class="form-control" id="penulis" placeholder="Masukkan Penulis" name="penulis">
                        </div>
                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" placeholder="Masukkan Penerbit" name="penerbit">
                        </div>
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <input type="text" class="form-control" id="genre" placeholder="Masukkan Genre" name="genre">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label> <br>
                            <select name="kategori[]" multiple="multiple" id="kategori" style="width:100%">
                                @foreach ($kategoris as $kategori)
                                    <option value="{{$kategori->id}}">{{$kategori->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto Cover</label>
                            <input type="file" class="form-control" id="foto" placeholder="Masukkan Foto" name="foto">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($bukus as $buku)
        <div class="modal fade" id="editModal{{$buku->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Buku</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" action="{{url('/buku/update/'.$buku->id)}}">
                        @csrf
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" value="{{$buku->judul}}" class="form-control {{$errors->has('judul') ? 'is-invalid' : ''}}" id="judul" placeholder="Masukkan Judul Buku" name="judul">
                             @if($errors->has('judul'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('judul') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <input type="text" value="{{$buku->penulis}}" class="form-control" id="penulis" placeholder="Masukkan Penulis" name="penulis">
                        </div>
                        <div class="form-group">
                            <label for="penerbit">Penerbit</label>
                            <input type="text" value="{{$buku->penerbit}}" class="form-control" id="penerbit" placeholder="Masukkan Penerbit" name="penerbit">
                        </div>
                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <input type="text" value="{{$buku->genre}}" class="form-control" id="genre" placeholder="Masukkan Genre" name="genre">
                        </div>
                        <div class="form-group">
                            <label for="kategori{{$buku->id}}">Kategori</label> <br>
                            <select name="kategori[]" multiple="multiple" id="kategori{{$buku->id}}" style="width:100%">
                                @foreach ($kategoris as $kategori)
                                    <option value="{{$kategori->id}}" {{$buku->hasKategoriById($kategori->id) ? 'selected' : ''}}>{{$kategori->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foto">Foto Cover</label>
                            <input type="file" class="form-control" id="foto" placeholder="Masukkan Foto" name="foto">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{$buku->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Apakah Anda yakin untuk menghapus buku?</h5>
                        <form method="POST" action="{{url('/buku/delete/'.$buku->id)}}">
                            @csrf
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('#kategori').select2();
        });
    </script>

    @foreach ($bukus as $buku)
    <script>
        $(document).ready(function() {
            $('#kategori'.$buku->id).select2();
        });
    </script>
    @endforeach
  </body>
</html>
@endsection