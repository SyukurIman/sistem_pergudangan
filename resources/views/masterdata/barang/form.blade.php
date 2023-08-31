
<div class="row col-md-12" style="margin-bottom: 1em;">
    <div class="col text-left" style="margin: 1em 0 0 -1em;">
    </div>
    <div class="col text-right" style="margin: 0 -3em 0 0;">
        <a href="/barang" type="button" class="btn btn-primary btn-data-sec">
            <i class="fa fa-chevron-left"></i> <span>Kembali</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambah Barang</h5>
        <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
            {{csrf_field();}}
            <div class="form-group">
                <div class="row col-md-12 p-0">
                    <div class="col-md-6 mt1">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ isset($data_barang) ? $data_barang->nama_barang : '' }}" class="form-control">
                    </div>

                    <div class="col-md-6 mt1">
                        <label for="id_dimensi" class="form-label mt-1">Dimensi Barang</label>
                        
                        <select name="id_dimensi" id="id_dimensi" class="dimensi_check form-select custom-select select_form" required >
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
                        <a href="/barang/dimensi/add">Add Dimensi</a>
                    </div>

                    <div class="col-md-6 mt1">
                        <label for="berat_barang" class="form-label">Berat</label>
                        <input type="text" name="berat_barang" id="berat_barang" value="{{ isset($data_barang) ? $data_barang->berat_barang : '' }}" class="form-control">
                    </div>
                
                    <div class="col-md-6 mt1">
                        <label for="id_kategori" class="form-label">Pilih Kategori Barang</label>
                        <select name="id_kategori" id="id_kategori" class="custom-select select_form form-select">
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
                        
                        <a href="/barang/kategori/add">Add Kategori</a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row col-md-12 p-0">
                    <div class="col-md-12 card-siswa">
                        <h5>Dimensi Barang</h5>
                    </div>
                    <div class="col-md-6 mt1">
                        <label for="panjang_barang" class="form-label">Panjang</label>
                        <input type="text" name="panjang_barang" id="panjang_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->panjang : '' }}" class="form-control">
                    </div>
                    <div class="col-md-6 mt1">
                        <label for="lebar_barang" class="form-label">Lebar</label>
                        <input type="text" name="lebar_barang" id="lebar_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->lebar : '' }}" class="form-control">
                    </div>
                    <div class="col-md-6 mt1">
                        <label for="tinggi_barang" class="form-label">Tinggi</label>
                        <input type="text" name="tinggi_barang" id="tinggi_barang" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->tinggi : '' }}" class="form-control">
                    </div>
                    <div class="col-md-6 mt1">
                        <label for="total_dimensi" class="form-label">Total Dimensi</label>
                        <input type="text" name="total_dimensi" id="total_dimensi" disabled value="{{ isset($data_barang) ? $data_barang->dimensi_barang->total_dimensi : '' }}" class="form-control">
                    </div>
                
                    
                </div>
            </div>
            <div class="form-group">
                <div class="row col-md-12 p-0">
                    <div class="col-md-12">
                        <input type="submit" class="mt-3" class="btn btn-primary btn-data" value="Submit">
                    </div>
                </div>
            </div>
            

        </form>
    </div>
</div>