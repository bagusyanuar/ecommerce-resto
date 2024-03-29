@extends('admin.layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif

    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Menu Makanan & Minuman</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/product">Menu Makanan & Minuman</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-sm-11">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="/product/create" enctype="multipart/form-data">
                                @csrf
                                <div class="w-100 mb-1">
                                    <label for="nama" class="form-label">Nama Menu</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Menu"
                                           name="nama">
                                </div>
                                <div class="form-group w-100 mb-1">
                                    <label for="kategori">Kategori Menu</label>
                                    <select class="form-control" id="kategori" name="kategori">
                                        <option value="">--pilih kategori--</option>
                                        @foreach($data as $v)
                                            <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="harga" class="form-label">Harga Menu</label>
                                    <input type="number" class="form-control" id="harga" placeholder="Harga Menu"
                                           name="harga" value="0">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="qty" class="form-label">Porsi</label>
                                    <input type="number" class="form-control" id="qty" placeholder="Porsi Menu"
                                           name="qty" value="0">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="deskripsi" class="form-label">Deskripsi Menu</label>
                                    <textarea type="text" class="form-control" id="deskripsi" placeholder="Deskripsi Menu"
                                              name="deskripsi" rows="3"></textarea>
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="gambar" class="form-label">Gambar Menu</label>
                                    <input type="file" class="form-control" id="gambar" placeholder="Gambar Menu"
                                           name="gambar">
                                </div>
                                <div class="w-100 mb-2 mt-3 text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
