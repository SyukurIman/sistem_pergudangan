<table id="table" class="table stripe" style="width: 100%;">
    <thead>
        <tr class="tr-table">
            <th class="th-table" style="font-size: 12px;" >No</th>
            <th class="th-table" style="font-size: 12px;">Aksi</th>
            <th class="th-table" style="font-size: 12px;">Nama Barang</th>
            <th class="th-table" style="font-size: 12px;">Kategori</th>
            <th class="th-table" style="font-size: 12px;">Berat Barang</th>
            <th class="th-table" style="font-size: 12px;">Total Dimensi</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <tr>
            <td colspan="99" class="text-center">Data Tidak Ditemukan</td>
        </tr>
    </tbody>
</table>

<div class="pop_up" style="display: none">
    <p>Ini Pop Up</p>
    <form id="form-data" method="post" autocompleted="off" enctype="multipart/form-data">
        {{csrf_field();}}
        <input type="text" name="id_barang" id="id_barang" hidden>

        <label for="nama_barang">Nama Barang</label>
        <input type="text" name="nama_barang" id="nama_barang">

        <label for="count_qr">Jumlah Generate</label>
        <input type="number" name="count_qr" id="count_qr">
    </form>
    <button id="btn-qr_code">Generate Qr_Code</button>
    <button id="cetak_qr">Cetak Qr_Code</button>
    <div class="list_qr_code row"></div>
</div>