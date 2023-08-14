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
                    "url": "/data_barang",
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
                    { data: 'nama_barang', name: 'nama_barang', class: 'text-left' },
                    { data: 'nama_kategori', name: 'nama_kategori', class: 'text-left' },
                    { data: 'berat_barang', name: 'berat_barang', class: 'text-left' },
                    { data: 'total_dimensi', name: 'total_dimensi', class: 'text-left' },
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

        var table_dimensi = function(){
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
                    "url": "/data_dimensi_barang",
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
                    { data: 'nama_dimensi', name: 'nama_dimensi', class: 'text-left' },
                    { data: 'panjang', name: 'panjang', class: 'text-left' },
                    { data: 'lebar', name: 'lebar', class: 'text-left' },
                    { data: 'tinggi', name: 'tinggi', class: 'text-left' },
                    { data: 'total_dimensi', name: 'total_dimensi', class: 'text-left' },
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


        var table_kategori = function(){
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
                    "url": "/data_kategori_barang",
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
                    { data: 'nama_kategori', name: 'nama_kategori', class: 'text-left' },
                    { data: 'created_at', name: 'created_at', class: 'text-left' },
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

        // btn-generate
        var show_menu_generate = function(){
            $('#table').on('click', '#btn-generate', function () {
                var baris = $(this).parents('tr')[0];
                var table = $('#table').DataTable();
                var data = table.row(baris).data();

                $('.pop_up').attr('style', 'display:block;')
                $('#id_barang').val(data.id)
                $('#nama_barang').val(data.nama_barang)

                
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
                        fd.append('id', data.id);

                        $.ajax({
                            url : "{{ $type == 'index' ? '/delete_barang' : ( $type == 'index_dimensi_barang' ? '/delete_dimensi_barang' : '/delete_kategori_barang') }}",
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
            init: function(){
                @if($type == "index")
                    table();
                    muatUlang();
                @elseif($type == 'index_dimensi_barang')
                    table_dimensi();
                @elseif($type == "index_kategori_barang")
                    table_kategori();
                @endif
                hapus();
                msg();
                show_menu_generate();
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

    @if ($type == 'add_barang')
        $(document).on('change', '#id_dimensi', function(){
            let val = $(this).val()
            @if (isset($data_dimensi))
                @foreach ($data_dimensi as $dimensi)
                    
                    let val_id = '{{ isset($dimensi->id) ? $dimensi->id : '' }}'
                    if (val == val_id) {
                        let val_panjang = '{{ isset($dimensi->panjang) ?  $dimensi->panjang : '' }}';
                        let val_lebar = '{{ isset($dimensi->lebar) ? $dimensi->lebar : ''}}'
                        let val_tinggi = '{{ isset($dimensi->tinggi) ? $dimensi->tinggi : ''}}'
                        let val_total_dimensi = '{{ isset($dimensi->total_dimensi) ? $dimensi->total_dimensi : ''}}'

                        $('#panjang_barang').val(val_panjang);
                        $('#lebar_barang').val(val_lebar);
                        $('#tinggi_barang').val(val_tinggi);
                        $('#total_dimensi').val(val_total_dimensi);
                    }
                @endforeach
            @endif
            console.log(val)
        });
    @elseif($type == 'add_dimensi_barang')
        $(document).on('change', '.data_angka', function(){
            let data_tinggi = $('#tinggi').val();
            let data_lebar = $('#lebar').val();
            let data_panjang = $('#panjang').val();

            let total_dimensi = data_panjang * data_lebar * data_tinggi;
            $('#total_dimensi').val(total_dimensi);
        })
    @endif

    $(document).on('click', '#btn-qr_code', function () {
        // var baris = $(this).parents('tr')[0];
        // var table = $('#table').DataTable();
        // var data = table.row(baris).data();

        let id_data =  $('#id_barang').val()
        let count_qr = $('#count_qr').val()

        let html_tag = ``

        for (let index = 0; index < count_qr; index++) {
            var dt = new Date();
            var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

            let kode = Math.floor(Math.random() * 1000) + 1;
            kode = id_data+'_'+kode+'_'+time;

            $.ajax({
                url : "/admin/barang/genertae_qr/"+kode,
                type : "POST",
                dataType: "html",
                contentType: false,
                processData: false,
                beforeSend: function(){
                    swal.fire({
                        html: '<h5>Loading...</h5>',
                        showConfirmButton: false
                    });
                },
                success: function(result){
                    html = `<div class='col m-2 border'> `+index+` - `+result+` </div>`
                    $(".list_qr_code").prepend(html);
                    console.log(result)
                }})
            
        }
        swal.close();
    });

    $(document).on('click', '#cetak_qr', function(){
        var data = $('.list_qr_code').html();
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();

        // var data_header = $('#header_data').html();

        var opt = { filename: 'Cetak qr_code - '+time+'.pdf',
                    margin: [10, 10, 10, 10],
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas:  { dpi: 500,
                                    scale:4,
                                    letterRendering: true,
                                    useCORS: true},
                    pagebreak: {
                        mode: ['avoid-all', 'css', 'a4']
                    },
        };
        html2pdf().set(opt).from(data).toPdf().get('pdf').then((pdf) => {
            var totalPages = pdf.internal.getNumberOfPages();

            for (let i = 1; i <= totalPages; i++) {
                // set footer to every page
                pdf.setPage(i);
                // set footer font
                pdf.setFontSize(10);
                pdf.setTextColor(150);
                // this example gets internal pageSize just as an example to locate your text near the borders in case you want to do something like "Page 3 out of 4"
                // pdf.addImage('http://127.0.0.1:8000/img/header.png', 'png', 15, 0, pdf.internal.pageSize.getWidth()-30, 40)
            }
        
        }).save();
    })
</script>