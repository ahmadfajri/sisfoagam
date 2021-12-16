@extends('admin.layouts.app')
@section('title', 'Tambah Panduan Aplikasi')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ url('admin/assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link type="text/css" rel="stylesheet" href="{{ url('/') }}/admin/assets/plugins/image-uploader/image-uploader.min.css">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Panduan Aplikasi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Panduan Aplikasi</li>
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
                            <form action="{{ route('admin.master-data.panduan.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="">Body</label>
                                    <textarea name="body" id="body" class="form-control note"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
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
    @include('layouts.toastr-notif')
    <script>
        $(".note").summernote("code", res.data.keterangan);
    </script>
@endpush
