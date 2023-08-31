<div class="col text-right" style="margin: 0 -3em 0 0;">
    <a href="/barang/dimensi/add" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-plus-square"></i> <span>Tambah</span>
    </a>
    <a href="/barang" type="button" class="btn btn-primary btn-data-sec" style="margin: 1em 0 0 0;">
        <i class="fa fa-chevron-left"></i> <span>Kembali</span>
    </a>
</div>
<div class="card mt-3">
    <div class="card-body">
        <div class="w-full sm:flex">
            <h3 class="text-lg sm:text-xl">Data Dimensi Barang</h3>
            <div class="gap-4 justify-center col flex sm:justify-end">
                <button type="button" class="btn btn-data-sec" id="btn-muat-ulang" style="margin: 1em 0 0 0;">
                    <i class="fa fa-refresh"></i>
                </button>
                <button type="button" class="btn  btn-data-sec" id="btn-cetak" style="margin: 1em 0 0 0;">
                    <i class="fa fa-file-excel-o"></i>
                </button>
                <div class="btn dropdown" >
                    <button style="margin: 1em 0 0 0" class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-filter"></i>
                    </button>
                    <div class="dropdown-menu">
                        <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> Nama Barang </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Kategori</label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="5" type="checkbox" checked> Berat Barang </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="6" type="checkbox" checked> Total Dimensi</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table id="table" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr class="tr-table">
                        <th class="th-table" style="font-size: 12px;" >No</th>
                        <th class="th-table" style="font-size: 12px;">Aksi</th>
                        <th class="th-table" style="font-size: 12px;">Nama Dimensi</th>
                        <th class="th-table" style="font-size: 12px;">Panjang</th>
                        <th class="th-table" style="font-size: 12px;">Lebar</th>
                        <th class="th-table" style="font-size: 12px;">Tinggi</th>
                        <th class="th-table" style="font-size: 12px;">Total Dimensi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td colspan="99" class="text-center">Data Tidak Ditemukan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>