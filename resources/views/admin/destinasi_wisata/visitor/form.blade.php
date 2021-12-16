
    <input type="hidden" name="id" id="id">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label for="">Periode</label>
                <input type="month" name="month" value="{{ ($tahun && $bulan) ? $tahun . '-' . $bulan : '' }}" id="month"
                    class="form-control">
            </div>
            <div class="form-group">
                <label for="">Jumlah Pengunjung</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ $visitor->visitor ?? '' }}"
                    class="form-control" placeholder="Jumlah Pengunjung">
            </div>

            @if (isset($visitor))
                <button type="button" class="btn btn-primary" onclick="updateVisitorProo({{ $visitor->destinasi_wisata_id }}, {{ $visitor->id }})">Ubah</button>
            @else
                <button type="button" class="btn btn-primary" onclick="createVisitorProo({{ $destinasi_wisata_id }})">Tambahkan</button>
            @endif
        </div>
    </div>
<script>

    function updateVisitorProo(destinasi_wisata, id) {
        var periode = $('#visitorsEditModal #month').val();
        var jumlah = $('#visitorsEditModal #jumlah').val();

        if(periode != '' || jumlah != '') {
            $.post("{{ url('/') }}/admin/destinasi_wisata/"+destinasi_wisata+"/visitor/"+id+"/update", {_token: "{{ csrf_token() }}", periode:periode, jumlah:jumlah}, (result) => {
                if(result.status) {
                    reload_table_kunjungan(destinasi_wisata)
                    alert("[ Berhasil ] "+ result.msg);
                } else {
                    alert("[ Gagal ] "+ result.msg);
                }
            });
        } else {
            alert("lengkapi seluruh form");
        }
    }
    function createVisitorProo(destinasi_wisata) {
        var periode = $('#visitorsEditModal #month').val();
        var jumlah = $('#visitorsEditModal #jumlah').val();

        if(periode != '' || jumlah != '') {
            $.post("{{ url('/') }}/admin/destinasi_wisata/"+destinasi_wisata+"/visitor", {_token: "{{ csrf_token() }}", periode:periode, jumlah:jumlah}, (result) => {
                if(result.status) {
                    reload_table_kunjungan(destinasi_wisata)
                    alert("[ Berhasil ] "+ result.msg);
                } else {
                    alert("[ Gagal ] "+ result.msg);
                }
            });
        } else {
            alert("lengkapi seluruh form");
        }
    }
</script>
