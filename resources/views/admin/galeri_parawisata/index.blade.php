@extends('admin.layouts.app')
@section('title', 'Galeri Parawisata')
@push('css')
    <link rel="stylesheet" href="{{ url('/') }}/admin/assets/plugins/lightbox2/css/lightbox.css">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Galeri Parawisata</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Galeri Parawisata</li>
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
                            <a href="{{ route('admin.galeri-parawisata.create') }}" class="btn btn-primary" >Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:2%">No</th>
                                            <th>Foto</th>
                                            <th style="width:20%">Kategori</th>
                                            <th style="width:10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($galeries as $i => $d)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td><a href="{{ $d->file }}" data-lightbox="galeri_parawisata" data-title="#{{ $d->id }} ({{ $d->kategori }})"><img src="{{ $d->file }}" alt="{{ $d->kategori }}" class="img-fluid" width="100px"></a></td>
                                            <td>{{$d->kategori}}</td>
                                            <td>
                                                <button style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button>
                                                <button onclick="hapus('<?= $d->id ?>')" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            {{ $galeries->links() }}
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
    <script src="{{ url('/') }}/admin/assets/plugins/lightbox2/js/lightbox.js"></script>
    <script>
        function hapus(id)
        {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if(pesan){
                $.ajax({
                    url: "{{route('admin.galeri-parawisata.index')}}/"+id,
                    type:"DELETE",
                    dataType: "JSON",
                    data:{'id':id,"_token":"{{csrf_token()}}"},
                    success: function(data)
                    {
                        if(data.pesan == 'berhasil')
                        {
                            window.location.reload();
                        }
                    }
                })
            }
        }
    </script>
@endpush
