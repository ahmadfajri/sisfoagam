<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="nama_fasilitas">Nama Fasilitas</label>
        <input type="hidden" readonly id="id">
        <input type="text" name="nama_fasilitas" id="nama_fasilitas" class="form-control" value="">
    </div>
    <div class="form-group">
        <label for="nama_fasilitas">Icon Fasilitas</label>
        <input type="file" name="icon_fasilitas" id="icon_fasilitas" class="form-control" value="">
    </div>
    <div class="form-group text-center">
        <div id="tampilFoto"></div>
    </div>
    <button type="submit" style="width:80px" id="btnNama" class="btn btn-primary float-right">Submit</button>
</form>
