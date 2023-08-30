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
                <h5 class="card-title">Tambah Kategori Barang</h5>
            </div>
        </div>
        <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
            {{csrf_field();}}
            <div class="form-group">
                <div class="col-md-12">
                    <label for="nama_kategori" class="form-label">Nama Kategori Barang</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" value="{{ isset($data_kategori) ? $data_kategori->nama_kategori : '' }}"  class="form-control">
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