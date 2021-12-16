@extends('admin.layouts.app')
@section('title', 'Foto Slider')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Foto Slider</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Foto Slider</li>
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
                        <button type="button" data-toggle="modal" data-target="#add-slider" class="btn btn-primary"> Add Slider</button>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:5%">No</th>
                                    <th style="width:35%">Foto</th>
                                    <th style="width:40%">Keterangan</th>
                                    <th style="width:20%%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($slider as $i => $item)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><img src="{{ $item->file }}" alt="{{ $item->file }}" class="img-fluid" width="60px"> </td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        <button style="width:80px;color:white" type="button" class="btn btn-warning p-1" onclick="edits({{ $item->id }}, '{{ $item->file }}', '{{ route('admin.foto-slider.edit', $item->id) }}', '{{  $item->description }}')">Edit</button>
                                        <button style="width:80px;color:white" type="button" class="btn btn-danger p-1" onclick="ModalHapus('{{ route('admin.foto-slider.destroy', $item->id) }}')">Delete</button>
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

<div class="modal fade" id="add-slider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.master_data.foto_slider.form')
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-slider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.foto-slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.master_data.foto_slider.form')
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="formDelete">
                <div class="modal-body">
                    @csrf
                    @method('delete')
                    Yakin Hapus Data ?
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
@include('layouts.toastr-notif')
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
                success: function(hasil) {
                    console.log("SUCCESS : ", hasil);
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

    function edits(id, file, url, deskripsi) {
        console.log(id, file, url);

        $('#edit-slider form').attr('action', url);
        $('#edit-slider #tampilFoto').html(`<img src="${file}" width="30%"/>`)
        $('#edit-slider #id').val(id)
        $('#edit-slider #deskripsi').val(deskripsi)
        $('#edit-slider #title').html("Edit Data")
        $('#edit-slider #btnNama').html("Edit")
        $('#edit-slider').modal('show');
    }


    function tampilfoto() {
        var fileInput = document.getElementById('foto_slider');
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
                            '" width="30%"/>';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        }
    }
</script>

<script>
    // untuk hapus data
    function ModalHapus(url) {
        $('#ModalHapus').modal('show')
        $('#formDelete').attr('action', url);
    }
</script>
@endpush
