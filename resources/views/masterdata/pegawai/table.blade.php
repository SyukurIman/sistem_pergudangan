<div class="col text-right" style="margin: 0 -3em 0 0;">
    <a href="/admin/pegawai/add" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-plus-square"></i> <span>Tambah</span>
    </a>
</div>
<div class="card mt-3">
    <div class="card-body">
        <h3 class="text-lg sm:text-xl">Data Pegawai</h3>
        <div class="gap-4 justify-center col flex sm:justify-end">
            <button type="button" class="btn btn-data-sec" id="btn-muat-ulang" style="margin: 1em 0 0 0;">
                <i class="fa fa-refresh"></i>
            </button>
            <button type="button" class="btn btn-data-sec" id="btn-cetak" style="margin: 1em 0 0 0;">
                <i class="fa fa-file-excel-o"></i>
            </button>
            <div class="btn dropdown" >
                <button style="margin: 1em 0 0 0" class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </button>
                <div class="dropdown-menu">
                    <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> Nama Pegawai </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Email Pegawai</label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="5" type="checkbox" checked> Alamat Pegawai</label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="6" type="checkbox" checked> No. Telp</label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="7" type="checkbox" checked> Tanggal Lahir</label>
                    
                </div>
            </div>
        </div>

        <div class="table-responsive mt-2">
            <table id="table" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Aksi</th>
                        <th>Nama Pegawai</th>
                        <th>Email Pegawai</th>
                        <th>Alamat Pegawai</th>
                        <th>No. Telp</th>
                        <th>Tanggal Lahir</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>