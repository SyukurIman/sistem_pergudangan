

<div class="row col-md-12" style="margin-bottom: 1em;">
    <div class="col text-left" style="margin: 1em 0 0 -1em;">
        <a href="/barang/kategori" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
            <i class="bi bi-tag-fill"></i> <span>Kategori</span>
        </a>
        <a href="/barang/dimensi" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
            <i class="bi bi-box-seam-fill"></i> <span>Dimensi</span>
        </a>
    </div>
    <div class="col text-right" style="margin: 0 -3em 0 0;">
        <a href="/barang/add" type="button" class="btn btn-primary btn-data" id="btn-create" style="margin: 1em 0 0 0;">
            <i class="fa fa-plus-square"></i> <span>Tambah</span>
        </a>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
         <div class="row">
            <div class="col-6">
                <h3 class="card-title">Data Barang</h3>
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
                        <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> Nama Barang </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Kategori</label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="5" type="checkbox" checked> Berat Barang </label>
                        <label class="dropdown-item"><input class="toggle-vis" data-column="6" type="checkbox" checked> Total Dimensi</label>
                    </div>
                </div>
            </div>
         </div>
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
    </div>
</div>

<div class="modal fade bd-example-modal-lg " id="pop_up"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate QrCode Barang</h5>
                <button type="button" class="btn_close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col">
                    <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                        {{csrf_field();}}
                        <input type="text" name="id_barang" id="id_barang" hidden>
    
                        <label for="nama_barang">Nama Barang</label>
                        <input class="form-control" type="text" name="nama_barang" id="nama_barang" disabled>
    
                        <label for="count_qr">Jumlah Generate</label>
                        <input class="form-control" type="number" name="count_qr" id="count_qr">
                    </form>
                    <div class="col ml-0 pl-0 mt-2">
                        <button class="btn btn-secondary btn-raised btn-xs" id="btn-qr_code">Generate Qr_Code</button>
                        <button class="btn btn-warning btn-raised btn-xs" id="cetak_qr">Cetak Qr_Code</button>
                    </div>
                    <div class="col mt-1" id="list_qr_code">
                        <div class="row list_qr_code"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn_close" data-dismiss="modal">Close</button>
            </div>
        </div>
        
    </div>
</div>