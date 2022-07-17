@extends('member.layout')

@section('content')
    <div id="overlay-loading">
        <div class="d-flex justify-content-center align-items-center" id="overlay-loading-child">
            <p class="font-weight-bold color-white">Sedang Menambah Keranjang....</p>
        </div>
    </div>
    <img src="{{ asset('/assets/icon/banner5.jpg') }}" style="width: 100%;" height="600">
    <div class="text-center mt-3 mb-3">
        <p class="font-weight-bold main-text-color" style="font-size: 24px; letter-spacing: 1px;">Menu Rumah Makan Apung
            Wanawisata</p>
    </div>
    <div class="pl-5 pr-5 pt-2 pb-2 mt-3" style="padding-left: 5rem !important; padding-right: 5rem; !important">
        <div class="w-100 mb-3">
            <ul class="nav nav-pills mb-3" id="myTab" role="tablist">
                @foreach($categories as $c)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="pills-tab-{{ $c->id }}" data-toggle="tab"
                           href="#tab-{{ $c->id }}" role="tab"
                           aria-controls="tab-{{ $c->id }}" aria-selected="true">{{ $c->nama }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content" id="myTabContent">
                @foreach($categories as $c)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="tab-{{ $c->id }}" role="tabpanel" aria-labelledby="home-tab">
                        <div class="d-flex mb-3">
                            <div class="flex-grow-1 mr-2">
                                <input type="text" class="form-control" id="filter-{{ $c->id }}" placeholder="Cari Menu....">
                            </div>
                            <div>
                                <a href="#" class="btn btn-success btn-search" data-id="{{ $c->id }}"><i
                                        class="fa fa-search mr-1"></i><span>Cari</span></a>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($c->barang as $v)
                                <div class="col-lg-3 col-md-4 mb-4">
                                    <div class="card card-item" data-id="{{ $v->id }}"
                                         style="cursor: pointer; height: 400px; border-color: #117d17">
                                        <img class="card-img-top" src="{{ asset('/assets/barang'). "/" . $v->gambar }}"
                                             alt="Card image cap" height="200">
                                        <div class="card-body" style="height: 200px">
                                            <p class="card-title font-weight-bold elipsis-one text-green">{{ $v->nama }}</p>
                                            <p class="text-green elipsis-two mb-0"
                                               style="color: #535961; font-size: 12px; height: 35px">{{ $v->deskripsi }}</p>
                                            <p class="font-weight-bold text-green" style="font-size: 20px;">
                                                Rp. {{ number_format($v->harga, 0, ',', '.') }}</p>
                                            <div class="d-flex w-100 justify-content-between align-items-center">
                                                <p class="text-green mb-0" style="color: #535961; font-size: 12px;">Stock
                                                    : {{ $v->qty }}</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row w-100">
            <div class="col-lg-2">
                <div class="card" style="border-color: #117d17">
                    <div class="card-header" style="background-color: #117d17 ">
                        <p class="font-weight-bold mb-0" style="color: whitesmoke; font-size: 18px">Kategori</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <li class="list-group-item">
                                <a href="/beranda/category/{{ $category->id }}"
                                   class="category-menu">{{ $category->nama }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="d-flex mb-3">
                    <div class="flex-grow-1 mr-2">
                        <input type="text" class="form-control" id="filter" placeholder="Cari Nama barang"
                               name="filter">
                    </div>
                    <div>
                        <a href="#" class="btn btn-success" id="btn-search"><i
                                class="fa fa-search mr-1"></i><span>Cari</span></a>
                    </div>
                </div>

                <div class="panel-product" id="panel-product">
                    <div class="row">
                        @foreach($data as $v)
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="card card-item" data-id="{{ $v->id }}"
                                     style="cursor: pointer; height: 400px; border-color: #117d17">
                                    <img class="card-img-top" src="{{ asset('/assets/barang'). "/" . $v->gambar }}"
                                         alt="Card image cap" height="200">
                                    <div class="card-body" style="height: 200px">
                                        <p class="card-title font-weight-bold elipsis-one text-green">{{ $v->nama }}</p>
                                        <p class="text-green elipsis-two mb-0"
                                           style="color: #535961; font-size: 12px; height: 35px">{{ $v->deskripsi }}</p>
                                        <p class="font-weight-bold text-green" style="font-size: 20px;">
                                            Rp. {{ number_format($v->harga, 0, ',', '.') }}</p>
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <p class="text-green mb-0" style="color: #535961; font-size: 12px;">Stock
                                                : {{ $v->qty }}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        function emptyElementProduct() {
            return '<div class="col-lg-12 col-md-12" >' +
                '<div class="d-flex align-items-center justify-content-center" style="height: 600px"><p class="font-weight-bold">Tidak Ada Produk</p></div>' +
                '</div>';
        }

        function singleProductElement(data) {
            return '<div class="col-lg-3 col-md-4 mb-4">' +
                '<div class="card card-item" data-id="' + data['id'] + '" style="cursor: pointer; height: 400px; border-color: #117d17">' +
                '<img class="card-img-top" src="/assets/barang/' + data['gambar'] + '" alt="Card image cap" height="200">' +
                '<div class="card-body" style="height: 200px">' +
                '<p class="card-title font-weight-bold elipsis-one text-green">' + data['nama'] + '</p>' +
                '<p class="text-green elipsis-two mb-0" style="color: #535961; font-size: 12px; height: 35px">' + data['deskripsi'] + '</p>' +
                '<p class="font-weight-bold text-green" style="font-size: 20px;">Rp. ' + formatUang(data['harga']) + '</p>' +
                '<div class="d-flex w-100 justify-content-between align-items-center">' +
                '<p class="text-green mb-0" style="color: #535961; font-size: 12px;">Stock : ' + data['qty'] + '</p>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        function createElementProduct(data) {
            let child = '';
            $.each(data, function (k, v) {
                child += singleProductElement(v);
            });
            return '<div class="row">' + child + '</div>';
        }

        async function getProductByName() {
            let el = $('#panel-product');
            el.empty();
            el.append(createLoader());
            let name = $('#filter').val();
            try {
                let response = await $.get('/beranda/product/data?name=' + name);
                el.empty();
                if (response['status'] === 200) {
                    if (response['payload'].length > 0) {
                        el.append(createElementProduct(response['payload']));
                        $('.card-item').on('click', function () {
                            let id = this.dataset.id;
                            window.location.href = '/beranda/product/' + id + '/detail';
                        });
                    } else {
                        el.append(emptyElementProduct());
                    }
                }
            } catch (e) {
                console.log(e);
            }
        }

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                console.log($(e.target).attr('id'));
            });
            $('.card-item').on('click', function () {
                let id = this.dataset.id;
                window.location.href = '/beranda/product/' + id + '/detail';
            });

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                getProductByName();
            })
        });
    </script>
@endsection
