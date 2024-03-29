     <!-- MAIN -->
     <div class="row col-md-12" style="margin-bottom: 1em;">
        <div class="col text-left" style="margin: 1em 0 0 -1em;">
        </div>
        <div class="col text-right" style="margin: 0 -3em 0 0;">
            <a href="/pemindahan" type="button" class="btn btn-primary btn-data-sec">
                <i class="fa fa-chevron-left"></i> <span>Kembali</span>
            </a>
        </div>
         </div>
         <div class="card">
                <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                    {{csrf_field();}}
                    @if ($type=='create')
                    <div class="form-group mt-2">
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                @if ($type=='create'|| $type=='update')
                                <button type="button"  class="btn btn-primary" id="tombol-scan-barang" data-toggle="modal" data-target="#scan_kamera_barang"><i class="fa fa-qrcode"></i> <span>Scan barang</span></button>
                                <button type="button"  disabled id="tombol-scan-rak" class="btn btn-primary"  data-toggle="modal" data-target="#scan_kamera_rak"><i class="fa fa-qrcode"></i> <span>Scan rak</span></button>
                                @endif
                            </div>
                        </div>
                      </div>
                        <div class="container mt-2">
                        <div class="row">
                            <div class="col">
                              <div class="table-responsive mt-2">
                                <table id="table_scan" class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr class="tr-table text-center">
                                            <th class="th-table" style="font-size: 12px;"><input type="checkbox" class="center" id="checkAll" name="vehicle1"></th>
                                            <th class="th-table" style="font-size: 12px;">Nama Barang</th>
                                            <th class="th-table" style="font-size: 12px;">Kode Barang</th>
                                            <th class="th-table" style="font-size: 12px;">Berat Barang</th>
                                            <th class="th-table" style="font-size: 12px;">Kode Rak saat ini</th>
                                            <th class="th-table" style="font-size: 12px;">Kode Rak pindah</th>
                                            <th class="th-table" style="font-size: 12px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <tr>
                                            <td colspan="99" class="text-center">Scan Barang</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                      </div>
                    @endif
                    @if($type != "lihat")
                    <div class="form-group">
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                <button type="button" id="simpan" class="btn btn-primary btn-data">Simpan</button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
          </div>


<!-- scan barang -->
<div class="modal fade" id="scan_kamera_barang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Scan QR CODE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="qr-reader-barang" style="width: 100%"></div>
            {{-- <video id="qr-reader-barang" style="width: 100%"></video> --}}
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
  <!-- scan rak -->
  <div class="modal fade" id="scan_kamera_rak" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Scan QR CODE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="qr-reader-rak" style="width: 100%"></div>
            {{-- <video id="qr-reader-rak" style="width: 100%"></video> --}}
            <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
              <label class="btn btn-primary active">
                <input type="radio" name="options_r" value="1" autocomplete="off" checked> Front Camera
              </label>
              <label class="btn btn-secondary">
                <input type="radio" name="options_r" value="2" autocomplete="off"> Back Camera
              </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>