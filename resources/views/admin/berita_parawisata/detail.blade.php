@extends('admin.layouts.app')
@section('title', 'Detail Berita Pariwisata')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Berita Pariwisata</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Berita Pariwisata</a></li>
                    <li class="breadcrumb-item active">Detail</li>
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
                        <!-- <a href="{{ route('admin.akomodasi.home') }}" class="btn btn-secondary"> <i class="fas fa-backward"></i> Kembali</a> -->
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">
                            {{ $berita_parawisata->judul }}
                        </h5>

                        <span><b>Posted By :</b> {{ $berita_parawisata->posting_by }}</span>
                        <span class="float-right"><b>Posted At :</b> {{ date("d M Y H:i:s", strtotime($berita_parawisata->created_at)) }}</span>

                        <div class="text-center">
                            <h6><b>Thumbnail</b> </h6>
                            <img src="{{ $berita_parawisata->foto }}" alt="{{ $berita_parawisata->judul }}" class="img-fluid" width="300px">
                        </div>

                        {!!  $berita_parawisata->narasi !!}

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


@endsection
