<div class="row col-md-12" style="margin-bottom: 1em;">
    <div class="col text-left" style="margin: 1em 0 0 -1em;">
    </div>
    <div class="col text-right" style="margin: 0 -3em 0 0;">
        <a href="/admin/barang" type="button" class="btn btn-primary btn-data-sec">
            <i class="fa fa-chevron-left"></i> <span>Kembali</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="form-group">
            <div class="col-md-12">
                <h5 class="card-title">Tambah Dimensi Barang</h5>
            </div>
        </div>
        <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
            {{csrf_field();}}
            <div class="form-group">
                <div class="col-md-12">
                    <label for="nama_dimensi" class="form-label">Nama Dimensi Barang</label>
                    <input type="text" name="nama_dimensi" id="nama_dimensi" value="{{ isset($data_dimensi) ? $data_dimensi->nama_dimensi : '' }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="panjang" class="form-label">Panjang</label>
                    <input type="number" name="panjang" id="panjang" class="data_angka form-control" value="{{ isset($data_dimensi) ? $data_dimensi->panjang : '' }}" >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="lebar" class="form-label">Lebar</label>
                    <input type="number" name="lebar" id="lebar" class="data_angka form-control" value="{{ isset($data_dimensi) ? $data_dimensi->lebar : '' }}" >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="tinggi" class="form-label">Tinggi</label>
                    <input type="number" name="tinggi" id="tinggi" class="data_angka form-control" value="{{ isset($data_dimensi) ? $data_dimensi->tinggi : '' }}" >
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="total_dimensi" class="form-label">Total Dimensi</label>
                    <input type="number" name="total_dimensi" id="total_dimensi" value="{{ isset($data_dimensi) ? $data_dimensi->total_dimensi : '' }}" class="form-control"> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input type="submit" class="mt-3" class="btn btn-primary btn-data" value="Submit">
                </div>
            </div>

        </form>
    </div>
</div>