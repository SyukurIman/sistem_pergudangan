<div class="col text-right" style="margin: 0 -3em 0 0;">
    <a href="/pemindahan/create" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-plus-square"></i> <span>Tambah</span>
    </a>
</div>
<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h3 class="card-title">Data Pemindahan</h3>
            </div>
            <div class="col-6 text-right">
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
                    <label class="dropdown-item"><input class="toggle-vis" data-column="2" type="checkbox" checked> rak </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> kode rak </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> kode sektor </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> tipe </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> dimensi </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> daya tampung </label>
                </div>
            </div>
        </div>
    </div>
<div class="table-responsive mt-2">
    <table id="table" class="table table-striped" >
        <thead>
            <tr class="tr-table">
                <th class="th-table" style="font-size: 12px;">No</th>
                <th class="th-table" style="font-size: 12px;">nama barang</th>
                <th class="th-table" style="font-size: 12px;">kode barang</th>
                <th class="th-table" style="font-size: 12px;">Rak Asal</th>
                <th class="th-table" style="font-size: 12px;">Rak baru</th>
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
