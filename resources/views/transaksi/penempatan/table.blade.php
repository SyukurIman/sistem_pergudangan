<div class="col text-right" style="margin: 0 -3em 0 0;">
    <a href="/penempatan/create" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-plus-square"></i> <span>Tambah</span>
    </a>
</div>
<div class="table-data col p-0">
<div class="w-full">
    <div class="w-full sm:flex">
        <h3 class="text-lg sm:text-xl">Data Penempatan</h3>
        <div class="gap-4 justify-center col flex sm:justify-end">
            <button type="button" class="btn-data-sec" id="btn-muat-ulang" style="margin: 1em 0 0 0;">
                <i class="fa fa-refresh"></i>
            </button>
            <button type="button" class=" btn-data-sec" id="btn-cetak" style="margin: 1em 0 0 0;">
                <i class="fa fa-file-excel-o"></i>
            </button>
            <div class="dropdown" >
                <button style="margin: 1em 0 0 0" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
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
    <table id="table" class="table stripe" style="width: 100%;">
        <thead>
            <tr class="tr-table">
                <th class="th-table" style="font-size: 12px;">No</th>
                <th class="th-table" style="font-size: 12px;">nama barang</th>
                <th class="th-table" style="font-size: 12px;">kode barang</th>
                <th class="th-table" style="font-size: 12px;">nama rak</th>
                <th class="th-table" style="font-size: 12px;">kode rak</th>
                <th class="th-table" style="font-size: 12px;">Status</th>
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
