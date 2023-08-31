<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js" rel="nofollow"></script>

<script>
    var data = function (){
        let valid = true, real='', message = '', title = '', type = '';
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

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
                    "url": "/data_list_barang/{{ isset($id_barang) ? $id_barang : ''}}",
                    "method": "POST",
                    "complete": function () {
                        $('.buttons-excel').hide();
                        @if(session()->get('msg') )
                            msg();
                        @else
                            swal.close();
                        @endif
                    }
                },
                'columns': [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                    { data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false },
                    { data: 'kode_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'nama_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'barang_masuk', name: 'barang_masuk', class: 'text-left' },
                    { data: 'barang_keluar', name: 'barang_keluar', class: 'text-left' },
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

        var table_restore = function(){
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
                    "url": "/data_list_barang_trash/{{ isset($id_barang) ? $id_barang : ''}}",
                    "method": "POST",
                    "complete": function () {
                        $('.buttons-excel').hide();
                        @if(session()->get('msg') )
                            msg();
                        @else
                            swal.close();
                        @endif
                    }
                },
                'columns': [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                    { data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false },
                    { data: 'kode_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'nama_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'barang_masuk', name: 'barang_masuk', class: 'text-left' },
                    { data: 'barang_keluar', name: 'barang_keluar', class: 'text-left' },
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

        var table_in = function(){
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
                    "url": "/data_list_barang_in",
                    "method": "POST",
                    "complete": function () {
                        $('.buttons-excel').hide();
                        @if(session()->get('msg') )
                            msg();
                        @else
                            swal.close();
                        @endif
                    }
                },
                'columns': [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                    { data: 'kode_barang', name: 'kode_barang', class: 'text-left' },
                    { data: 'nama_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'tanggal_masuk', name: 'tanggal_masuk', class: 'text-left' },
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

        var table_out = function(){
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
                    "url": "/data_list_barang_out",
                    "method": "POST",
                    "complete": function () {
                        $('.buttons-excel').hide();
                        @if(session()->get('msg') )
                            msg();
                        @else
                            swal.close();
                        @endif
                    }
                },
                'columns': [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                    { data: 'kode_barang', name: 'kode_barang', class: 'text-left' },
                    { data: 'nama_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'tanggal_keluar', name: 'tanggal_keluar', class: 'text-left' },
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

        var msg = function(){
            @if(session()->get('msg'))
                swal.fire({
                    title: "Success",
                    text : '{{ session()->get('msg') }}',
                    confirmButtonColor: '#EF5350',
                    type: "success"
                })
            @endif
        }

        var cetak = function(t){
            $("#btn-cetak").on("click", function() {
                t.button('.buttons-excel').trigger();
            });
        }

        var muatUlang = function(){
            $('#btn-muat-ulang').on('click', function(){
                $('#table').DataTable().ajax.reload();
            });
        }

        var check_qr = function(){
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', 'https://www.soundjay.com/buttons/button-3.wav');
                
            @if($type == "barang_masuk")
                // var scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader'), scanPeriod: 5, mirror: false });
                $("#tombol-scan-barang").on('click', function(){
                    let scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader'), mirror: false });
                
                    scanner.addListener('scan', function (content) {
                        $.ajax({
                            url : "/in_barang/"+content,
                            type : "POST",
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            beforeSend: function(){
                                swal.fire({
                                    html: '<h5>Loading...</h5>',
                                    showConfirmButton: false
                                });
                                audioElement.play();
                            },
                            success: function(result){
                                if(result.type == 'success'){
                                    swal.fire({
                                        title: result.title,
                                        text : result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type : result.type,
                                    });
                                    $('#table').DataTable().ajax.reload();
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
                    });

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
                })

                $('#scan_kamera_barang').on('hidden.bs.modal', function() {
                    if (scanner) {
                        scanner.stop();
                    }
                });
                

            @elseif($type == "barang_keluar")
                $("#tombol-scan-barang").on('click', function(){
                    let scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader'), mirror: false });
                
                    scanner.addListener('scan', function (content) {
                        $.ajax({
                            url : "/out_barang/"+content,
                            type : "POST",
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            beforeSend: function(){
                                swal.fire({
                                    html: '<h5>Loading...</h5>',
                                    showConfirmButton: false
                                });
                                audioElement.play();
                            },
                            success: function(result){
                                if(result.type == 'success'){
                                    swal.fire({
                                        title: result.title,
                                        text : result.text,
                                        confirmButtonColor: result.ButtonColor,
                                        type : result.type,
                                    });
                                    $('#table').DataTable().ajax.reload();
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
                    });

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
                })
                
                $('#scan_kamera_barang').on('hidden.bs.modal', function() {
                    if (scanner) {
                        scanner.stop();
                    }
                });
            @endif
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
                        fd.append('id', data.kode_barang);

                        $.ajax({
                            url : "/delete_list_barang",
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

        var restore_one = function(){
            $('#table').on('click', '#btn-restore', function () {
                var baris = $(this).parents('tr')[0];
                var table = $('#table').DataTable();
                var data = table.row(baris).data();

                swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Memulihkan Data Ini',
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
                        fd.append('id', data.kode_barang);

                        $.ajax({
                            url : "/restore_list_barang_one",
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

        var restore_all = function(){
            $('#btn_restore').on('click', function () {

                swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Memulihkan Seluruh Data Ini',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2196F3',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.value) {

                        $.ajax({
                            url : "/restore_list_barang_all/{{ isset($id_barang) ? $id_barang : '' }}",
                            type : "POST",
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

        var ubah_data_barang = function(){
            $('#ubah_data_barang').on('click', function(){
                let data = $(this).data('id')
                if (data == 'data_trash'){
                    table_restore();
                    $(this).data('id', 'data_biasa')
                    $(this).html('<i class="bi bi-box2-fill"></i> <span>List Barang</span>')
                    $('#btn_restore').attr('style', '')
                    $('#title_list').html('List Barang Di Hapus')
                } else {
                    table();
                    $(this).data('id', 'data_trash')
                    $(this).html('<i class="bi bi-trash-fill"></i> <span>List Dihapus</span>')
                    $('#btn_restore').attr('style', 'display:none;')
                    $('#title_list').html('List Barang ')
                }
            })
        }

        return {
            init: function(){
                @if($type == "index")
                    table();
                    muatUlang();
                @elseif($type == "barang_masuk")
                    table_in();
                    muatUlang();
                    check_qr();
                @elseif($type == "barang_keluar")
                    table_out();
                    muatUlang();
                    check_qr();
                @endif
                msg();
                hapus();
                restore_one();
                restore_all();
                ubah_data_barang();
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

    
</script>