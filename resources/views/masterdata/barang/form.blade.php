<form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
    {{csrf_field();}}
    <label for="nama_barang">Nama Barang</label>
    <input type="text" name="nama_barang" id="nama_barang" value="{{ isset($data_barang) ? $data_barang->nama_barang : '' }}">
    
    <label for="id_dimensi">Dimensi Barang</label>
    <select name="id_dimensi" id="id_dimensi" class="dimensi_check" required >
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
    
    <label for="id_kategori"></label>
    <select name="id_kategori" id="id_kategori">
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
    
    <label for="panjang_barang">Panjang</label>
    <input type="text" name="panjang_barang" id="panjang_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->panjang : '' }}">
    
    <label for="lebar_barang">Lebar</label>
    <input type="text" name="lebar_barang" id="lebar_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->lebar : '' }}">

    <label for="tinggi_barang">Tinggi</label>
    <input type="text" name="tinggi_barang" id="tinggi_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->tinggi : '' }}">

    <label for="total_dimensi">Total Dimensi</label>
    <input type="text" name="total_dimensi" id="total_dimensi" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->total_dimensi : '' }}">

    <label for="berat_barang">Berat</label>
    <input type="text" name="berat_barang" id="berat_barang" value="{{ isset($data_barang) ? $data_barang->berat_barang : '' }}">

    <input type="submit" value="Submit">

</form>