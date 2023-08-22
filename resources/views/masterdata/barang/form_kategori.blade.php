<div class="d-flex justify-content-center align-items-center border-2 rounded">
<div class="mt-3 col-md-6  z-0 d-grid place-items-center" >
<form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
    {{csrf_field();}}
    <label for="nama_kategori" class="form-label">Nama Kategori Barang</label>
    <input type="text" name="nama_kategori" id="nama_kategori" value="{{ isset($data_kategori) ? $data_kategori->nama_kategori : '' }}"  class="form-control">

    <input type="submit" value="Submit" class="mt-2">

</form>
</div>
</div>