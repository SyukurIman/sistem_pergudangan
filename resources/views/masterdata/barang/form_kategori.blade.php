<form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
    {{csrf_field();}}
    <label for="nama_kategori">Nama Kategori Barang</label>
    <input type="text" name="nama_kategori" id="nama_kategori">

    <input type="submit" value="Submit">

</form>