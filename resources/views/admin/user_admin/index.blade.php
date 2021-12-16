@extends('admin.layouts.app')
@section('title', 'Admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin</li>
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
                            <a href="{{ route('admin.admin.create') }}" class="btn btn-primary" >Tambah Data</a>
                        </div>
                        <div class="card-body">
                            <table id="table1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:10%">No</th>
                                        <th style="width:30%">Nama</th>
                                        <th style="width:15%">No HP</th>
                                        <th style="width:15%">Email</th>
                                        <th style="width:15%">Level</th>
                                        <th style="width:15%">Status</th>
                                        <th style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admins as $i => $d)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td>{{$d->name}}</td>
                                        <td>{{$d->no_hp}}</td>
                                        <td>{{$d->email}}</td>
                                        <td>{{$d->level}}</td>
                                        <td>{!! ($d->status)? "<span class='badge badge-success'>Aktif</span>" : "<span class='badge badge-danger'>Tidak Aktif</span>" !!}</td>
                                        <td>
                                            <a href="{{ route('admin.admin.show', $d->id) }}"  style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.admin.edit', $d->id) }}" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('js')
    <script>
        function hapus(id)
        {
            var pesan = confirm("Yakin Ingin Menghapus Data!");
            if(pesan){
                $.ajax({
                    url: "{{route('admin.admin.index')}}/"+id,
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
