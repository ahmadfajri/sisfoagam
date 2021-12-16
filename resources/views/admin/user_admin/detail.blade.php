@extends('admin.layouts.app')
@section('title', 'Detail Admin')
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
                    <h1 class="m-0">Detail Admin</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Detail Admin</li>
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
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama" value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="">No HP</label>
                                <input type="tel" name="no_hp" id="no_hp" class="form-control" placeholder="No HP" value="{{ $user->no_hp }}">
                            </div>
                            <div class="form-group">
                                <label for="">Jabatan</label>
                                <input type="text" name="level" id="level" class="form-control" placeholder="Jabatan" value="{{ $user->level }}">
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ ($user->status == 1)? "selected" : "" }}>Aktif</option>
                                    <option value="0" {{ ($user->status == 0)? "selected" : "" }}>Tidak Aktif</option>
                                </select>
                            </div>
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
@endpush
