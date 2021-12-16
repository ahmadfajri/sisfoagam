@extends('admin.layouts.app')
@section('title', 'Event Parawisata')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Event Parawisata</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Event Parawisata</li>
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
                            <a href="{{ route('admin.event-parawisata.create') }}" class="btn btn-primary" >Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:2%">No</th>
                                            <th style="width:10%">Jenis Event</th>
                                            <th style="width:10%">Jadwal Pelaksanaan</th>
                                            <th style="width:10%">Keterangan</th>
                                            <th style="width:10%">Foto</th>
                                            <!-- <th style="width:18%">Keterangan</th> -->
                                            <th style="width:10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($events as $i => $d)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$d->jenis_event}}</td>
                                            <td>{{ date("d M Y", strtotime($d->start_at)) }} - {{ date("d M Y", strtotime($d->end_at)) }}</td>
                                            <td>{{ substr(strip_tags($d->keterangan), 0, 100) }}{{ strlen($d->keterangan) > 100? "..." : "" }}</td>
                                            <td>
                                                <img src="{{ $d->foto }}" alt="{{ $d->jenis_event }}" class="img-fluid" width="100px">
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.event-parawisata.edit', $d->id) }}" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
@endsection

@push('js')
    <script>
        function tampil()
        {
            $('#tampilFoto').html(`<img src="../img/noimages.png" width="60%"/>`)
            $('#addDestinasiWisata').modal('show')
            $('#title').html('Tambah Akomodasi')
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
                    url: "{{route('admin.event-parawisata.index')}}/"+id,
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
