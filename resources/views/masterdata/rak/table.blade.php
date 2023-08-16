<div class="col text-right" style="margin: 0 -3em 0 0;">
    <a href="/rak/create" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-plus-square"></i> <span>Tambah</span>
    </a>
    <button style="margin: 1em 0 0 0;" class="btn btn-primary fa fa-qrcode add-dimensi-btn" type="button" data-toggle="modal" data-target="#qrCode" disabled> QR CODE</button>
    <a href="/rak/delete" type="button" class="btn btn-danger btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-trash"></i> <span>Delete</span>
    </a>
</div>
<div class="table-data col p-0">
<div class="w-full">
    <div class="w-full sm:flex">
        <h3 class="text-lg sm:text-xl">Data Rak</h3>
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
                <th class="th-table" style="font-size: 12px;">Aksi</th>
                <th class="th-table" style="font-size: 12px;"><input type="checkbox" class="center" id="checkAll"></th>
                <th class="th-table" style="font-size: 12px;">rak</th>
                <th class="th-table" style="font-size: 12px;">kode rak</th>
                <th class="th-table" style="font-size: 12px;">kode sektor</th>
                <th class="th-table" style="font-size: 12px;">tipe</th>
                <th class="th-table" style="font-size: 12px;">dimensi</th>
                <th class="th-table" style="font-size: 12px;">daya tampung</th>
                <th class="th-table" style="font-size: 12px;">kapasitas</th>
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

<div class="modal fade bd-example-modal-lg" id="qrCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Table Rak</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <button id="cetak_qr">Cetak Qr_Code</button>
            <div class="table-responsive mt-2" id="cetak-pdf">
                <table id="table_qr_rak" class="table stripe" style="width: 100%;">
                    <thead>
                        <tr class="tr-table">
                            <th class="th-table" style="font-size: 12px;">No</th>
                            {{-- <th class="th-table" style="font-size: 12px;">Aksi</th> --}}
                            <th class="th-table" style="font-size: 12px;">rak</th>
                            <th class="th-table" style="font-size: 12px;">kode rak</th>
                            <th class="th-table" style="font-size: 12px;">kode sektor</th>
                            <th class="th-table" style="font-size: 12px;">qrcode</th>
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
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>