@extends('admin.layouts.app')
@section('title', 'Detail Panduan Aplikasi')
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
                    @if ($panduan != null)
                        <h1 class="m-0">{{ $panduan->title }}</h1>
                    @else
                        <h1 class="m-0">Panduan Aplikasi</h1>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        @if ($panduan != null)
                            <li class="breadcrumb-item"><a href="{{ route('admin.panduan.show') }}">Panduan Aplikasi</a></li>
                            <li class="breadcrumb-item active">{{ $panduan->title }}</li>
                        @else
                            <li class="breadcrumb-item active">Panduan Aplikasi</li>
                        @endif
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            @if ($panduan == null)
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <h5 class="card-title mb-2">List</h5>
                        <table class="table table-bordered">
                            @foreach ($list_panduan as $item)
                            <tr>
                                <td>
                                    {{ $item->title }}
                                </td>
                                <td width="10%" class="bg-primary text-center" onclick="location.href='{{ route('admin.panduan.show', $item->slug) }}'">
                                    <a href="{{ route('admin.panduan.show', $item->slug) }}">Lihat</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @else

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                {!! $panduan->body !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-outline card-primary">
                            <div class="card-body">
                                <h5 class="card-title">Panduan Lainnya..</h5>
                                <table class="table table-bordered">
                                    @foreach ($list_panduan->where("id", '!=', $panduan->id) as $item)
                                    <tr>
                                        <td>
                                            {{ $item->title }}
                                        </td>
                                        <td width="10%" class="bg-primary text-center" onclick="location.href='{{ route('admin.panduan.show', $item->slug) }}'">
                                            <a href="{{ route('admin.panduan.show', $item->slug) }}">Lihat</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            @endif
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
