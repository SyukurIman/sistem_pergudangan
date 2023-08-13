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

        return {
            init: function(){
                @if($type == "index")
                    table();
                    muatUlang();
                @endif
                msg();
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
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', 'https://www.soundjay.com/buttons/button-3.wav');
            
        @if($type == "barang_masuk")
            // var scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader'), scanPeriod: 5, mirror: false });
            let scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader') });
            
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
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });

        @elseif($type == "barang_keluar")
            let scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader') });
            
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
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });
        @endif
    });

    
</script>