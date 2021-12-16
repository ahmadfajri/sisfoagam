@extends('admin.layouts.app')
@section('title', 'Kategori Ekonomi Kreatif')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kategori Ekonomi Kreatif</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Kategori Ekonomi Kreatif</li>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah-kategori">Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:2%">No</th>
                                        <th style="width:40%">Nama kategori</th>
                                        <th style="width:38%">Icon kategori</th>
                                        <th style="width:20%%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $i => $item)
                                        <tr>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $item->nama_kategori_kreatif }}</td>
                                            <td><img src="{{ $item->icon_kategori_kreatif }}" alt="{{ $item->nama_kategori_kreatif }}" class="img-fluid" width="60px"> </td>
                                            <td>
                                                <button style="width:80px;color:white" type="button" class="btn btn-warning p-1"
                                                    onclick="edits({{ $item->id }})">Edit</button>
                                                <button style="width:80px" type="button" class="btn btn-danger p-1" onclick="deletes({{ $item->id }})">Hapus</button>
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
    <div class="modal fade" id="tambah-kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><div id="title"></div></h5>
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
    <div class="modal fade" id="edit-kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    @include('admin.master_data.ekonomi_kreatif.kategori.form')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(() => {
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
                        $('#edit-kategori').modal('hide');
                    }
                })
            })
            $('#edit-kategori form').submit((e) => {
                e.preventDefault();

                var form = $('#edit-kategori form')[0];
                var data = new FormData(form);
                data.append("_method", "PUT");

                $('#edit-kategori button[type=submit]').attr('disabled');

                $.ajax({
                    url: "{{ route('admin.master-data.ekonomi-kreatif.kategori.index') }}/"+$('#edit-kategori #id').val(),
                    enctype: 'multipart/form-data',
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 800000,
                    success: function (hasil) {
                        console.log("SUCCESS : ", hasil);
                        $.toast({
                            heading: 'Success',
                            text: hasil.msg,
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: 'top-right'
                        });
                        location.reload();
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                    },
                    complete: function() {
                        $('#tambah-kategori button[type=submit]').removeAttr('disabled');
                        $('#edit-kategori').modal('hide');
                    }
                })
            })

        });

        function edits(id)
        {
            $.ajax({
                url:'{{route("admin.master-data.ekonomi-kreatif.kategori.index")}}/'+id,
                type:'get',
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $('#edit-kategori #nama_kategori').val(data.nama_kategori_kreatif)
                    $('#edit-kategori #tampilFoto').html(`<img src="${data.icon_kategori_kreatif}" width="30%"/>`)
                    $('#edit-kategori #id').val(data.id)
                    $('#edit-kategori #title').html("Edit Data")
                    $('#edit-kategori #btnNama').html("Edit")
                    $('#edit-kategori').modal('show');
                }
            })
        }

        function deletes(id)
        {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if(pesan){
                $.ajax({
                    url:"{{ route('admin.master-data.ekonomi-kreatif.kategori.index') }}/"+id,
                    type:'POST',
                    data: {
                        '_method':"DELETE"
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        location.reload();
                    },
                    complete: function() {
                        $('#edit-kategori').modal('hide');
                    }
                });
            }
        }

        function tampilfoto()
        {
            var fileInput = document.getElementById('icon_kategori');
            var filePath = fileInput.value;
            var extensions = /(\.jpg|\.png)$/i;
            var ukuran = fileInput.files[0].size;
            if(ukuran > 100000)
            {
                alert('ukuran terlalu besar. Maksimal 100KB')
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
                            document.getElementById('tampilFoto').innerHTML = '<img src="'+e.target.result+'" width="30%"/>';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }
        }
    </script>
@endpush
