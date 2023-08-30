

<div class="col text-right" style="margin: 0 -3em 1em 0;">
    <button type="button"  class="btn btn-primary" id="tombol-scan-barang" data-toggle="modal" data-target="#scan_kamera_barang"><i class="fa fa-qrcode"></i> <span>Scan barang</span></button>
</div>
  
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Data Barang Keluar</h3>
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
                    <label class="dropdown-item"><input class="toggle-vis" data-column="2" type="checkbox" checked> Kode Barang </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="3" type="checkbox" checked> Nama Barang </label>
                    <label class="dropdown-item"><input class="toggle-vis" data-column="4" type="checkbox" checked> Tanggal Keluar </label>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-2">
            <table id="table" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr class="tr-table">
                        <th class="th-table" style="font-size: 12px;" >No</th>
                        <th class="th-table" style="font-size: 12px;">Kode Barang</th>
                        <th class="th-table" style="font-size: 12px;">Nama Barang</th>
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

<div class="modal fade" id="scan_kamera_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Scan Barang Keluar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <video id="qr-reader" style="width: 100%"></video>
            <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                <label class="btn btn-primary active">
                  <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
                </label>
                <label class="btn btn-secondary">
                  <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
                </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>