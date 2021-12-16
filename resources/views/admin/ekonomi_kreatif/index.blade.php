@extends('admin.layouts.app')
@section('title', 'Ekonomi Kreatif')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ekonomi Kreatif</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Ekonomi Kreatif</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <a href="{{ route('admin.ekonomi-kreatif.create') }}" class="btn btn-primary">Tambah Data</a>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="table1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:2%">No</th>
                                            <th style="width:10%">Thumbnail</th>
                                            <th style="width:10%">Kategori</th>
                                            <th style="width:10%">Produk</th>
                                            <th style="width:10%">Harga</th>
                                            <th style="width:10%">Lokasi</th>
                                            <!-- <th style="width:18%">Keterangan</th> -->
                                            <th style="width:10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ekonomi_kreatif as $i => $d)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td><img src="{{ $d->thumbnail_ekonomi_kreatif }}"
                                                        alt="{{ $d->thumbnail_ekonomi_kreatif }}" class="img-fluid"
                                                        width="100px"></td>
                                                <td>{{ $d->kategori->nama_kategori_kreatif }}</td>
                                                <td>{{ $d->nama_ekonomi_kreatif }}</td>
                                                <td>{{ number_format($d->harga) }}</td>
                                                <td>
                                                    <iframe width="300" height="170" frameborder="0" scrolling="no"
                                                        marginheight="0" marginwidth="0"
                                                        src="https://maps.google.com/maps?q=<?= $d->lat ?>,<?= $d->long ?>&hl=in&z=14&amp;output=embed"></iframe>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.ekonomi-kreatif.detail', $d->id) }}"
                                                        style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="{{ route('admin.ekonomi-kreatif.edit', $d->id) }}"
                                                        style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i
                                                            class="fas fa-edit"></i></a>
                                                    <button onclick="hapus('<?= $d->id ?>')" style="width:40px; margin-top:5px"
                                                        class="btn btn-info btn-sm"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->

    <!-- Modal tambah fasilitas -->
    <div class="modal fade" id="tambahfasilitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="title">Tambah Fasilitas</div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var harga = new AutoNumeric('#harga', {
            currencySymbol: 'Rp.',
            decimalCharacter: ',',
            digitGroupSeparator: '.',
        });

        function tampil() {
            $('#tampilFoto').html(`<img src="../img/noimages.png" width="60%"/>`)
            $('#addDestinasiWisata').modal('show')
            $('#title').html('Tambah Akomodasi')
        }

        var map = L.map('map').setView([0, 0], 13);
        var marker = L.marker([0, 0]).addTo(map);
        var popup = L.popup();
        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer);

        var controlSearch = new L.Control.Search({
            position: 'topright',
            layer: markersLayer,
            initial: false,
            zoom: 18,
            marker: false
        });



        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            // tileSize: 512,
            // zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoiZ2VtYWZhamFyMDkiLCJhIjoiY2t2cTZuNWN6MGVkNzJwcXBzdnlta2Q1aSJ9.6KTCVYzFPCs6Qwn6WyVazw'
        }).addTo(map);

        function klik(e) {
            // alert("kordiant" + e.latlng.lat);
            popup
                .setLatLng(e.latlng)
                .setContent(e.latlng.toString())
                .openOn(map);
            if (marker) {
                map.removeLayer(marker);
            }
            $('#lat').val(e.latlng.lat)
            $('#lng').val(e.latlng.lng)
            // marker.setLatLng(e.latlng);
            marker = new L.Marker(e.latlng).addTo(map);
        }

        function showLocation() {

            // pas lokasi basobok, jalankan kode yg ado didalam function ko
            var geolocation = navigator.geolocation.getCurrentPosition(function(pos) {
                // kode dibawah ko dijalankan pas posisi gps basobok
                var lat = pos.coords.latitude; // ambiak lat gps
                var lng = pos.coords.longitude; // ambiak lng gps
                map.addControl(controlSearch);
                map.setView([lat, lng]); // ubah tampilan posisi peta ke posisi gps
                marker.setLatLng([lat, lng]); // pindahkan posisi marker ke posisi gps
            });

        }

        map.on('click', klik);

        showLocation()

        function tampilfoto() {
            var fileInput = document.getElementById('thumbnail');
            var filePath = fileInput.value;
            var extensions = /(\.jpg|\.png)$/i;
            var ukuran = fileInput.files[0].size;
            if (ukuran > 1000000) {
                alert('ukuran terlalu besar. Maksimal 1MB')
                fileInput.value = '';
                document.getElementById('tampilFoto').innerHTML = '';
                return false;
            } else {
                if (!extensions.exec(filePath)) {
                    alert('Silakan unggah file yang memiliki ekstensi .jpg/.png.');
                    fileInput.value = '';
                    document.getElementById('tampilFoto').innerHTML = '';
                    return false;
                } else {
                    //Image preview
                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('tampilFoto').innerHTML = '<img src="' + e.target.result +
                                '" width="60%"/>';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }
        }

        function hapus(id) {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if (pesan) {
                $.ajax({
                    url: "{{ route('admin.ekonomi-kreatif.index') }}/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    data: {
                        'id': id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.pesan == 'berhasil') {
                            window.location.reload();
                        }
                    }
                })
            }
        }
    </script>
@endpush
