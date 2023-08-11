<form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
    {{csrf_field();}}
    <label for="id_role">Nama pegawai</label>
    @if ($type == 'edit_pegawai')
        <input type="text" name="id_role" id="id_role" disabled value="{{ isset($data_pegawai) ? $data_pegawai->nama : ''}}">
    @else
        <select name="id_role" id="id_role" class="pegawai_check" required >
            <option disabled selected >Pilih Pegawai</option>
            @if (isset($data_pegawai))
                @foreach ($data_pegawai as $pegawai)
                    <option value="{{ $pegawai->id}}">{{ $pegawai->nama }}</option>
                @endforeach
            @endif
        </select>
    @endif
    
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="{{ isset($data_user) ? $data_user->username : ''}}">
    
    <label for="password">Password</label>
    <input type="text" name="password" id="password" >

    <input type="text" name="id_penghubung" id="id_penghubung" hidden>
    <input type="submit" value="Submit">

    
</form>
<button id="check_btn"> Tesss</button>