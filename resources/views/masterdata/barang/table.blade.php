<div class="col text-right" style="margin: 0 -3em 0 0;">
    <a href="/admin/barang/add" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
        <i class="fa fa-plus-square"></i> <span>Tambah</span>
    </a>
    
    {{-- <button style="margin: 1em 0 0 0;" class="btn btn-primary fa fa-qrcode add-dimensi-btn" type="button" data-toggle="modal" data-target="#qrCode" disabled> QR CODE</button> --}}
</div>

<div class="table-data col p-0">
    <div class="w-full">
        <div class="w-full sm:flex">
            <h3 class="text-lg sm:text-xl">Data Barang</h3>
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
                        <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> Nama Barang </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Kategori</label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="5" type="checkbox" checked> Berat Barang </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="6" type="checkbox" checked> Total Dimensi</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="/admin/barang/in/">Barang Masuk</a>
    <a href="/admin/barang/out/">Barang Keluar</a>

    <div class="table-responsive mt-2">
        <table id="table" class="table stripe table-hover table-striped" style="width: 100%;">
            <thead>
                <tr class="tr-table">
                    <th class="th-table" style="font-size: 12px;" >No</th>
                    <th class="th-table" style="font-size: 12px;">Aksi</th>
                    <th class="th-table" style="font-size: 12px;">Nama Barang</th>
                    <th class="th-table" style="font-size: 12px;">Kategori</th>
                    <th class="th-table" style="font-size: 12px;">Berat Barang</th>
                    <th class="th-table" style="font-size: 12px;">Total Dimensi</th>
                    <th class="th-table" style="font-size: 12px;">Jumlah Barang</th>
                    
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td colspan="99" class="text-center">Data Tidak Ditemukan</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pop_up" style="display: none">
        <p>Ini Pop Up</p>
        <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
            {{csrf_field();}}
            <input type="text" name="id_barang" id="id_barang" hidden>

            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang">

            <label for="count_qr">Jumlah Generate</label>
            <input type="number" name="count_qr" id="count_qr">
        </form>
        <button id="btn-qr_code">Generate Qr_Code</button>
        <button id="cetak_qr">Cetak Qr_Code</button>
        <div class="list_qr_code row"></div>
    </div>
</div>