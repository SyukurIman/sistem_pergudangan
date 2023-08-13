<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Anggota_barang;
use App\Models\Barang;
use App\Models\Barang_keluar;
use App\Models\Barang_masuk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangTransaksiController extends Controller
{
    public $data = [
        'title' => 'Barang',
        'modul' => 'barang',
        'parent' => 'transaksi',
    ];

    public function list_barang($id)
    {
        $this->data['type'] = "index";
        $this->data['id_barang'] = $id;
        return view('transaksi.barang.index', $this->data);
    }

    public function get_data_list($id)
    {
        $data_barang = Anggota_barang::where('id_barang', $id)->get();
        return DataTables::of($data_barang->load('barang', 'barang_masuk', 'barang_keluar'))
            ->addIndexColumn()
            ->addColumn('nama_barang', function($row){return $row->barang->nama_barang;})
            ->addColumn('barang_masuk', function($row){return $row->barang_masuk->tanggal_masuk;})
            ->addColumn('barang_keluar', function($row){
                if(isset($row->barang_keluar->tanggal_keluar)){
                    return $row->barang_keluar->tanggal_keluar;
                } else {
                    return 'None';
                };
            })
            ->make(true);
    }

    public function in_barang()
    {
        $this->data['type'] = "barang_masuk";
        return view('transaksi.barang.index', $this->data);
    }

    public function in_barang_save($data)
    {
        $array_data = explode('_', $data);
        $check_barang = Barang::find($array_data[0]);
        if (!$check_barang) {
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menambahkan Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }

        $check = Anggota_barang::where('kode_barang', $data)->first();
        if (!$check) {
            $new_barang = Anggota_barang::create([
                'id_barang' => $array_data[0],
                'kode_barang' => $data
            ]);

            if ($new_barang) {
                $date_data = date("Y-m-d  H:i:s");
                $barang_masuk = Barang_masuk::create([
                    'kode_barang' => $data,
                    'tanggal_masuk' => $date_data
                ]);

                if ($barang_masuk) {
                    return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Ditambahkan!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
                } else {
                    return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menambahkan Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
                }
            } else {
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menambahkan Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
        } else {
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Data Sudah Ada  !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }
    }

    public function out_barang()
    {
        $this->data['type'] = "barang_keluar";
        return view('transaksi.barang.index', $this->data);
    }

    public function out_barang_save($data)
    {
        $array_data = explode('_', $data);
        $check_barang = Barang::find($array_data[0]);
        if (!$check_barang) {
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menambahkan Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }

        $check_Anggota = Anggota_barang::where('kode_barang', $data)->first();
        $check = Barang_keluar::where('kode_barang', $data)->first();
        if (!$check && $check_Anggota) {
            $date_data = date("Y-m-d  H:i:s");
            $barang_keluar = Barang_keluar::create([
                'kode_barang' => $data,
                'tanggal_keluar' => $date_data
            ]);

            if ($barang_keluar) {
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Ditambahkan!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
            } else {
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menambahkan Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
        } else {
            if (!$check_Anggota){
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Data Belum Di Masukkan  !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            } else if ($check) {
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Data Sudah Ada  !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
            
        }
    }
}
