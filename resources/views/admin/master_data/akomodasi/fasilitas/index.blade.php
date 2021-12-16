@extends('admin.layouts.app')
@section('title', 'Fasilitas Akomodasi')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fasilitas Akomodasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Fasilitas Akomodasi</li>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#tambah-fasilitas">Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:2%">No</th>
                                        <th style="width:40%">Nama Fasilitas</th>
                                        <th style="width:38%">Icon Fasilitas</th>
                                        <th style="width:20%%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fasilitas as $i => $item)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $item->nama_fasilitas_akomodasi }}</td>
                                            <td><img src="{{ $item->icon_fasilitas_akomodasi }}"
                                                    alt="{{ $item->nama_fasilitas_akomodasi }}" class="img-fluid"
                                                    width="60px"> </td>
                                            <td>
                                                <button style="width:80px;color:white" type="button"
                                                    class="btn btn-warning p-1"
                                                    onclick="edits({{ $item->id }})">Edit</button>
                                                <button style="width:80px" type="button" class="btn btn-danger p-1"
                                                    onclick="deletes({{ $item->id }})">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="tambah-fasilitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    @include('admin.master_data.akomodasi.fasilitas.form')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-fasilitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('admin.master_data.akomodasi.fasilitas.form')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(() => {
            $('#tambah-fasilitas form').submit((e) => {
                e.preventDefault();

                var form = $('#tambah-fasilitas form')[0];
                var data = new FormData(form);

                $('#tambah-fasilitas button[type=submit]').attr('disabled');

                $.ajax({
                    url: "{{ route('admin.master-data.akomodasi.fasilitas.store') }}",
                    enctype: 'multipart/form-data',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: async function(hasil) {
                        // hasil = JSON.parse(hasil);
                        console.log("SUCCESS : ", hasil);
                        await $.toast({
                            heading: 'Success',
                            text: hasil.msg,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right'
                        });

                        location.reload();
                    },
                    error: function(e) {
                        console.log("ERROR : ", e);
                    },
                    complete: function() {
                        $('#tambah-fasilitas button[type=submit]').removeAttr('disabled');
                        $('#tambah-fasilitas').modal("hide");
                    }
                })
            })
            $('#edit-fasilitas form').submit((e) => {
                e.preventDefault();

                var form = $('#edit-fasilitas form')[0];
                console.log(form);
                var data = new FormData(form);
                data.append("_method", "PUT");
                console.log(data)

                $('#edit-fasilitas button[type=submit]').attr('disabled');
                console.log($('#edit-fasilitas #id').val());
                $.ajax({
                    url: "{{ route('admin.master-data.akomodasi.fasilitas.index') }}/" + $(
                        '#edit-fasilitas #id').val(),
                    enctype: 'multipart/form-data',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: async function(hasil) {
                        // hasil = JSON.parse(hasil);
                        console.log("SUCCESS : ", hasil);
                        await $.toast({
                            heading: 'Success',
                            text: hasil.msg,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right'
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    },
                    error: function(e) {
                        console.log("ERROR : ", e);
                    },
                    complete: function() {
                        $('#edit-fasilitas button[type=submit]').removeAttr('disabled');
                        $('#edit-fasilitas').modal("hide");
                    }
                })
            })

        });

        function edits(id) {
            $.ajax({
                url: '{{ route('admin.master-data.akomodasi.fasilitas.index') }}/' + id,
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('#edit-fasilitas #nama_fasilitas').val(data.nama_fasilitas_akomodasi)
                    $('#edit-fasilitas #tampilFoto').html(
                        `<img src="${data.icon_fasilitas_akomodasi}" width="30%"/>`)
                    $('#edit-fasilitas #id').val(data.id)
                    $('#edit-fasilitas #title').html("Edit Data")
                    $('#edit-fasilitas #btnNama').html("Edit")
                    $('#edit-fasilitas').modal('show');
                }
            })
        }

        function deletes(id) {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if (pesan) {
                $.ajax({
                    url: "{{ route('admin.master-data.akomodasi.fasilitas.index') }}/" + id,
                    type: 'POST',
                    data: {
                        '_method': "DELETE"
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        location.reload();
                    }
                });
            }
        }

        function tampilfoto() {
            var fileInput = document.getElementById('icon_kategori');
            var filePath = fileInput.value;
            var extensions = /(\.jpg|\.png)$/i;
            var ukuran = fileInput.files[0].size;
            if (ukuran > 100000) {
                alert('ukuran terlalu besar. Maksimal 100KB')
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
                                '" width="30%"/>';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }
        }
    </script>
@endpush
