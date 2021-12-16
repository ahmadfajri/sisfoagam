
    <div class="form-group">
        <label for="nama_fasilitas">Foto Slider</label>
        <input type="file" name="foto_slider" id="foto_slider" class="form-control" onchange="tampilfoto()" value="">
    </div>
    <div class="form-group text-center">
        <div id="tampilFoto"></div>
    </div>
    <div class="form-group">
        <label for="nama_fasilitas">Deskripsi</label>
        <input type="hidden" readonly id="id">
        <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="">
    </div>
    <button type="submit" style="width:80px" id="btnNama" class="btn btn-primary float-right">Submit</button>
