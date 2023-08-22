<div class="d-flex justify-content-center align-items-center border-2 rounded">
<div class="mt-3 col-md-6  z-0 d-grid place-items-center" >
<form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
    {{csrf_field();}}
    <label for="nama_dimensi" class="form-label">Nama Dimensi Barang</label>
    <input type="text" name="nama_dimensi" id="nama_dimensi" value="{{ isset($data_dimensi) ? $data_dimensi->nama_dimensi : '' }}" class="form-control">
    
    <label for="panjang" class="form-label">Panjang</label>
    <input type="number" name="panjang" id="panjang" class="data_angka form-control" value="{{ isset($data_dimensi) ? $data_dimensi->panjang : '' }}" >
    
    <label for="lebar" class="form-label">Lebar</label>
    <input type="number" name="lebar" id="lebar" class="data_angka form-control" value="{{ isset($data_dimensi) ? $data_dimensi->lebar : '' }}" >

    <label for="tinggi" class="form-label">Tinggi</label>
    <input type="number" name="tinggi" id="tinggi" class="data_angka form-control" value="{{ isset($data_dimensi) ? $data_dimensi->tinggi : '' }}" >

    <label for="total_dimensi" class="form-label">Total Dimensi</label>
    <input type="number" name="total_dimensi" id="total_dimensi" value="{{ isset($data_dimensi) ? $data_dimensi->total_dimensi : '' }}" class="form-control"> 

    <input type="submit" value="Submit" class="mt-2">

</form>
</div>
</div>