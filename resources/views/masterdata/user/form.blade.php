<div class="row col-md-12" style="margin-bottom: 1em;">
    <div class="col text-left" style="margin: 1em 0 0 -1em;">
    </div>
    <div class="col text-right" style="margin: 0 -3em 0 0;">
        <a href="/admin/user" type="button" class="btn btn-primary btn-data-sec">
            <i class="fa fa-chevron-left"></i> <span>Kembali</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="form-group">
            <div class="col-md-12">
                <h5 class="card-title">Tambah Barang</h5>
            </div>
        </div>
        <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
            {{csrf_field();}}

            <div class="form-group">
                <div class="col-md-12">
                    <label for="id_role">Nama pegawai</label>
                    @if ($type == 'edit_pegawai')
                        <input type="text" name="id_role" id="id_role" disabled value="{{ isset($data_pegawai) ? $data_pegawai->nama : ''}}">
                    @else
                        <select name="id_role" id="id_role" class="pegawai_check form-select custom-select select_form" required >
                            <option disabled selected >Pilih Pegawai</option>
                            @if (isset($data_pegawai))
                                @foreach ($data_pegawai as $pegawai)
                                    <option value="{{ $pegawai->id}}">{{ $pegawai->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-12">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="{{ isset($data_user) ? $data_user->username : ''}}">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-12">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" >
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <input type="text" name="id_penghubung" id="id_penghubung" hidden>
                    <input type="submit" class="btn btn-primary btn-data" value="Submit">
                </div>
            </div>

        </form>
    </div>
</div>