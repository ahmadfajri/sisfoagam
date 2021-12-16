<button onclick="createVisitor({{ $destinasi_wisata_id }})"
        class="btn btn-info btn-sm float-end">
    Tambah Data Pengunjung
</button>
<table id="table1" class="table table-striped">
    <thead>
        <tr>
            <th style="width:20%">Periode</th>
            <th>Jumlah Pengunjung</th>
            <th style="width:20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($visitors as $i => $a)
            <tr>
                <td>{{ $a->periode }}</td>
                <td>{{ number_format($a->visitor) }}</td>
                <td>
                    <button onclick="editVisitor({{ $a->destinasi_wisata_id }}, {{ $a->id }})"
                        style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i
                            class="fas fa-edit"></i></button>
                    <button onclick="hapusVisitor({{ $a->destinasi_wisata_id }}, '<?= $a->id ?>')" style="width:40px; margin-top:5px" class="btn btn-info btn-sm"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    async function editVisitor(destinasi_wisata, id) {
        $('#visitorsEditModal #title').text("Tambah Data Pengunjung");
        $('#visitorsEditModal .modal-body').load("{{ url('/') }}/admin/destinasi_wisata/"+destinasi_wisata+"/visitor/"+id+"/form");
        $('#visitorsEditModal').modal('show');
    }

    async function createVisitor(destinasi_wisata) {
        $('#visitorsEditModal #title').text("Tambah Data Pengunjung");
        $('#visitorsEditModal .modal-body').load("{{ url('/') }}/admin/destinasi_wisata/"+destinasi_wisata+"/visitor/form");
        $('#visitorsEditModal').modal('show');
    }

    function hapusVisitor(destinasi_wisata, id)
    {
        var pesan = confirm("Yakin Ingin Menghapus Data!");
        if(pesan){
            $.ajax({
                url: "{{ url('/') }}/admin/destinasi_wisata/"+destinasi_wisata+"/visitor/"+id+"/delete",
                type:"POST",
                dataType: "JSON",
                data:{"_token":"{{csrf_token()}}", "_method": "DELETE"},
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
