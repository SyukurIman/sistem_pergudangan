<form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
    {{csrf_field();}}
    <label for="nama_dimensi">Nama Dimensi Barang</label>
    <input type="text" name="nama_dimensi" id="nama_dimensi">
    
    <label for="panjang">Panjang</label>
    <input type="number" name="panjang" id="panjang" class="data_angka">
    
    <label for="lebar">Lebar</label>
    <input type="number" name="lebar" id="lebar" class="data_angka">

    <label for="tinggi">Tinggi</label>
    <input type="number" name="tinggi" id="tinggi" class="data_angka" >

    <label for="total_dimensi">Total Dimensi</label>
    <input type="number" name="total_dimensi" id="total_dimensi" >

    <input type="submit" value="Submit">

</form>