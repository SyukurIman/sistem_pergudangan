     <!-- MAIN -->
     <div class="row col-md-12" style="margin-bottom: 1em;">
        <div class="col text-left" style="margin: 1em 0 0 -1em;">
        </div>
        <div class="col text-right" style="margin: 0 -3em 0 0;">
            <a href="/rak" type="button" class="btn btn-primary btn-data-sec">
                <i class="fa fa-chevron-left"></i> <span>Kembali</span>
            </a>
        </div>
         </div>
         @if ($type=='create' || $type=='update' || $type=='lihat')
        <div class="table-data">
            <div class="todo">
                <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
                    {{csrf_field();}}
                    <div class="form-group">
                        <h5>Data sektor rak</h5>
                        <div class="row col-md-12">
                            <div class="col-md-6 mt1">
                                <label for="nama_sektor" class="label1">nama sektor</label><span class="required">*</span>
                                <input type="hidden" name="id_sektor" value="{{($type == 'create' ? '' : $data->id_sektor)}}">
                                <input type="text" name="nama_sektor" class="form-control nama_sektor" placeholder="Silahkan Masukkan nama orangtua siswa" 
                                value="{{($type == 'create' ? '' : $data->nama_sektor)}}" required {{($type == 'lihat' ? 'disabled' : '')}} required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                            <script>
                                @if ($type=='create')
                                    $(document).ready(function() {
                                        $('.nama_sektor').val('Sektor '+ {{ $kode_sektor }});
                                    });
                                @endif
                            </script>
                            <div class="col-md-6 mt1">
                                <label for="hubungan_orangtua" class="label1">Kode Sektor</label><span class="required">*</span>
                                <input type="text" name="kode_sektor" class="form-control kode_sektor" 
                                value="{{($type == 'create' ? '' : $data->kode_sektor)}}" required {{($type == 'lihat' ? 'disabled' : '')}} readonly required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                            <script>
                                @if ($type=='create')
                                    $(document).ready(function() {
                                        $('.kode_sektor').val('S'+ {{ $kode_sektor }} +'-'+ {{ $kode_sektor_random }});
                                    });
                                @endif
                            </script>
                        </div>          
                    </div>
                    <br>
                    @if ($type=='create')
                    <div class="form-group">
                        <div class="row col-md-12">
                            <div class="col-md-12 card-siswa">
                                <h5>Data Rak 1</h5>
                                <div class="form-group mt-3 border-bottom">
                                    <div class="row col-md-15 mt-3">
                                        <div class="col-md-6 mt1">
                                             <label for="nama_rak[]" class="label1">Nama Rak</label><span class="required">*</span>
                                             <input type="text" placeholder="Silahkan Masukkan Nomor Induk Siswa" name="nama_rak[]" class="form-control nama_rak" data-id="0" required>
                                             <p class="help-block" style="display: none;"></p>
                                         </div>
                                         <div class="col-md-6 mt1">
                                             <label for="kode_rak[]" class="label1">kode rak</label><span class="required">*</span>
                                             <input type="text" name="kode_rak[]" class="form-control kode_rak" data-id="0" value="R{{$kode_sektor}}-0001" readonly required>
                                             <p class="help-block" style="display: none;"></p>
                                         </div>
                                         <div class="col-md-6 mt-2">
                                             <label for="tipe_rak[]" class="label1">tipe</label><span class="required">*</span>
                                             <select name="tipe_rak[]"  class="custom-select select_form tipe_rak"
                                                required {{($type == "lihat" ? "disabled" : "")}} data-id="0">
                                                    <option value="" >Pilih tipe</option>
                                                    <option value="Heavy Duty Racking">Heavy Duty Racking</option>
                                                    <option value="Medium Duty Racking">Medium Duty Racking</option>
                                                    <option value="Light Duty Racking">Light Duty Racking</option>
                                                </select >
                                             <p class="help-block" style="display: none;"></p>
                                         </div>
                                         <div class="col-md-6 mt-2">
                                            <label for="id_dimensi[]" class="label1">Dimensi</label><span class="required">*</span>
                                            <div class="input-group">
                                                <select name="id_dimensi[]"  class="custom-select select_form id_dimensi" data-id="0"
                                                required {{($type == "lihat" ? "disabled" : "")}}>
                                                    <option value="" >Pilih dimensi</option>
                                                    @foreach($dimensi as $i)
                                                    <option value="{{$i->id_dimensi_rak}}">
                                                        {{$i->panjang.' x '.$i->lebar.' x '.$i->tinggi.' = '.$i->total_dimensi }}
                                                    </option>
                                                    @endforeach
                                                </select >
                                                <button style="padding-right: 12px; padding-left: 12px; border-radius:0;" class="btn btn-primary fa fa-plus add-dimensi-btn" type="button" data-id="0" data-toggle="modal" data-target="#dimensi_rak" ></button>
                                            </div>
                                            <p class="help-block" style="display: none;"></p>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="daya_tampung[]" class="label1">daya tampung</label><span class="required">*</span>
                                            <input  type="number" name="daya_tampung[]" class="form-control daya_tampung" data-id="0" required>
                                            <p class="help-block" style="display: none;"></p>
                                        </div>
                                         <br>
                                         <br>
                                     </div>
                                     {{-- <div class="row col-md-15 justify-content-md-center">
                                        <div class="col-md-12 mt-3 mb-2">
                                                 <button style="width: 100%; height: 36px;" type="button" class="btn btn-danger btn-raised btn-xs btn-hapus-detail" title="Hapus"><i class="icon-trash"></i></button>
                                         </div>
                                     </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if ($type=='update'|| $type=='lihat')
                    <div class="form-group">
                        <div class="row col-md-12">
                            <div class="col-md-12 card-siswa">
                                @for ($i = 0; $i < $count; $i++)
                                <div class="form-group mt-3 border-bottom">
                                    <h5 >Data Rak {{$i + 1}}</h5>
                                    <div class="row col-md-15 mt-3 ">
                                        <div class="col-md-6 mt1">
                                            <label for="nama_rak[]" class="label1">Nama Rak</label><span class="required">*</span>
                                            <input type="hidden" name="id_rak[]" value="{{$rak[$i]->id_rak }}">
                                            <input type="text" placeholder="Silahkan Masukkan Nomor Induk Siswa" name="nama_rak[]" value="{{$rak[$i]->nama_rak }}" class="form-control nama_rak" data-id="{{$i}}" {{($type == 'lihat' ? 'disabled' : '')}} required>
                                            <p class="help-block" style="display: none;"></p>
                                        </div>
                                        <div class="col-md-6 mt1">
                                            <label for="kode_rak[]" class="label1">kode rak</label><span class="required">*</span>
                                            <input type="text" name="kode_rak[]" class="form-control kode_rak" data-id="{{$i}}" {{($type == 'lihat' ? 'disabled' : '')}} value="{{$rak[$i]->kode_rak }}" readonly required>
                                            <p class="help-block" style="display: none;"></p>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="tipe_rak[]" class="label1">tipe</label><span class="required">*</span>
                                            <select name="tipe_rak[]" {{($type == 'lihat' ? 'disabled' : '')}} class="custom-select select_form tipe_rak"
                                               required {{($type == "lihat" ? "disabled" : "")}} data-id="{{$i}}">
                                                   <option value="Heavy Duty Racking" {{$rak[$i]->tipe_rak == 'Heavy Duty Racking' ? 'selected' : ''}}>Heavy Duty Racking</option>
                                                   <option value="Medium Duty Racking" {{$rak[$i]->tipe_rak == 'Medium Duty Racking' ? 'selected' : ''}}>Medium Duty Racking</option>
                                                   <option value="Light Duty Racking" {{$rak[$i]->tipe_rak == 'Light Duty Racking' ? 'selected' : ''}}>Light Duty Racking</option>
                                               </select >
                                            <p class="help-block" style="display: none;"></p>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                           <label for="id_dimensi[]" class="label1">Dimensi</label><span class="required">*</span>
                                           <div class="input-group">
                                               <select name="id_dimensi[]" {{($type == 'lihat' ? 'disabled' : '')}} class="custom-select select_form id_dimensi" data-id="{{$i}}"
                                               required {{($type == "lihat" ? "disabled" : "")}}>
                                                   <option value="">Pilih dimensi</option>
                                                   @foreach($dimensi as $j)
                                                   <option value="{{$j->id_dimensi_rak}}"  {{$rak[$i]->id_dimensi_rak ==  $j->id_dimensi_rak ? 'selected' : ''}}>
                                                       {{$j->panjang.' x '.$j->lebar.' x '.$j->tinggi.' = '.$j->total_dimensi }}
                                                   </option>
                                                   @endforeach
                                               </select >
                                               <button style="padding-right: 12px; padding-left: 12px; border-radius:0;" class="btn btn-primary fa fa-plus add-dimensi-btn" type="button" data-id="{{$i}}" data-toggle="modal" data-target="#dimensi_rak" {{($type == "lihat" ? "hidden" : "")}}></button>
                                           </div>
                                           <p class="help-block" style="display: none;"></p>
                                       </div>
                                       <div class="col-md-6 mt-2">
                                           <label for="daya_tampung[]" class="label1">daya tampung</label><span class="required">*</span>
                                           <input  value="{{$rak[$i]->daya_tampung }}" type="number" name="daya_tampung[]" {{($type == 'lihat' ? 'disabled' : '')}} class="form-control daya_tampung" data-id="{{$i}}" required>
                                           <p class="help-block" style="display: none;"></p>
                                       </div>
                                     </div>
                                     {{-- <div {{($type == "lihat" ? "hidden" : "")}}  class="row col-md-15 justify-content-md-center">
                                        <div class="col-md-12 mt-3 mb-2">
                                                 <button style="width: 100%; height: 36px;" type="button" class="btn btn-danger btn-raised btn-xs btn-hapus-detail" title="Hapus"><i class="icon-trash"></i></button>
                                         </div>
                                     </div> --}}
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($type != "lihat")
                    <div class="form-group">
                        <div class="row col-md-12">
                            <div class="col-md-12">
                                @if ($type=='create'|| $type=='update')
                                <button type="button" id="add_row" class="btn btn-info"><b>+</b> Add</button>
                                @endif
                                <button type="button" id="simpan" class="btn btn-primary btn-data">Simpan</button>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
            @endif
@if($type == "delete")
    <div class="table-data">
        <div class="todo">
            <form id="form-data-delete" method="post" autocompleted="off" enctype="multipart/form-data">
                {{csrf_field();}}
                <div class="form-group">
                    <div class="row col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="tombol-scan-rak" class="btn btn-info"  data-toggle="modal"data-target="#scan_delete"><b>+</b>Scan rak</button>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col-md-12">
                          <div class="table-responsive mt-2">
                            <table id="table_scan" class="table stripe" style="width: 100%;">
                                <thead>
                                    <tr class="tr-table ">
                                        <th class="th-table" style="font-size: 12px;">no</th>
                                        <th class="th-table" style="font-size: 12px;">nama rak</th>
                                        <th class="th-table" style="font-size: 12px;">Kode rak</th>
                                        <th class="th-table" style="font-size: 12px;">kode sektor</th>
                                        <th class="th-table" style="font-size: 12px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left">
                                    <tr>
                                        <td colspan="99" class="text-center">Scan Rak</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row col-md-12">
                        <div class="col-md-12">
                            <button type="button" id="delete" class="btn btn-primary btn-data">delete</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif

<div class="modal fade bd-example-modal-lg" id="dimensi_rak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Dimensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="form-data-dimensi" method="post" autocompleted="off" enctype="multipart/form-data">
                        {{csrf_field();}}
                    <div class="form-group">
                        <div class="row col-md-15 mt-3">
                            <div class="col-md-6 mt1">
                                 <label for="panjang" class="label1">Panjang</label><span class="required">*</span>
                                 <input type="text" id="panjang" placeholder="Silahkan Masukkan Nomor Induk Siswa" name="panjang" class="form-control data_angka" onchange="volume()"  required>
                                 <p class="help-block" style="display: none;"></p>
                            </div>
                            <div class="col-md-6 mt1">
                                <label for="lebar" class="label1">lebar</label><span class="required">*</span>
                                <input type="text" id="lebar" placeholder="Silahkan Masukkan Nomor Induk Siswa" name="lebar" class="form-control data_angka" onchange="volume()" required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                            <div class="col-md-6 mt1">
                                <label for="tinggi"  class="label1">tinggi</label><span class="required">*</span>
                                <input type="text" id="tinggi" placeholder="Silahkan Masukkan Nomor Induk Siswa" name="tinggi" class="form-control data_angka" onchange="volume()" required>
                                <p class="help-block" style="display: none;"></p>
                            </div>
                            <div class="col-md-6 mt1">
                                <label for="total_dimensi" class="label1">Volume</label><span class="required">*</span>
                                <input type="text" id="total_dimensi" placeholder="Silahkan Masukkan Nomor Induk Siswa" name="total_dimensi" class="form-control total_dimensi">
                                <p class="help-block" style="display: none;"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="simpan_dimensi" class="btn btn-primary btn-data">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@if($type == "delete")
<div class="modal fade" id="scan_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Scan QR CODE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <video id="qr-reader-rak" style="width: 100%"></video>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
    </div>
</div>
@endif