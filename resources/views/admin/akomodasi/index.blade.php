@extends('admin.layouts.app')
@section('title', 'Akomodasi')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Akomodasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Akomodasi</li>
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
                            <a href="{{ route('admin.akomodasi.add') }}" class="btn btn-primary" >Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:2%">No</th>
                                            <th style="width:10%">Thumbnail</th>
                                            <th style="width:10%">Kategori</th>
                                            <th style="width:10%">Akomodasi</th>
                                            <th style="width:10%">Kelas</th>
                                            <th style="width:10%">Harga</th>
                                            <th style="width:10%">lokasi</th>
                                            <!-- <th style="width:18%">Keterangan</th> -->
                                            <th style="width:10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($akomodasi as $i => $a)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td><img src="{{ $a->thumbnail_akomodasi }}" alt="{{ $a->thumbnail_akomodasi }}" class="img-fluid" width="100px"></td>
                                            <td>{{$a->kategori->nama_kategori_akomodasi}}</td>
                                            <td>{{$a->nama_akomodasi}}</td>
                                            <td>{{$a->kelas}}</td>
                                            <td>Rp.{{number_format($a->harga)}}</td>
                                            <td>
                                                <iframe width="300" height="170" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?= $a->lat; ?>,<?= $a->long; ?>&hl=in&z=14&amp;output=embed"></iframe>
                                            </td>
                                            <td>
                                                <button onclick="visitorModal({{ $a->id }})" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-glasses"></i></button>
                                                <a href="{{ route('admin.akomodasi.detail', $a->id) }}" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                <button onclick="location.href='<?= route('admin.akomodasi.edit-page', $a->id) ?>'" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></button>
                                                <button onclick="hapus('<?= $a->id ?>')" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-trash"></i></button>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="addAkomoadasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="title"></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="">-PILIH KATEGORI-</option>
                                        @foreach($kategori as $a)
                                        <option value="{{$a->id}}">{{$a->nama_kategori_akomodasi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Akomodasi</label>
                                    <input type="text" id="akomodasi" class="form-control" placeholder="Akomodasi">
                                </div>
                                <div class="form-group">
                                    <label for="">Kelas</label>
                                    <input type="text" id="kelas" class="form-control" placeholder="Kelas">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipe</label>
                                    <input type="text" id="tipe" class="form-control" placeholder="Tipe">
                                </div>
                                <div class="form-group">
                                    <label for="">Harga</label>
                                    <input type="text" id="harga" class="form-control" placeholder="Harga">
                                </div>
                                <div class="form-group">
                                    <label for="">Thumbnail</label>
                                    <input type="file" name="thumbnail" id="thumbnail" onchange="return tampilfoto()" class="form-control">
                                    <input type="hidden" id="lat" class="form-control">
                                    <input type="hidden" id="lng" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div style="margin-top:30px" id="tampilFoto"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea name="" id="keterangan" class="note"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Lokasi</label>
                                    <div style="height: 337px;" id="map"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div align="right">
                        <button type="button" onclick="simpan()" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Dertail -->
    <div class="modal fade" id="visitorsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="title"></div>
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
    <!-- Modal Dertail -->
    <div class="modal fade" id="visitorsEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="title"></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    function reload_table_kunjungan(id) {
                        $('#visitorsModal .modal-body').load("{{ url('/') }}/admin/akomodasi/"+id+"/visitor");
                    }
                </script>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal fasilitas -->
    <div class="modal fade" id="addFasilitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="fastitle">Failitas</div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <button onclick="tambahFasilitas()" type="button" class="btn btn-primary">Tambah Fasilitas</button>
                        </div>
                        <div class="card-body">
                            <table id="table1" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Akomodasi</th>
                                        <th>Fasilitas</th>
                                        <th>Icon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="isiTabel"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            currencySymbol : 'Rp.',
            decimalCharacter : ',',
            digitGroupSeparator : '.',
        });

        function visitorModal(id) {
            $('#visitorsModal #title').text("Daftar Pengunjung");
            reload_table_kunjungan(id);
            // $.get("{{ url('/') }}/admin/akomodasi/"+id+"/visitor", (result) => {

            // })
            $('#visitorsModal').modal('show');
        }

        function tampil()
        {
            $('#tampilFoto').html(`<img src="../img/noimages.png" width="60%"/>`)
            $('#addAkomoadasi').modal('show')
            $('#title').html('Tambah Akomodasi')
        }

        function simpan()
        {
            var id = $('#id').val();
            var kategori = $('#kategori').val();
            var akomodasi = $('#akomodasi').val();
            var kelas = $('#kelas').val();
            var tipe = $('#tipe').val();
            var lat = $('#lat').val();
            var lng = $('#lng').val();
            var keterangan = $('#keterangan').val();
            var thumbnail = $('#thumbnail').prop('files')[0];
            let form_data = new FormData();

            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("_method", "POST");
            form_data.append("kategori", kategori);
            form_data.append("akomodasi", akomodasi);
            form_data.append("kelas", kelas);
            form_data.append("tipe", tipe);
            form_data.append("harga", harga.getNumber());
            form_data.append("lat", lat);
            form_data.append("lng", lng);
            form_data.append("keterangan", keterangan);
            form_data.append("thumbnail", thumbnail);
            form_data.append("id", id);

            $.ajax({
                type: "POST",
                url: '{{route("admin.akomodasi.tambah")}}',
                contentType: 'multipart/form-data',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(data) {
                    if(data.pesan == 'berhasil')
                    {
                        window.location.reload();
                    }
                }
            })
        }

        function edit(id)
        {
            const harga = AutoNumeric.getAutoNumericElement('#harga')

            $.ajax({
                url: '{{route("admin.akomodasi.edit")}}',
                dataType: "json",
                type: 'POST',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(res){
                    console.log(res);
                    $('#id').val(res.data.id_akomodasi);
                    $('#kategori').val(res.data.kategori_akomodasi_id);
                    $('#akomodasi').val(res.data.nama_akomodasi);
                    $('#kelas').val(res.data.kelas);
                    $('#tipe').val(res.data.tipe);
                    $('#lat').val(res.data.lat);
                    $('#lng').val(res.data.long);
                    $('#tampilFoto').html(`<img src="{{ asset('storage/thumbnail/${res.data.thumbnail_akomodasi}') }}" width="60%"/>`)
                    if (marker)
                    {
                        map.removeLayer(marker);
                    }
                    marker = new L.Marker([res.data.lat,res.data.long]).addTo(map);
                    $(".note").summernote("code", res.data.keterangan);
                    harga.set(res.data.harga);
                    $('#addAkomoadasi').modal('show')
                    $('#title').html('Edit Akomodasi')
                }
            })
        }

        function hapus(id)
        {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if(pesan){
                $.ajax({
                    url: "{{route('admin.akomodasi.delete')}}",
                    type:"POST",
                    dataType: "JSON",
                    data:{'id':id,"_token":"{{csrf_token()}}"},
                    success: function(data)
                    {
                        if(data.pesan == 'berhasil')
                        {
                            window.location.reload();
                        }
                    }
                })
            }
        }

        function fasilitas(id)
        {
            $.ajax({
                url: "{{route('admin.akomodasi.fasilitas')}}",
                type: "POST",
                dataType: "HTML",
                data: {'id': id, '_token': '{{csrf_token()}}'},
                success: function(res)
                {
                    $('#isiTabel').html(res)
                    $('#addFasilitas').modal('show');
                }
            })
        }

        function tambahFasilitas()
        {
            $('#tambahfasilitas').modal('show')
        }

        var map = L.map('map').setView([0,0], 13);
        var marker = L.marker([0,0]).addTo(map);
        var popup = L.popup();
        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer);

        var controlSearch = new L.Control.Search({
            position:'topright',
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
            var geolocation = navigator.geolocation.getCurrentPosition(function(pos){
                // kode dibawah ko dijalankan pas posisi gps basobok
                    var lat = pos.coords.latitude; // ambiak lat gps
                    var lng = pos.coords.longitude; // ambiak lng gps
                    map.addControl( controlSearch );
                    map.setView([lat,lng]); // ubah tampilan posisi peta ke posisi gps
                    marker.setLatLng([lat,lng]); // pindahkan posisi marker ke posisi gps
            });

        }

        map.on('click', klik);

        showLocation()

        function tampilfoto()
        {
            var fileInput = document.getElementById('thumbnail');
            var filePath = fileInput.value;
            var extensions = /(\.jpg|\.png)$/i;
            var ukuran = fileInput.files[0].size;
            if(ukuran > 1000000)
            {
                alert('ukuran terlalu besar. Maksimal 1MB')
                fileInput.value = '';
                document.getElementById('tampilFoto').innerHTML = '';
                    return false;
            }else{
                if(!extensions.exec(filePath)){
                    alert('Silakan unggah file yang memiliki ekstensi .jpg/.png.');
                    fileInput.value = '';
                    document.getElementById('tampilFoto').innerHTML = '';
                    return false;
                }else{
                    //Image preview
                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('tampilFoto').innerHTML = '<img src="'+e.target.result+'" width="60%"/>';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }
        }
    </script>
@endpush
