<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" rel="nofollow"></script>

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
                    "url": "/penempatan/table",
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
                    { data: 'rak.nama_rak', name: 'rak.nama_rak', class: 'text-left' },
                    { data: 'rak.kode_rak', name: 'rak.kode_rak', class: 'text-left' },
                    { data: 'status', name: 'status', class: 'text-center', orderable: false, searchable: false },
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
            $("#tombol-scan-barang").on('click', function(){
                var audioElement = document.createElement('audio');
                audioElement.setAttribute('src', 'https://www.soundjay.com/buttons/button-3.wav');

                let scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader-barang'),  mirror: false });
                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                        $('[name="options"]').on('change',function(){
                            if($(this).val()==1){
                                if(cameras[0]!=""){
                                    scanner.start(cameras[0]);
                                }else{
                                    alert('No Front camera found!');
                                }
                            }else if($(this).val()==2){
                                if(cameras[1]!=""){
                                    scanner.start(cameras[1]);
                                }else{
                                    alert('No Back camera found!');
                                }
                            }
                        });
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function (e) {
                    console.error(e);
                });
                var scannerListenerAdded = false;
                $('#scan_kamera_barang').on('shown.bs.modal', function () {
                    if (!scannerListenerAdded) {
                    scanner.addListener('scan', function (content) {
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
                                @foreach ($cek_penempatan as $c)
                                    cekBarangPenempatan.push('{{$c->kode_barang}}');
                                @endforeach
                                   if(!cekBarangPenempatan.includes(content)){
                                        contentFound = true;
                                   }
                            if(contentFound){ 
                            if (!scannedContents.includes(content)) {
                                scannedContents.push(content); 
                                @if(isset($barang_scan))
                                    var html = "";
                                    @foreach ($barang_scan as $i)
                                        if('{{$i->kode_barang}}'=== content){
                                            html += `<tr>
                                                            <td>
                                                                <input type="checkbox" class="check-barang" name="${content}" value="kode_rak${no}">
                                                            </td>
                                                            <td>{{$i->barang->nama_barang}}
                                                                <input type="hidden" name="nama_barang[]" class="form-control nama_barang border-0" style="background:none;" data-id="${no}" value="{{$i->barang->nama_barang}}" readonly required>
                                                                <p class="help-block" style="display: none;"></p>
                                                            </td>
                                                            <td>${content}
                                                                <input type="hidden" name="kode_barang[]" class="form-control kode_barang${no} border-0" data-id="${no}" value="${content}" placeholder="Scan Rak" style="background:none;" readonly required>
                                                                <p class="help-block" style="display: none;"></p>
                                                            </td>
                                                            <td>{{$i->barang->berat_barang}} kg
                                                                <input type="hidden" class="form-control border-0" data-id="${no}" value="{{$i->barang->berat_barang}} kg" style="background:none;" readonly required>
                                                                <p class="help-block" style="display: none;"></p>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="kode_rak[]" class="form-control kode_rakborder-0" id="kode_rak${no}" style="background:none;" placeholder="otomatis" readonly required>
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
                            title: 'Barang Sudah Ada Dirak',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        }
                               
                        }
                        audioElement.play();
                    });
                }

               
            }); 
            $('#scan_kamera_barang').on('hidden.bs.modal', function() {
                if (scanner) {
                    scanner.stop();
                }
            });
        })
        }

        var scanQrCodeRak = function(){
            $("#tombol-scan-rak").on('click', function(){
                var audioElement = document.createElement('audio');
                audioElement.setAttribute('src', 'https://www.soundjay.com/buttons/button-3.wav');

                let scanner_rak = new Instascan.Scanner({ video: document.getElementById('qr-reader-rak'),  mirror: false });
                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner_rak.start(cameras[0]);
                        $('[name="options_r"]').on('change',function(){
                            if($(this).val()==1){
                                if(cameras[0]!=""){
                                    scanner_rak.start(cameras[0]);
                                }else{
                                    alert('No Front camera found!');
                                }
                            }else if($(this).val()==2){
                                if(cameras[1]!=""){
                                    scanner_rak.start(cameras[1]);
                                }else{
                                    alert('No Back camera found!');
                                }
                            }
                        });
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function (e) {
                    console.error(e);
                });
                var scannerListenerRak = false;
                $('#scan_kamera_rak').on('shown.bs.modal', function () {
                if (!scannerListenerRak) {
                scanner_rak.addListener('scan', function (contentRak) {
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
                        let kode_barang =[];
                        $.each(checkbox_terpilih,function(index,elm){
                            id_kode_rak.push(elm.value);
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
                            $("#" + kodeRakElement).parent().html(contentRak);
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
                            position: 'center',
                            icon: 'warning',
                            title: 'Qr Code Salah',
                            showConfirmButton: false,
                            timer: 1500
                            })
                        }
                        scannerListenerRak = true;
                        audioElement.play();
                 });
                }
            });
            $('#scan_kamera_rak').on('hidden.bs.modal', function() {
                    if (scanner_rak) {
                         scanner_rak.stop();
                     }
            });
        })
            
        }
        $("#checkAll").on('click', function(){
            var isChecked = $("#checkAll").prop('checked');
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
                                url : "/penempatan/createform",
                                @else
                                url : "/penempatan/updateform",
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
                                            location.href = "/penempatan";
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