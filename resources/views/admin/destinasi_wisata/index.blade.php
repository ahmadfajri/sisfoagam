@extends('admin.layouts.app')
@section('title', 'Destinasi Wisata')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Destinasi Wisata</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Destinasi Wisata</li>
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
                            <a href="{{ route('admin.destinasi-wisata.create') }}" class="btn btn-primary" >Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:2%">No</th>
                                            <th style="width:10%">Thumbnail</th>
                                            <th style="width:10%">Kategori</th>
                                            <th style="width:10%">Nama Wisata</th>
                                            <th style="width:10%">HTM Dewasa</th>
                                            <th style="width:10%">HTM Anak</th>
                                            <th style="width:10%">Biaya Parkir Roda 2</th>
                                            <th style="width:10%">Biaya Parkir Roda 4</th>
                                            <th style="width:10%">Jumlah Kunjungan</th>
                                            <th style="width:10%">Lokasi</th>
                                            <!-- <th style="width:18%">Keterangan</th> -->
                                            <th style="width:10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($destinasi_wisata as $i => $d)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td><img src="{{ $d->thumbnail_destinasi_wisata }}" alt="{{ $d->thumbnail_destinasi_wisata }}" class="img-fluid" width="100px"></td>
                                            <td>{{$d->kategori->nama_kategori_wisata}}</td>
                                            <td>{{$d->nama_wisata}}</td>
                                            <td>{{number_format($d->harga_tiket_dewasa)}}</td>
                                            <td>{{number_format($d->harga_tiket_anak)}}</td>
                                            <td>{{number_format($d->biaya_parkir_roda_2)}}</td>
                                            <td>{{number_format($d->biaya_parkir_roda_4)}}</td>
                                            <td>{{number_format($d->total_pengunjung ?? 0)}}</td>
                                            <td>
                                                <iframe width="300" height="170" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?= $d->lat; ?>,<?= $d->long; ?>&hl=in&z=14&amp;output=embed"></iframe>
                                            </td>
                                            <td>
                                                <button onclick="visitorModal({{ $d->id }})" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-glasses"></i></button>
                                                <a href="{{ route('admin.destinasi-wisata.detail', $d->id) }}" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('admin.destinasi-wisata.edit', $d->id) }}" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                <button onclick="hapus('<?= $d->id ?>')" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <!-- Modal Dertail -->
    <div class="modal fade" id="visitorsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="title"></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal Dertail -->
    <div class="modal fade" id="visitorsEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="title"></div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    function reload_table_kunjungan(id) {
                        $('#visitorsModal .modal-body').load("{{ url('/') }}/admin/destinasi_wisata/"+id+"/visitor");
                    }
                </script>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!-- Modal tambah fasilitas -->
    <div class="modal fade" id="tambahfasilitas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <div id="title">Tambah Fasilitas</div>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function visitorModal(id) {
            $('#visitorsModal #title').text("Daftar Pengunjung");
            reload_table_kunjungan(id);
            $('#visitorsModal').modal('show');
        }

        function tampil()
        {
            $('#tampilFoto').html(`<img src="../img/noimages.png" width="60%"/>`)
            $('#addDestinasiWisata').modal('show')
            $('#title').html('Tambah destinasi_wisata')
        }

        function tampilfoto()
        {
            var fileInput = document.getElementById('thumbnail');
            var filePath = fileInput.value;
            var extensions = /(\.jpg|\.png)$/i;
            var ukuran = fileInput.files[0].size;
            if(ukuran > 1000000)
            {
                alert('ukuran terlalu besar. Maksimal 1MB')
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
                            document.getElementById('tampilFoto').innerHTML = '<img src="'+e.target.result+'" width="60%"/>';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                }
            }
        }

        function hapus(id)
        {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if(pesan){
                $.ajax({
                    url: "{{route('admin.destinasi-wisata.index')}}/"+id,
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

        function ubahJumlahKunjungan(url, name, value) {
            let prm = prompt("Ubah jumlah kunjungan wisata : "+name, value);
            if(prm != null) {
                $.post(url, {jumlah:prm}, (result) => {
                    if(result.pesan == "berhasil") {
                        window.location.reload();
                    }
                })
            }
        }
    </script>
@endpush
