@extends('admin.layouts.app')
@section('title', 'Panduan Aplikasi')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Panduan Aplikasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Panduan Aplikasi</li>
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
                            <a href="{{ route('admin.master-data.panduan.create') }}" class="btn btn-primary">Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <table class="table" id="table1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:2%">No</th>
                                        <th style="width:40%">Title</th>
                                        <th style="width:20%%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($panduan as $i => $item)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>
                                                <a style="width:80px;color:white" type="button"
                                                    class="btn btn-warning p-1"
                                                    href="{{ route('admin.master-data.panduan.edit', $item->id) }}">Edit</a>
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
@endsection

@push('js')
    <script>
        function deletes(id) {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if (pesan) {
                $.ajax({
                    url: "{{ route('admin.master-data.panduan.index') }}/" + id,
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
    </script>
@endpush
