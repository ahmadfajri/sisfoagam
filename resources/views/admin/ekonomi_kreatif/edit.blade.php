@extends('admin.layouts.app')
@section('title', 'Edit Ekonomi Kreatif')
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
                    <h1 class="m-0">Edit Ekonomi Kreatif</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Ekonomi Kreatif</li>
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
                            <form action="{{ route('admin.ekonomi-kreatif.update', $ekonomi_kreatif->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
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
                                                    <label for="">Nama Produk</label>
                                                    <input type="text" name="ekonomi_kreatif" id="ekonomi_kreatif" value="{{ $ekonomi_kreatif->nama_ekonomi_kreatif }}"
                                                        class="form-control" placeholder="Destinasi Wisata">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Harga</label>
                                                    <input type="text" name="harga" id="harga" class="form-control" value="{{ $ekonomi_kreatif->harga }}"
                                                        placeholder="Kelas">
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
                                                    <textarea name="keterangan" id="keterangan" class="note">{{ $ekonomi_kreatif->keterangan }}</textarea>
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
                                        <div style="margin-top:30px" id="tampilFoto">
                                            <img src="{{ $ekonomi_kreatif->thumbnail_ekonomi_kreatif }}" width="60%"/>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Lokasi</label>
                                            <div style="height: 337px;" id="map"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Latitude</label>
                                                <input type="text" id="lat" name="lat" class="form-control" value="{{ $ekonomi_kreatif->lat }}" onkeyup="showLocation()">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Longtitude</label>
                                                <input type="text" id="lng" name="lng" class="form-control" value="{{ $ekonomi_kreatif->long }}" onkeyup="showLocation()">
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

@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ url('admin/assets') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ url('/') }}/admin/assets/plugins/image-uploader/image-uploader.min.js"></script>

    @include('layouts.toastr-notif')
    <script>

        function loadMedia() {
            // $.get("{{ route('admin.akomodasi.media', $ekonomi_kreatif->id) }}", (result) => {
            //     console.log(result);
                let json = {!! json_encode($ekonomi_kreatif->fotovideo) !!}
                let preloaded = [];
                let video_list = [];

                json.forEach((e, i) => {
                    if(e.kategori == "foto") {
                        preloaded.push({id: e.id, src: e.file});
                    } else {
                        appendRowTableVideo(e.file)
                    }
                });

                $('.input-images').imageUploader({
                    preloaded: preloaded,
                    imagesInputName: 'photos',
                    preloadedInputName: 'old'
                });

            //     console.log(preloaded);
            // })
        }

        function fasilitas_selected() {

            // Fetch the preselected item, and add to the control
            var fasilitasSelect = $('select.sl2multi');
            $.ajax({
                type: 'GET',
                url: '{{ route("admin.destinasi-wisata.fasilitas_select2", $ekonomi_kreatif->id) }}'
            }).then(function (data) {
                console.log(data)
                // create the option and append to Select2
                data.forEach(e => {
                    let option = new Option(e.text, e.id, true, true);
                    fasilitasSelect.append(option).trigger('change');
                });
            });
        }

        $(document).ready(() => {
            loadMedia()

            $('#tambah-fasilitas form').submit((e) => {
                e.preventDefault();

                var form = $('#tambah-fasilitas form')[0];
                var data = new FormData(form);

                $('#tambah-fasilitas button[type=submit]').attr('disabled');

                $.ajax({
                    url: "{{ route('admin.master-data.destinasi-wisata.fasilitas.store') }}",
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
                        $('#tambah-fasilitas button[type=submit]').removeAttr('disabled');
                        $('#tambah-fasilitas').modal("hide");
                    }
                })
            });

            //Initialize Select2 Elements
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4'
            // })

            $('select.sl2multi').select2({
                ajax: {
                    url: "{{ route('admin.select2.fasilitas-wisata') }}",
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
                    success: function (hasil) {
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
                    error: function (e) {
                        console.log("ERROR : ", e);
                    },
                    complete: function() {
                        $('#tambah-kategori button[type=submit]').removeAttr('disabled');
                        $('#tambah-kategori').modal('hide');
                    }
                })
            });


            $('select.select2bs4').select2({
                theme: 'bootstrap4',
                ajax: {
                    url: "{{ route('admin.select2.kategori-ekonomi') }}",
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data, params) {
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

            $('select.select2bs4').select2("trigger", "select", {
                data: { id: "{{ $ekonomi_kreatif->kategori->id }}", text:'{{ $ekonomi_kreatif->kategori->nama_kategori_kreatif }}' }
            });

            fasilitas_selected();


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
