<div class="row col-md-12" style="margin-bottom: 1em;">
    <div class="col text-left" style="margin: 1em 0 0 -1em;">
    </div>
    <div class="col text-right" style="margin: 0 -3em 0 0;">
        <a href="/admin/pegawai" type="button" class="btn btn-primary btn-data-sec">
            <i class="fa fa-chevron-left"></i> <span>Kembali</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="form-group">
            <div class="col-md-12">
                <h5 class="card-title">Tambah Pegawai</h5>
            </div>
        </div>
        <form enctype="multipart/form-data" method="post">
            {{csrf_field();}}
            <div class="form-group">
                <div class="col-md-12">
                    <label for="nama" class="form-label">Nama Pegawai</label>
                    <input type="text" name="nama" id="nama" value="{{ isset($data_pegawai) ? $data_pegawai->nama : '' }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="email" class="form-label">Email </label>
                    <input type="email" name="email" id="email" value="{{ isset($data_pegawai) ? $data_pegawai->email : '' }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ isset($data_pegawai) ? $data_pegawai->alamat : '' }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ isset($data_pegawai) ? $data_pegawai->tanggal_lahir : '' }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="no_telp" class="form-label">No. Telp</label>
                    <input type="number" name="no_telp" id="no_telp" value="{{ isset($data_pegawai) ? $data_pegawai->no_telp : '' }}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <input type="submit" class="mt-3"  value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>

<p></p> 
@if(Session::has('msg'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    swal.fire({
        title: "Success",
        text : '{{ Session::get('msg') }}',
        confirmButtonColor: '#EF5350',
        type: "success"
    })
</script>
@endif