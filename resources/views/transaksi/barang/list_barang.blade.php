
<div class="row col-md-12" style="margin-bottom: 1em;">
    <div class="col text-left" style="margin: 1em 0 0 -1em;">
        <button id="ubah_data_barang" data-id="data_trash" class="btn btn-primary btn-data"><i class="bi bi-trash-fill"></i> <span>List Dihapus</span></button>
        <button id="btn_restore" style="display: none" class="btn btn-primary btn-data"><i class="bi bi-arrow-up-circle-fill"></i> <span>Restore All</span></button>
    </div>
    <div class="col text-right" style="margin: 0 -3em 0 0;">
        <a href="/barang" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
            <i class="fa fa-chevron-left"></i> <span>Kembali</span>
        </a>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <div class="row col">
            <h3 class="text-lg sm:text-xl col-md-6" id="title_list">List Barang </h3>
            <div class="gap-4 justify-end col flex sm:justify-end">
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
                        <label class="dropdown-item"><input class="toggle-vis" data-column="2" type="checkbox" checked> Kode Barang </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> Nama Barang</label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Tanggal Masuk </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="5" type="checkbox" checked> Tanggal Keluar</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-2">
            <table id="table" class="table stripe" style="width: 100%;">
                <thead>
                    <tr class="tr-table">
                        <th class="th-table" style="font-size: 12px;" >No</th>
                        <th class="th-table" style="font-size: 12px;">Aksi</th>
                        <th class="th-table" style="font-size: 12px;">Kode Barang</th>
                        <th class="th-table" style="font-size: 12px;">Nama Barang</th>
                        <th class="th-table" style="font-size: 12px;">Tanggal Masuk</th>
                        <th class="th-table" style="font-size: 12px;">Tanggal Keluar</th>
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