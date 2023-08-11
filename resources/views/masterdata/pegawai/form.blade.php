<form enctype="multipart/form-data" method="post">
    {{csrf_field();}}
    <label for="nama">Nama Pegawai</label>
    <input type="text" name="nama" id="nama" value="{{ isset($data_pegawai) ? $data_pegawai->nama : '' }}">

    <label for="email">Email </label>
    <input type="email" name="email" id="email" value="{{ isset($data_pegawai) ? $data_pegawai->email : '' }}">

    <label for="alamat">Alamat</label>
    <input type="text" name="alamat" id="alamat" value="{{ isset($data_pegawai) ? $data_pegawai->alamat : '' }}">

    <label for="tanggal_lahir">Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ isset($data_pegawai) ? $data_pegawai->tanggal_lahir : '' }}">

    <label for="no_telp">No. Telp</label>
    <input type="number" name="no_telp" id="no_telp" value="{{ isset($data_pegawai) ? $data_pegawai->no_telp : '' }}">
    
    <input type="submit" value="Submit">
</form>

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