<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
{{-- <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" rel="nofollow"></script> --}}

<script>
    var data = function () {
        let valid = true, real='', message = '', title = '', type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        let scannedContents = [];

        var table = function(){
            swal.fire({
                html: '<h5>Loading...</h5>',
                showConfirmButton: false
            });
            var t = $('#table').DataTable({
                processing: true,
                pageLength: 10,
                serverSide: true,
                searching: true,
                bLengthChange: true,
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Semua"] ],
                destroy : true,
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: '{{$title}} - ' + time,
                        text: '<i class="fa fa-file-excel-o"></i> Cetak',
                        titleAttr: 'Cetak',
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                page: 'current'
                            }
                        }
                    },
                ],
                'ajax': {
                    "url": "/pemindahan/table",
                    "method": "POST",
                    "complete": function () {
                        $('.buttons-excel').hide();
                        swal.close();
                    }
                },
                'columns': [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                    { data: 'nama_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'kode_barang', name: 'kode_barang', class: 'text-left' },
                    { data: 'rak_asal.kode_rak', name: 'rak_Asal.kode_rak', class: 'text-left' },
                    { data: 'rak_tujuan.kode_rak', name: 'rak_tujuan.kode_rak', class: 'text-left' }, 
                ],
                "order": [],
                "columnDefs": [
                    { "orderable": false, "targets": [0] }
                ],
                "language": {
                    "lengthMenu": "Menampilkan _MENU_ data",
                    "search": "Cari:",
                    "zeroRecords": "Data tidak ditemukan",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelumnya"
                    },
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Data kosong",
                    "infoFiltered": "(Difilter dari _MAX_ total data)"
                }
            });
            filterKolom(t);
            hideKolom(t);
            cetak(t);
        };

        var filterKolom = function(t){
            $('.toggle-vis').on('change', function (e) {
                e.preventDefault();
                var column = t.column($(this).attr('data-column'));
                column.visible(!column.visible());
            });
        }

        var hideKolom = function(t){
            var arrKolom = [];
            $('.toggle-vis').each(function(i, value){
                if(!$(value).is(":checked")){
                    arrKolom.push(i+2);
                }
            });
            arrKolom.forEach(function(val){
                var column = t.column(val);
                column.visible(!column.visible());
            });
        }

        var cetak = function(t){
            $("#btn-cetak").on("click", function() {
                t.button('.buttons-excel').trigger();
            });
        }

        var setData = function(){
            $('#table_processing').html('Loading...');
            $("select[name='name_id']").val('{{($data == null ? '' : $data->id_orangtua)}}').change();
        }

        var muatUlang = function(){
            $('#btn-muat-ulang').on('click', function(){
                $('#table').DataTable().ajax.reload();
            });
        }
    
        var deleteRow = function(){
            $('.btn-hapus-detail').unbind().click(function(){
                var id = $(this).attr('data-id');
                var classSelector = '.kode_barang' + id; // Membangun nama kelas yang sesuai dengan data-id
                var kode_barang = $(classSelector).val();
                var indexToRemove = scannedContents.indexOf(kode_barang);
                if (indexToRemove !== -1) {
                    scannedContents.splice(indexToRemove, 1);
                }
                console.log(scannedContents);
                $(this).parent().parent().remove();
                var html = "";
                var jmlrow = $('.nama_barang').length;
                if(jmlrow == 0){
                    html += `<tr>
                                <td colspan="99" class="text-center">Data Kosong</td>
                            </tr>`;
                    $('#table_scan tbody').html(html);
                }
            });
        }
        @if($type == "create")
        
            var scanQrCode = function(){
                const config = { fps: 1, qrbox: { width: 250, height: 250 }, mirror: false};
                const html5QrCode = new Html5Qrcode("qr-reader-barang");

                var audioElement = document.createElement('audio');
                audioElement.setAttribute('src', 'https://www.soundjay.com/buttons/button-3.wav');

                const qrCodeSuccessCallback = (content, decodedResult) => {
                    console.log(content);
                    const firstLetter = content.charAt(0);
                    if(firstLetter === 'R'){
                        Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'Qr Code Salah',
                        showConfirmButton: false,
                        timer: 1500
                        })
                    }else{
                        var highestDataId = 0;
                        $('.nama_barang').each(function() {
                            var dataId = $(this).data('id');
                            if (dataId > highestDataId) {
                                highestDataId = dataId;
                            }
                        });

                        var no = highestDataId > 0 ? highestDataId + 1 : 1;
                        // Tambahkan 1 untuk mendapatkan nomor berikutnya
                        if(no == 1){
                            $('#table_scan tbody').html("");
                        }
                        var contentFound = false;
                        var cekBarangPenempatan=[];
                        @foreach ($penempatan_barang as $c)
                            cekBarangPenempatan.push('{{$c->kode_barang}}');
                        @endforeach

                        if(cekBarangPenempatan.includes(content)){
                            contentFound = true;
                        }
                        if(contentFound){
                            if (!scannedContents.includes(content)) {
                                @if(isset($penempatan_barang))
                                    var html = "";
                                    @foreach ($penempatan_barang as $i)
                                        if('{{$i->kode_barang}}'=== content){
                                            scannedContents.push(content);
                                            @foreach ($barang as $k)
                                                if('{{$i->anggotabarang->id_barang}}'=== '{{$k->id}}'){
                                                    var nama_barang = '{{$k->nama_barang}}';
                                                    var berat_barang = '{{$k->berat_barang}}';
                                                }
                                            @endforeach
                                            html += `<tr>
                                                            <td>
                                                                <input type="hidden" name="id[]" value="{{$i->id}}">
                                                                <input type="checkbox" class="check-barang" name="${content}" id="{{$i->rak->kode_rak}}" value="kode_rak${no}">
                                                            </td>
                                                            <td>${nama_barang}
                                                                <input type="hidden" name="nama_barang[]" class="form-control nama_barang border-0" data-id="${no}" style="background:none;" value="${nama_barang}" readonly required>
                                                                <p class="help-block" style="display: none;"></p>
                                                            </td>
                                                            <td>{{$i->kode_barang}}
                                                                <input type="hidden" name="kode_barang[]" class="form-control kode_barang${no} border-0" data-id="${no}" style="background:none;" value="{{$i->kode_barang}}" placeholder="Scan Rak" readonly required>
                                                                <p class="help-block" style="display: none;"></p>
                                                            </td>
                                                            <td>${berat_barang}
                                                                <input type="hidden" class="form-control border-0" data-id="${no}" value="${berat_barang} kg" style="background:none;" readonly required>
                                                                <p class="help-block" style="display: none;"></p></td>
                                                            <td>{{$i->rak->kode_rak}}
                                                                <input type="hidden" name="kode_rak_asal[] " class="form-control kode_rak_asal border-0" placeholder="otomatis" style="background:none;" value="{{$i->rak->kode_rak}}" readonly required>
                                                                <p class="help-block" style="display: none;"></p>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="kode_rak[]" class="form-control kode_rak border-0" id="kode_rak${no}" style="background:none;" placeholder="otomatis"  readonly required>
                                                                <p class="help-block" style="display: none;"></p>
                                                            </td>
                                                            <td>
                                                                <button style="width: 100%; height: 36px;" type="button" class="btn btn-danger btn-raised btn-xs btn-hapus-detail" data-id="${no}" title="Hapus"><i class="icon-trash"></i></button>
                                                            </td>
                                                </tr>
                                        `;
                                    
                                        $('#table_scan tbody').append(html);
                                        deleteRow();     
                                    
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'Scan Barang Berhasil',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                    @endforeach
                                @endif
                                
                                scannerListenerAdded = true;
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'barang sudah terinput',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            }
                        }else{
                            Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'Barang Perlu Masuk Penempatan Terlebih Dahulu',
                            showConfirmButton: false,
                            timer: 2500
                            })
                        }
                    }
                    audioElement.play();
                }

                $('[name="options"]').on('change',function(){
                    console.log($(this).val())
                    html5QrCode.stop()
                    setTimeout(() => {
                        if($(this).val() == 1){
                            console.log("Ubah Option")
                            html5QrCode.start({ facingMode: "user" }, config, qrCodeSuccessCallback);
                        } else if($(this).val()==2) {
                            html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
                        }
                    }, 100);
                })

                $("#tombol-scan-barang").on('click', function(){
                    
                    // let scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader-barang'),  mirror: false });
                    // Instascan.Camera.getCameras().then(function (cameras) {
                    //     if (cameras.length > 0) {
                    //         scanner.start(cameras[0]);
                    //         $('[name="options"]').on('change',function(){
                    //             if($(this).val()==1){
                    //                 if(cameras[0]!=""){
                    //                     scanner.start(cameras[0]);
                    //                 }else{
                    //                     alert('No Front camera found!');
                    //                 }
                    //             }else if($(this).val()==2){
                    //                 if(cameras[1]!=""){
                    //                     scanner.start(cameras[1]);
                    //                 }else{
                    //                     alert('No Back camera found!');
                    //                 }
                    //             }
                    //         });
                    //     } else {
                    //         console.error('No cameras found.');
                    //     }
                    // }).catch(function (e) {
                    //     console.error(e);
                    // });

                    var scannerListenerAdded = false;
                    if (!scannerListenerAdded) {
                        console.log("Ubah Awal")
                    }
                    html5QrCode.start({ facingMode: "user" }, config, qrCodeSuccessCallback);
                    
                    $('#scan_kamera_barang').on('shown.bs.modal', function () {
                        if (!scannerListenerAdded) {
                            // scanner.addListener('scan', function (content) {
                            //     // console.log(content);
                            //     // const firstLetter = content.charAt(0);
                            //     // if(firstLetter === 'R'){
                            //     //     Swal.fire({
                            //     //     position: 'center',
                            //     //     icon: 'warning',
                            //     //     title: 'Qr Code Salah',
                            //     //     showConfirmButton: false,
                            //     //     timer: 1500
                            //     //     })
                            //     // }else{
                            //     //     var highestDataId = 0;
                            //     //     $('.nama_barang').each(function() {
                            //     //         var dataId = $(this).data('id');
                            //     //         if (dataId > highestDataId) {
                            //     //             highestDataId = dataId;
                            //     //         }
                            //     //     });

                            //     //     var no = highestDataId > 0 ? highestDataId + 1 : 1;
                            //     //     // Tambahkan 1 untuk mendapatkan nomor berikutnya
                            //     //     if(no == 1){
                            //     //         $('#table_scan tbody').html("");
                            //     //     }
                            //     //     var contentFound = false;
                            //     //     var cekBarangPenempatan=[];
                            //     //     @foreach ($penempatan_barang as $c)
                            //     //         cekBarangPenempatan.push('{{$c->kode_barang}}');
                            //     //     @endforeach

                            //     //     if(cekBarangPenempatan.includes(content)){
                            //     //         contentFound = true;
                            //     //     }
                            //     //     if(contentFound){
                            //     //         if (!scannedContents.includes(content)) {
                            //     //             @if(isset($penempatan_barang))
                            //     //                 var html = "";
                            //     //                 @foreach ($penempatan_barang as $i)
                            //     //                     if('{{$i->kode_barang}}'=== content){
                            //     //                         scannedContents.push(content);
                            //     //                         @foreach ($barang as $k)
                            //     //                             if('{{$i->anggotabarang->id_barang}}'=== '{{$k->id}}'){
                            //     //                                 var nama_barang = '{{$k->nama_barang}}';
                            //     //                                 var berat_barang = '{{$k->berat_barang}}';
                            //     //                             }
                            //     //                         @endforeach
                            //     //                         html += `<tr>
                            //     //                                         <td>
                            //     //                                             <input type="hidden" name="id[]" value="{{$i->id}}">
                            //     //                                             <input type="checkbox" class="check-barang" name="${content}" id="{{$i->rak->kode_rak}}" value="kode_rak${no}">
                            //     //                                         </td>
                            //     //                                         <td>${nama_barang}
                            //     //                                             <input type="hidden" name="nama_barang[]" class="form-control nama_barang border-0" data-id="${no}" style="background:none;" value="${nama_barang}" readonly required>
                            //     //                                             <p class="help-block" style="display: none;"></p>
                            //     //                                         </td>
                            //     //                                         <td>{{$i->kode_barang}}
                            //     //                                             <input type="hidden" name="kode_barang[]" class="form-control kode_barang${no} border-0" data-id="${no}" style="background:none;" value="{{$i->kode_barang}}" placeholder="Scan Rak" readonly required>
                            //     //                                             <p class="help-block" style="display: none;"></p>
                            //     //                                         </td>
                            //     //                                         <td>${berat_barang}
                            //     //                                             <input type="hidden" class="form-control border-0" data-id="${no}" value="${berat_barang} kg" style="background:none;" readonly required>
                            //     //                                             <p class="help-block" style="display: none;"></p></td>
                            //     //                                         <td>{{$i->rak->kode_rak}}
                            //     //                                             <input type="hidden" name="kode_rak_asal[] " class="form-control kode_rak_asal border-0" placeholder="otomatis" style="background:none;" value="{{$i->rak->kode_rak}}" readonly required>
                            //     //                                             <p class="help-block" style="display: none;"></p>
                            //     //                                         </td>
                            //     //                                         <td>
                            //     //                                             <input type="hidden" name="kode_rak[]" class="form-control kode_rak border-0" id="kode_rak${no}" style="background:none;" placeholder="otomatis"  readonly required>
                            //     //                                             <p class="help-block" style="display: none;"></p>
                            //     //                                         </td>
                            //     //                                         <td>
                            //     //                                             <button style="width: 100%; height: 36px;" type="button" class="btn btn-danger btn-raised btn-xs btn-hapus-detail" data-id="${no}" title="Hapus"><i class="icon-trash"></i></button>
                            //     //                                         </td>
                            //     //                             </tr>
                            //     //                     `;
                                                
                            //     //                     $('#table_scan tbody').append(html);
                            //     //                     deleteRow();     
                                                
                            //     //                     Swal.fire({
                            //     //                         position: 'center',
                            //     //                         icon: 'success',
                            //     //                         title: 'Scan Barang Berhasil',
                            //     //                         showConfirmButton: false,
                            //     //                         timer: 1500
                            //     //                     })
                            //     //                 }
                            //     //                 @endforeach
                            //     //             @endif
                                            
                            //     //             scannerListenerAdded = true;
                            //     //         } else {
                            //     //             Swal.fire({
                            //     //                 position: 'center',
                            //     //                 icon: 'warning',
                            //     //                 title: 'barang sudah terinput',
                            //     //                 showConfirmButton: false,
                            //     //                 timer: 2000
                            //     //             })
                            //     //         }
                            //     //     }else{
                            //     //         Swal.fire({
                            //     //         position: 'center',
                            //     //         icon: 'warning',
                            //     //         title: 'Barang Perlu Masuk Penempatan Terlebih Dahulu',
                            //     //         showConfirmButton: false,
                            //     //         timer: 2500
                            //     //         })
                            //     //     }
                            //     // }
                            //     // audioElement.play();
                            // });
                        }     
                    }); 
                
                    
                    
                })
                
                $('#scan_kamera_barang').on('hidden.bs.modal', function() {
                    if (html5QrCode) {
                        html5QrCode.stop();
                    }
                });
            }

            var scanQrCodeRak = function(){
                const config = { fps: 1, qrbox: { width: 250, height: 250 }, mirror: false};
                const html5QrCode_R = new Html5Qrcode("qr-reader-rak");

                $("#tombol-scan-rak").on('click', function(){
                    var audioElement = document.createElement('audio');
                    audioElement.setAttribute('src', 'https://www.soundjay.com/buttons/button-3.wav');

                    // let scanner_rak = new Instascan.Scanner({ video: document.getElementById('qr-reader-rak'),  mirror: false });
                    // Instascan.Camera.getCameras().then(function (cameras) {
                    //     if (cameras.length > 0) {
                    //         scanner_rak.start(cameras[0]);
                    //         $('[name="options_r"]').on('change',function(){
                    //             if($(this).val()==1){
                    //                 if(cameras[0]!=""){
                    //                     scanner_rak.start(cameras[0]);
                    //                 }else{
                    //                     alert('No Front camera found!');
                    //                 }
                    //             }else if($(this).val()==2){
                    //                 if(cameras[1]!=""){
                    //                     scanner_rak.start(cameras[1]);
                    //                 }else{
                    //                     alert('No Back camera found!');
                    //                 }
                    //             }
                    //         });
                    //     } else {
                    //         console.error('No cameras found.');
                    //     }
                    // }).catch(function (e) {
                    //     console.error(e);
                    // });

                    
                    const qrCodeSuccessCallback = (contentRak, decodedResult) => {
                        const firstLetterR = contentRak.charAt(0);
                        if(firstLetterR === 'R'){
                            @foreach ($rak as $c)
                                if('{{$c->kode_rak}}' == contentRak){
                                    var dayaTampung = '{{$c->daya_tampung}}';
                                }
                            @endforeach
                            var beratTotal =0;
                            var idBarang = [];
                            @foreach ($cek_penempatan as $k)
                                if('{{$k->rak->kode_rak}}' == contentRak){
                                    idBarang.push('{{$k->anggotabarang->id_barang}}');
                                }
                            @endforeach
                            for (var i = 0; i < idBarang.length; i++) {
                                var barangid = idBarang[i];
                                @foreach ($barang as $b)
                                if ( barangid == '{{$b->id}}' ) {
                                    beratTotal += {{$b->berat_barang}};
                                }
                                @endforeach
                            }
                            let checkbox_terpilih = $("#table_scan tbody .check-barang:checked");
                            let id_kode_rak =[];
                            let kode_rak=[];
                            let kode_barang =[];
                            $.each(checkbox_terpilih,function(index,elm){
                                id_kode_rak.push(elm.value);
                                kode_rak.push(elm.id);
                                kode_barang.push(elm.name);
                            })
                            var beratInputBarang=0;
                            for (var i = 0; i < kode_barang.length; i++) {
                                var barangKode = kode_barang[i];
                                @foreach ($barang_scan as $s)
                                if ( barangKode == '{{$s->kode_barang}}' ) {
                                    beratInputBarang += {{$s->barang->berat_barang}};
                                }
                                @endforeach
                            }
                            var sisaDayaTampung = dayaTampung - beratTotal;
                            console.log(sisaDayaTampung);
                            console.log(beratInputBarang);
                            if(!kode_rak.includes(contentRak)){
                                if(beratInputBarang > sisaDayaTampung){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Kurangi Barang, Daya tampung rak Tersisa:' + sisaDayaTampung + 'kg',
                                    });
                                }else{
                                    for (var i = 0; i < id_kode_rak.length; i++) {
                                    var kodeRakElement = id_kode_rak[i];
                                    $("#" + kodeRakElement).val(contentRak);
                                    $("#" + kodeRakElement).parent().html(contentRak+` <input value="`+contentRak+`" type="hidden" name="kode_rak[]" class="form-control kode_rak border-0" id="kode_rak`+i+`" style="background:none;" placeholder="otomatis" readonly required>
                                                                        <p class="help-block" style="display: none;"></p>`);
                                    }
                                    Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Scan Rak Berhasil',
                                    showConfirmButton: false,
                                    timer: 1500
                                    })
                                }
                            }else{
                                Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: ' kode rak pindah harus berbeda dengan kode rak asal',
                                });
                            }
                            scannerListenerRak = true;
                            
                        }else{
                            Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'Qr Code Salah',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        }
                        audioElement.play();
                    }

                    $('[name="options_r"]').on('change',function(){
                        console.log('Ubah')
                        html5QrCode_R.stop()
                        setTimeout(() => {
                            if($(this).val()==1){
                                html5QrCode_R.start({ facingMode: "user" }, config, qrCodeSuccessCallback);
                            } else if($(this).val()==2){
                                html5QrCode_R.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
                            }
                        }, 100);
                    })

                    var scannerListenerRak = false;
                    $('#scan_kamera_rak').on('shown.bs.modal', function () {
                        if (!scannerListenerRak) {
                            // scanner_rak.addListener('scan', function (contentRak) {
                            //     const firstLetterR = contentRak.charAt(0);
                            //     if(firstLetterR === 'R'){
                            //         @foreach ($rak as $c)
                            //             if('{{$c->kode_rak}}' == contentRak){
                            //                 var dayaTampung = '{{$c->daya_tampung}}';
                            //             }
                            //         @endforeach
                            //         var beratTotal =0;
                            //         var idBarang = [];
                            //         @foreach ($cek_penempatan as $k)
                            //             if('{{$k->rak->kode_rak}}' == contentRak){
                            //                 idBarang.push('{{$k->anggotabarang->id_barang}}');
                            //             }
                            //         @endforeach
                            //         for (var i = 0; i < idBarang.length; i++) {
                            //             var barangid = idBarang[i];
                            //             @foreach ($barang as $b)
                            //             if ( barangid == '{{$b->id}}' ) {
                            //                 beratTotal += {{$b->berat_barang}};
                            //             }
                            //             @endforeach
                            //         }
                            //         let checkbox_terpilih = $("#table_scan tbody .check-barang:checked");
                            //         let id_kode_rak =[];
                            //         let kode_rak=[];
                            //         let kode_barang =[];
                            //         $.each(checkbox_terpilih,function(index,elm){
                            //             id_kode_rak.push(elm.value);
                            //             kode_rak.push(elm.id);
                            //             kode_barang.push(elm.name);
                            //         })
                            //         var beratInputBarang=0;
                            //         for (var i = 0; i < kode_barang.length; i++) {
                            //             var barangKode = kode_barang[i];
                            //             @foreach ($barang_scan as $s)
                            //             if ( barangKode == '{{$s->kode_barang}}' ) {
                            //                 beratInputBarang += {{$s->barang->berat_barang}};
                            //             }
                            //             @endforeach
                            //         }
                            //         var sisaDayaTampung = dayaTampung - beratTotal;
                            //         console.log(sisaDayaTampung);
                            //         console.log(beratInputBarang);
                            //         if(!kode_rak.includes(contentRak)){
                            //             if(beratInputBarang > sisaDayaTampung){
                            //                 Swal.fire({
                            //                     icon: 'error',
                            //                     title: 'Oops...',
                            //                     text: 'Kurangi Barang, Daya tampung rak Tersisa:' + sisaDayaTampung + 'kg',
                            //                 });
                            //             }else{
                            //                 for (var i = 0; i < id_kode_rak.length; i++) {
                            //                 var kodeRakElement = id_kode_rak[i];
                            //                 $("#" + kodeRakElement).val(contentRak);
                            //                 $("#" + kodeRakElement).parent().html(contentRak+` <input value="`+contentRak+`" type="hidden" name="kode_rak[]" class="form-control kode_rak border-0" id="kode_rak`+i+`" style="background:none;" placeholder="otomatis" readonly required>
                            //                                                     <p class="help-block" style="display: none;"></p>`);
                            //                 }
                            //                 Swal.fire({
                            //                 position: 'center',
                            //                 icon: 'success',
                            //                 title: 'Scan Rak Berhasil',
                            //                 showConfirmButton: false,
                            //                 timer: 1500
                            //                 })
                            //             }
                            //         }else{
                            //             Swal.fire({
                            //                     icon: 'error',
                            //                     title: 'Oops...',
                            //                     text: ' kode rak pindah harus berbeda dengan kode rak asal',
                            //             });
                            //         }
                            //         scannerListenerRak = true;
                                    
                            //     }else{
                            //         Swal.fire({
                            //         position: 'center',
                            //         icon: 'warning',
                            //         title: 'Qr Code Salah',
                            //         showConfirmButton: false,
                            //         timer: 1500
                            //         })
                            //     }
                            //     audioElement.play();
                            // });
                            html5QrCode_R.start({ facingMode: "user" }, config, qrCodeSuccessCallback);
                            
                        }
                    });

                    $('#scan_kamera_rak').on('hidden.bs.modal', function() {
                        if (html5QrCode_R) {
                            html5QrCode_R.stop();
                        }
                    });
                })
            }

            $("#checkAll").on('click', function(){
                var isChecked = $("#checkAll").prop('checked');
                console.log(isChecked)
                $(".check-barang").prop('checked', isChecked);
                $("#tombol-scan-rak").prop('disabled', !isChecked);
            })
            
            $("#table_scan tbody").on('click','.check-barang', function(){
                if($(this).prop('checked')!=true){
                    $("#checkAll").prop('checked',false);
                }
                let semua_checkbox=$("#table_scan tbody .check-barang:checked")
                let button_scan_rak=(semua_checkbox.length>0)
                $("#tombol-scan-rak").prop('disabled', !button_scan_rak);
            })
        @endif

        var create = function(){
            $('#simpan').click( function(e) {
                e.preventDefault();
                swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Menyimpan Data Ini',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2196F3',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value) {
                        var formdata = $(this).serialize();
                        valid = true
                        var err = 0;
                        $('.help-block').hide();
                        $('.form-error').removeClass('form-error');
                        $('#form-data').find('input, select').each(function(){
                            if($(this).prop('required')){
                                if(err == 0){
                                    if($(this).val() == ""){
                                        valid = false;
                                        real = this.name;
                                        title = $('label[for="' + this.name + '"]').html();
                                        type = '';
                                        if($(this).is("input")){
                                            type = 'diisi';
                                        }else{
                                            type = 'dipilih';
                                        }
                                        err++;
                                    }
                                }
                            }
                        })
                        if(!valid){
                            if(type == 'diisi'){
                                $("input[name="+real+"]").addClass('form-error');
                                $($("input[name="+real+"]").closest('div').find('.help-block')).html(title + 'belum ' + type);
                                $($("input[name="+real+"]").closest('div').find('.help-block')).show();
                            } else{
                                $("select[name="+real+"]").closest('div').find('.select2-selection--single').addClass('form-error');
                                $($("select[name="+real+"]").closest('div').find('.help-block')).html(title + 'belum ' + type);
                                $($("select[name="+real+"]").closest('div').find('.help-block')).show();
                            }
                            
                            swal.fire({
                                text : title + 'belum ' + type,
                                type : "error",
                                confirmButtonColor: "#EF5350",
                            });
                        } else{
                            var formData = new FormData($('#form-data')[0]);
                            $.ajax({
                                @if($type == "create")
                                url : "/pemindahan/createform",
                                @else
                                url : "/pemindahan/updateform",
                                @endif
                                type : "POST",
                                data : formData,
                                processData: false,
                                contentType: false,
                                beforeSend: function(){
                                    swal.fire({
                                        html: '<h5>Loading...</h5>',
                                        showConfirmButton: false
                                    });
                                },
                                success: function(result){
                                    if(result.type == 'success'){
                                        swal.fire({
                                            title: result.title,
                                            text : result.text,
                                            confirmButtonColor: result.ButtonColor,
                                            type : result.type,
                                        }).then((result) => {
                                            location.href = "/pemindahan";
                                        });
                                    }else{
                                        swal.fire({
                                            title: result.title,
                                            text : result.text,
                                            confirmButtonColor: result.ButtonColor,
                                            type : result.type,
                                        });
                                    }
                                }
                            });
                        }
                    } else {
                        swal.fire({
                            text : 'Aksi Dibatalkan!',
                            type : "info",
                            confirmButtonColor: "#EF5350",
                        });
                    }
                });
            });
        }

        var createdimensi = function(){
            $('#simpan_dimensi').click( function(e) {
                e.preventDefault();
                swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Menyimpan Data Ini',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2196F3',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value) {
                        var formdata = $(this).serialize();
                        valid = true
                        var err = 0;
                        $('.help-block').hide();
                        $('.form-error').removeClass('form-error');
                        $('#form-data-dimensi').find('input, select').each(function(){
                            if($(this).prop('required')){
                                if(err == 0){
                                    if($(this).val() == ""){
                                        valid = false;
                                        real = this.name;
                                        title = $('label[for="' + this.name + '"]').html();
                                        type = '';
                                        if($(this).is("input")){
                                            type = 'diisi';
                                        }else{
                                            type = 'dipilih';
                                        }
                                        err++;
                                    }
                                }
                            }
                        })
                        if(!valid){
                            if(type == 'diisi'){
                                $("input[name="+real+"]").addClass('form-error');
                                $($("input[name="+real+"]").closest('div').find('.help-block')).html(title + 'belum ' + type);
                                $($("input[name="+real+"]").closest('div').find('.help-block')).show();
                            } else{
                                $("select[name="+real+"]").closest('div').find('.select2-selection--single').addClass('form-error');
                                $($("select[name="+real+"]").closest('div').find('.help-block')).html(title + 'belum ' + type);
                                $($("select[name="+real+"]").closest('div').find('.help-block')).show();
                            }
                            
                            swal.fire({
                                text : title + 'belum ' + type,
                                type : "error",
                                confirmButtonColor: "#EF5350",
                            });
                        } else{
                            var formData = new FormData($('#form-data-dimensi')[0]);
                            $.ajax({
                                url : "/rak/createdimensi",
                                type : "POST",
                                data : formData,
                                processData: false,
                                contentType: false,
                                beforeSend: function(){
                                    swal.fire({
                                        html: '<h5>Loading...</h5>',
                                        showConfirmButton: false
                                    });
                                },
                                success: function(result){
                                    if(result.type == 'success'){
                                        swal.fire({
                                            title: result.title,
                                            text : result.text,
                                            confirmButtonColor: result.ButtonColor,
                                            type : result.type,
                                        }).then((result) => {
                                            $('#dimensi_rak').modal('hide');
                                            $('#dimensi_reload').DataTable().ajax.reload();
                                        });
                                    }else{
                                        swal.fire({
                                            title: result.title,
                                            text : result.text,
                                            confirmButtonColor: result.ButtonColor,
                                            type : result.type,
                                        });
                                    }
                                }
                            });
                        }
                    } else {
                        swal.fire({
                            text : 'Aksi Dibatalkan!',
                            type : "info",
                            confirmButtonColor: "#EF5350",
                        });
                    }
                });
            });
        }

        var hapus = function(){
            $('#table').on('click', '#btn-hapus', function () {
                var baris = $(this).parents('tr')[0];
                var table = $('#table').DataTable();
                var data = table.row(baris).data();

                swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Menghapus Data Ini',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2196F3',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value) {
                        var fd = new FormData();
                        fd.append('_token','{{ csrf_token() }}');
                        fd.append('id_grub_penilaian_bulanan', data.id_grub_penilaian_bulanan);

                        $.ajax({
                            url : "/rak/deleteform",
                            type : "POST",
                            data : fd,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            beforeSend: function(){
                                swal.fire({
                                    html: '<h5>Loading...</h5>',
                                    showConfirmButton: false
                                });
                            },
                            success: function(result){
                                swal.fire({
                                    title: result.title,
                                    text : result.text,
                                    confirmButtonColor: result.ButtonColor,
                                    type : result.type,
                                });

                                if(result.type == 'success'){
                                    swal.fire({
                                        title: result.title,
                                        text : result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type : result.type,
                                    }).then((result) => {
                                        $('#table').DataTable().ajax.reload();
                                    });
                                }else{
                                    swal.fire({
                                        title: result.title,
                                        text : result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type : result.type,
                                    });
                                }
                            }
                        });
                    } else {
                        swal.fire({
                            text : 'Aksi Dibatalkan!',
                            type : "info",
                            confirmButtonColor: "#EF5350",
                        });
                    }
                });
            });
        }

        return {
            init: function () {
                @if($type == "index")
                table();
                muatUlang();
                @endif
                @if($type == "create")
                scanQrCode();
                scanQrCodeRak();
                @endif
                setData();
                create();
                hapus();
                deleteRow();
                // clickPilih();
            }
        }
    }();
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.fn.dataTable.ext.errMode = 'none';
        data.init();
    }); 

    function volume() {
        let panjang = parseFloat(document.getElementById("panjang").value);
        let lebar = parseFloat(document.getElementById("lebar").value);
        let tinggi = parseFloat(document.getElementById("tinggi").value);

        if (!isNaN(panjang) && !isNaN(lebar) && !isNaN(tinggi)) {
            let volumeHasil = panjang * lebar * tinggi;
            document.getElementById("total_dimensi").value = volumeHasil.toFixed(2);
        } else {
            document.getElementById("total_dimensi").value = "0";
        }
    }
</script>