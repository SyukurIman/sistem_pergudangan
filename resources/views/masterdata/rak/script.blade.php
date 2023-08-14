<script>
    var data = function () {
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
                    "url": "/rak/table",
                    "method": "POST",
                    "complete": function () {
                        $('.buttons-excel').hide();
                        swal.close();
                    }
                },
                'columns': [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                    { data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false },
                    { data: 'nama_rak', name: 'nama_rak', class: 'text-left' },
                    { data: 'kode_rak', name: 'kode_rak', class: 'text-left' },
                    { data: 'sektorrak.kode_sektor', name: 'sektorrak.kode_sektor', class: 'text-left' },
                    { data: 'tipe_rak', name: 'tipe_rak', class: 'text-left' },
                    { data: 'dimensi', name: 'dimensi', class: 'text-left' },
                    { data: 'daya_tampung', name: 'daya_tampung', class: 'text-left' },
                         
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

        var tableRakQrCode = function(){
            swal.fire({
                html: '<h5>Loading...</h5>',
                showConfirmButton: false
            });
            var t = $('#table_qr_rak').DataTable({
                processing: true,
                pageLength: 10,
                serverSide: true,
                searching: true,
                bLengthChange: true,
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Semua"] ],
                destroy : true,
                dom: 'Blfrtip',
                select: {
                    style: 'multi', // Mengaktifkan seleksi multiple
                    selector: 'td:first-child' // Hanya kolom pertama yang dapat dipilih (tempat checkbox)
                },
                
                buttons: [
                    {
                        extend: 'pdf',
                        text: 'Cetak',
                        exportOptions: {
                        columns: ':visible',
                        selected: true // Hanya mencetak baris yang dipilih
                        }
                    },
                ],
                'ajax': {
                    "url": "/rak/table_qrcode",
                    "method": "POST",
                    "complete": function () {
                        $('.buttons-excel').hide();
                        swal.close();
                    }
                },
                'columns': [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', class: 'text-center', orderable: false, searchable: false },
                    // { data: 'action', name: 'action', class: 'text-center', orderable: false, searchable: false },
                    { data: 'nama_rak', name: 'nama_rak', class: 'text-left' },
                    { data: 'kode_rak', name: 'kode_rak', class: 'text-left' },
                    { data: 'sektorrak.kode_sektor', name: 'sektorrak.kode_sektor', class: 'text-left' },
                    { data: 'qrcode', name: 'qrcode', class: 'text-center', orderable: false, searchable: false },    
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
        @if($type == "create" || $type == "update")
        var addRow = function(){
            $('#add_row').on('click', function(){
                var no = $('.nama_rak').length;
                var html = "";
                if(no == 0){
                    $('.card-siswa').html("");
                }
                html += `
                                <div class="form-group mt-3 border-bottom">
                                    <h5 >Data Rak ${no + 1}</h5>
                                    <div class="row col-md-15 mt-3">
                                        <div class="col-md-6 mt1">
                                             <label for="nama_rak[]" class="label1">nama rak</label><span class="required">*</span>
                                             <input type="text" name="nama_rak[]" class="form-control nama_rak" data-id="${no}" placeholder="Silahkan Masukkan nama_rak" required>
                                             <p class="help-block" style="display: none;"></p>
                                         </div>
                                         <div class="col-md-6 mt1">
                                             <label for="kode_rak[]" class="label1">kode_rak</label><span class="required">*</span>
                                             <input type="text" name="kode_rak[]" class="form-control kode_rak" data-id="${no}" value="R{{$kode_sektor}}-000${no+1}" placeholder="Silahkan Masukkan kode_rak" required>
                                             <p class="help-block" style="display: none;"></p>
                                         </div>
                                         <div class="col-md-6 mt-2">
                                             <label for="tipe_rak[]" class="label1">tipe</label><span class="required">*</span>
                                             <select name="tipe_rak[]"  class="custom-select select_form tipe_rak"
                                                required {{($type == "lihat" ? "disabled" : "")}} data-id="${no}">
                                                    <option value="" >Pilih tipe</option>
                                                    <option value="Heavy Duty Racking">Heavy Duty Racking</option>
                                                    <option value="Medium Duty Racking">Medium Duty Racking</option>
                                                    <option value="Light Duty Racking">Light Duty Racking</option>
                                                </select >
                                             <p class="help-block" style="display: none;"></p>
                                         </div>
                                         <div class="col-md-6 mt-2"">
                                            <label for="id_dimensi[]" class="label1">Dimensi</label><span class="required">*</span>
                                            <div class="input-group">
                                                <select name="id_dimensi[]"  class="custom-select select_form id_dimensi" data-id="${no}"
                                                required {{($type == "lihat" ? "disabled" : "")}}>
                                                    <option value="" >Pilih dimensi</option>
                                                    @foreach($dimensi as $i)
                                                    <option value="{{$i->id_dimensi_rak}}">
                                                        {{$i->panjang.'x'.$i->lebar.'x'.$i->tinggi.'='.$i->total_dimensi }}
                                                    </option>
                                                    @endforeach
                                                </select >
                                                <button style="padding-right: 12px; padding-left: 12px; border-radius:0;" class="btn btn-primary fa fa-plus add-dimensi-btn" type="button" data-id="0" data-toggle="modal" data-target="#dimensi_rak" ></button>
                                            </div>
                                            <p class="help-block" style="display: none;"></p>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="daya_tampung[]" class="label1">daya tampung</label><span class="required">*</span>
                                            <input  type="number" name="daya_tampung[]" class="form-control kegiatan" data-id="${no}">
                                            <p class="help-block" style="display: none;"></p>
                                        </div>
                                     </div>
                                     <div class="row col-md-15 justify-content-md-center">
                                        <div class="col-md-12 mt-3 mb-2">
                                                 <button style="width: 100%; height: 36px;" type="button" class="btn btn-danger btn-raised btn-xs btn-hapus-detail" title="Hapus"><i class="icon-trash"></i></button>
                                         </div>
                                     </div>
                                </div>
                    `;
                $('.card-siswa').append(html);
                deleteRow();
            });
        }
        @endif
        var deleteRow = function(){
            $('.btn-hapus-detail').unbind().click(function(){
                $(this).parent().parent().parent().remove();
                var html = "";
                var jmlrow = $('.nama_rak').length;
                if(jmlrow == 0){
                    html += `<tr>
                                <td colspan="99" class="text-center">Data Kosong</td>
                            </tr>`;
                    $('.card-siswa').html(html);
                }
            });
        }
        

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
                                url : "/rak/createform",
                                @else
                                url : "/rak/updateform",
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
                                            location.href = "/rak";
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
                tableRakQrCode();
                muatUlang();
                @endif
                setData();
                create();
                hapus();
                @if($type == "create" || $type == "update" )
                addRow();
                createdimensi();
                @endif
                // clickModal();
                // buttonDelete();
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

    $(document).on('click', '#cetak_qr', function(){
        console.log('test');
        var data = $('#cetak-pdf').html();
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