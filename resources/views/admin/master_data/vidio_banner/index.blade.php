@extends('admin.layouts.app')
@section('title', 'Home')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Home Video</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Home Video</li>
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
                        <form action="{{ route('admin.master-data.video.index') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group text-center" style="
                                    position: relative;
                                    overflow: hidden;
                                    width: 100%;
                                    padding-top: 56.25%;
                                    ">
                                <style>
                                    /* Then style the iframe to fit in the container div with full height and width */
                                    .responsive-iframe {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        bottom: 0;
                                        right: 0;
                                        width: 100%;
                                        height: 100%;
                                    }
                                </style>
                                <iframe class="responsive-iframe" src="{{ $url }}"></iframe>
                            </div>
                            <div class="form-group">
                                <label for="nama_fasilitas">URL Youtube</label>
                                <input type="text" name="url" id="url" class="form-control" value="{{ $url }}">
                            </div>
                            <button type="submit" style="width:80px" id="btnNama" class="btn btn-primary float-right">Submit</button>

                        </form>
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
@endpush
