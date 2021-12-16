@extends('admin.layouts.app')
@section('title', 'Detail Akomodasi')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Akomodasi</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Akomodasi</a></li>
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
                        <a href="{{ route('admin.akomodasi.home') }}" class="btn btn-secondary"> <i class="fas fa-backward"></i> Kembali</a>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-borderless">
                            <thead>
                                @foreach($akomodasi as $item)
                                <tr>
                                    <th style="width:35%">Kategori</th>
                                    <th>{{ $item->nama_kategori_akomodasi }}</th>
                                </tr>
                                <tr>
                                    <th style="width:35%">Nama Akomodasi</th>
                                    <th>{{ $item->nama_akomodasi }}</th>
                                </tr>
                                <tr>
                                    <th style="width:35%">Kelas</th>
                                    <th>{{ $item->kelas }}</th>
                                </tr>
                                <tr>
                                    <th style="width:35%">Harga</th>
                                    <th>Rp. {{ number_format($item->harga) }} </th>
                                </tr>
                                <tr>
                                    <th style="width:35%; vertical-align:middle;">Thumbnail</th>
                                    <th>
                                        <img src="{{ $item->thumbnail_akomodasi }}" alt="{{ $item->thumbnail_akomodasi }}" class="img-fluid" width="100px">
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:35%; vertical-align:middle; ">lokasi</th>
                                    <th>
                                        <iframe width="300" height="170" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?= $item->lat; ?>,<?= $item->long; ?>&hl=in&z=14&amp;output=embed"></iframe>
                                    </th>
                                </tr>
                                @endforeach
                            </thead>
                            <tbody>

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

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        Review Akomodasi
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-border">
                            <thead>
                                <th style="width:35%">Nama Reviewer</th>
                                <th style="width:35%">Tingkat Kepuasan</th>
                                <th style="width:35%">Komentar</th>
                                <th style="width:35%">Aksi</th>
                            </thead>
                            <tbody>
                                @foreach($review_a as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->tingkat_kepuasan }}</td>
                                    <td>{{ $item->komentar }}</td>
                                    <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-circle" onclick="ModalHapus('{{ route('admin.akomodasi.hapus.data_review_akomodasi', $item->id) }}')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{ $review_a->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
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
<script>
    // untuk hapus data
    function ModalHapus(url) {
        $('#ModalHapus').modal('show')
        $('#formDelete').attr('action', url);
    }
</script>

@endpush
