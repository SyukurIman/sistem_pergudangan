<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="d-flex justify-content-center align-items-center border-2 rounded">
<div class="mt-3 col-md-6  z-0 d-grid place-items-center" >
<form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
    {{csrf_field();}}
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <input type="text" name="nama_barang" id="nama_barang" value="{{ isset($data_barang) ? $data_barang->nama_barang : '' }}" class="form-control">
    
    <label for="id_dimensi" class="form-label mt-1">Dimensi Barang</label>
    <br>
    <select name="id_dimensi" id="id_dimensi" class="dimensi_check form-select" required >
        <option disabled selected >Pilih dimensi barang</option>
        @if (isset($data_dimensi))
            @foreach ($data_dimensi as $dimensi)
                @if (isset($data_barang) && $data_barang->id_dimensi == $dimensi->id)
                    <option selected value="{{ $dimensi->id}}">{{ $dimensi->nama_dimensi }}</option>
                @else
                    <option value="{{ $dimensi->id}}">{{ $dimensi->nama_dimensi }}</option> 
                @endif
            @endforeach
        @endif
    </select>
    <a href="/admin/barang/dimensi/add">Add Dimensi</a>
    
    <label for="id_kategori" class="form-label"></label>
    <select name="id_kategori" id="id_kategori" class="form-select">
        <option disabled selected >Pilih kategori barang</option>
        @if (isset($data_kategori))
            @foreach ($data_kategori as $kategori)
                @if (isset($data_barang) && $data_barang->id_kategori == $kategori->id)
                    <option selected value="{{ $kategori->id}}">{{ $kategori->nama_kategori }}</option>
                @else
                    <option value="{{ $kategori->id}}">{{ $kategori->nama_kategori }}</option>
                
                @endif
            @endforeach
        @endif
    </select>
    <a href="/admin/barang/kategori/add">Add Kategori</a>
    <br>
    <label for="panjang_barang" class="form-label">Panjang</label>
    <input type="text" name="panjang_barang" id="panjang_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->panjang : '' }}" class="form-control">
    
    <label for="lebar_barang" class="form-label">Lebar</label>
    <input type="text" name="lebar_barang" id="lebar_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->lebar : '' }}" class="form-control">

    <label for="tinggi_barang" class="form-label">Tinggi</label>
    <input type="text" name="tinggi_barang" id="tinggi_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->tinggi : '' }}" class="form-control">

    <label for="total_dimensi" class="form-label">Total Dimensi</label>
    <input type="text" name="total_dimensi" id="total_dimensi" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->total_dimensi : '' }}" class="form-control">

    <label for="berat_barang" class="form-label">Berat</label>
    <input type="text" name="berat_barang" id="berat_barang" value="{{ isset($data_barang) ? $data_barang->berat_barang : '' }}" class="form-control">

    <input type="submit" class="mt-3" value="Submit">

</form>
</div>
</div>