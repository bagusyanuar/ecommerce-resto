@extends('member.layout')

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
    <div class="container-fluid mt-2" style="padding-left: 50px; padding-right: 50px; padding-top: 10px;">
        <ol class="breadcrumb breadcrumb-transparent mb-2">
            <li class="breadcrumb-item">
                <a href="/" class="category-menu">Beranda</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/transaksi" class="category-menu">Transaksi</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $data->no_transaksi }}
            </li>
        </ol>
        <hr>
        <div class="mt-5" style="min-height: 350px;">
            <div class="row mb-3">
                <div class="col-md-6 col-lg-8">
                    <img src="{{ asset('/assets/icon/profile.jpg') }}" width="500">
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-header" style="background-color: #461a0a">
                            <p class="font-weight-bold mb-0" style="color: whitesmoke; font-size: 18px">Detail
                                Profil</p>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="w-100 mb-1">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Username"
                                           name="username" value="{{ $data->username }}">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                           name="password">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Lengkap"
                                           name="nama" value="{{ $data->member->nama }}">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="no_hp" class="form-label">No. Hp</label>
                                    <input type="number" class="form-control" id="no_hp" placeholder="No. Hp"
                                           name="no_hp" value="{{ $data->member->no_hp }}">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea rows="3" class="form-control" id="alamat" placeholder="Alamat"
                                              name="alamat">{{ $data->member->alamat }}</textarea>
                                </div>
                                <hr>
                                <div class="w-100 mt-2">
                                    <button type="submit" class="btn btn-order w-100">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#table-data').DataTable();
        });
    </script>
@endsection
