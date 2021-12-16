@extends('admin.layouts.app')
@section('title', 'Tambah Ekonomi Kreatif')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link type="text/css" rel="stylesheet"
        href="{{ url('/') }}/admin/assets/plugins/image-uploader/image-uploader.min.css">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Ekonomi Kreatif</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Ekonomi Kreatif</li>
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
                        <div class="card-body">
                            <form action="{{ route('admin.ekonomi-kreatif.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Kategori</label>
                                                    <button type="button" class="btn btn-primary float-right btn-sm mb-2" data-toggle="modal" data-target="#tambah-kategori">Tambah</button>
                                                    <select name="kategori" id="kategori" class="form-control select2bs4">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Produk</label>
                                                    <input type="text" name="ekonomi_kreatif" id="ekonomi_kreatif"
                                                        class="form-control" placeholder="Ekonomi Kreatif">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Harga</label>
                                                    <input type="text" name="harga" id="harga" class="form-control"
                                                        placeholder="Harga">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Thumbnail</label>
                                                    <input type="file" name="thumbnail" id="thumbnail"
                                                        onchange="return tampilfoto()" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Keterangan</label>
                                                    <textarea name="keterangan" id="keterangan" class="note"></textarea>
                                                </div>
                                            </div>

                                    <div class="col-md-6">
                                        <label for="">Galeri Foto Akomodasi</label>
                                        <div class="input-images"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Galeri Vidio Akomodasi</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table_video">
                                                <thead>
                                                    <tr>
                                                        <th>Code</th>
                                                        <th>Vidio</th>
                                                        <th width="20%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="form-group">
                                                                <input type="text" id="vidio_url" class="form-control" placeholder="Youtube Video Url">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-block" id="tambah_video">Tambah</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div style="margin-top:30px" id="tampilFoto"></div>

                                        <div class="form-group">
                                            <label for="">Lokasi</label>
                                            <div style="height: 337px;" id="map"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Latitude</label>
                                                <input type="text" id="lat" name="lat" class="form-control" onkeyup="showLocation()">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Longtitude</label>
                                                <input type="text" id="lng" name="lng" class="form-control" onkeyup="showLocation()">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Tambahkan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <!-- Modal -->
    <div class="modal fade" id="tambah-kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                    @include('admin.master_data.ekonomi_kreatif.kategori.form')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ url('admin/assets') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/image-uploader/image-uploader.min.js"></script>

    @include('layouts.toastr-notif')
    <script>
        $(document).ready(() => {
            $('.input-images').imageUploader({
                imagesInputName: 'photos'
            });

            $('#tambah-kategori form').submit((e) => {
                e.preventDefault();

                var form = $('#tambah-kategori form')[0];
                var data = new FormData(form);

                $('#tambah-kategori button[type=submit]').attr('disabled');

                $.ajax({
                    url: "{{ route('admin.master-data.ekonomi-kreatif.kategori.store') }}",
                    enctype: 'multipart/form-data',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: function(hasil) {
                        // hasil = JSON.parse(hasil);
                        console.log("SUCCESS : ", hasil);
                        $.toast({
                            heading: 'Success',
                            text: hasil.msg,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right'
                        });
                    },
                    error: function(e) {
                        console.log("ERROR : ", e);
                    },
                    complete: function() {
                        $('#tambah-kategori button[type=submit]').removeAttr('disabled');
                        $('#tambah-kategori').modal("hide");
                    }
                })
            });

            //Initialize Select2 Elements
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4'
            // })

            $('select.select2bs4').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: "{{ route('admin.select2.kategori-ekonomi') }}",
                    dataType: 'json',
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data.result,
                            pagination: {
                                more: (params.page * 10) < data.count_filtered
                            }
                        };
                    }
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                }
            });

            $('#tambah_video').click(() => {
                let vidio_url = $('#vidio_url').val();
                console.log(getVideoIdYoutube(vidio_url));
                appendRowTableVideo(getVideoIdYoutube(vidio_url))
            });
        });


        function getVideoIdYoutube(url) {
            if(url.search("youtu.be") >= 0) {
                let url_split = url.split("/");
                return url_split[url_split.length -1];
            } else {
                var url = new URL(url);
                return url.searchParams.get("v") ?? null;
            }
        }

        function delRowTableVideo(el) {
            $(el).parents("tr").remove();
        }

        function appendRowTableVideo(code) {
            if($('#'+code).length == 0) {
                let markup =    `<tr id="${code}">
                                    <td>
                                        ${code}
                                        <input type="hidden" name="gallery_video[]" value="${code}">
                                    </td>
                                    <td>
                                        <iframe width="350" height="240" src="https://www.youtube.com/embed/${code}"></iframe>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="delRowTableVideo(this)"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>`;
                $("#table_video tbody").append(markup);
            }
        }

        var harga = new AutoNumeric('#harga', {
            currencySymbol: 'Rp.',
            decimalCharacter: ',',
            digitGroupSeparator: '.',
        });
        function tampil() {
            $('#tampilFoto').html(`<img src="../img/noimages.png" width="60%"/>`)
            $('#addAkomoadasi').modal('show')
            $('#title').html('Tambah ekonomi_kreatif')
        }
        function tampil_kategori() {
            $('#tambah-kategori').modal()
            $('#tambah-kategori #title').html('Tambah Data')
            $('#tambah-kategori #btnNama').html('Tambah')
        }

        function simpan_kategori() {
            var icon_kategori = $('#icon_kategori').prop('files')[0];
            var nama_kategori = $('#nama_kategori').val();
            var id = $('#id').val();
            var form_data = new FormData();

            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("_method", "POST");
            form_data.append('icon_kategori', icon_kategori);
            form_data.append('nama_kategori', nama_kategori);
            form_data.append('id', id);

            $.ajax({
                type: "POST",
                url: "{{ route('admin.master-data.ekonomi-kreatif.kategori.store') }}",
                contentType: 'multipart/form-data',
                data: form_data,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(data) {
                    // location.reload();
                    alert("kategori berhasil ditambahkan")
                    $('#tambah-kategori').modal('hide')
                    console.log(data);
                },
                error: function(e) {
                    console.log(e.responseText);
                },
                complete: function () {
                    $('#tambah-fasilitas').modal('hide');
                }
            });
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
                lat = $('#lat').val()
                lng = $('#lng').val();
                map.addControl(controlSearch);
                map.setView([lat, lng]); // ubah tampilan posisi peta ke posisi gps
                marker.setLatLng([lat, lng]); // pindahkan posisi marker ke posisi gps
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
    </script>
@endpush
