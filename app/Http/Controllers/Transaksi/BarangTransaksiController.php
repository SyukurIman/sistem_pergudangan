<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Anggota_barang;
use App\Models\Barang;
use App\Models\Barang_keluar;
use App\Models\Barang_masuk;
use App\Models\Masterdata\Penempatan_barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            })->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })->make(true);
    }

    public function get_data_list_trash($id)
    {
        $data_barang = Anggota_barang::onlyTrashed()->where('id_barang', $id)->get();
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
            })->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<button class="btn btn-secondary btn-raised btn-xs" id="btn-restore" title="Hapus"><i class="icon-check"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })->make(true);
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            Anggota_barang::where('kode_barang', $request->id)->delete();

            $check_in = Barang_masuk::where('kode_barang', $request->id)->first();
            if($check_in){
                Barang_masuk::where('kode_barang', $request->id)->delete();
            }

            $check_out = Barang_keluar::where('kode_barang', $request->id)->first();
            if($check_out){
                Barang_keluar::where('kode_barang', $request->id)->first();
            }

            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menghapus Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        } 
    }

    public function restore_one(Request $request)
    {
        try {
            Anggota_barang::withTrashed()->where('kode_barang', $request->id)->restore();

            Barang_masuk::withTrashed()->where('kode_barang', $request->id)->restore();
            Barang_keluar::withTrashed()->where('kode_barang', $request->id)->restore();

            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Di Pulihkan !', 'ButtonColor'=>'#66BB6A', 'type'=>'success']);
        } catch (\Exception $e) {
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Memulihkan Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }
    }

    public function restore_all($id)
    {
        try {
            $data_barang = Anggota_barang::withTrashed()->where('id_barang', $id)->get();

            foreach ($data_barang as $key => $barang) {
                Barang_masuk::withTrashed()->where('kode_barang', $barang->kode_barang)->restore();
            Barang_keluar::withTrashed()->where('kode_barang', $barang->kode_barang)->restore();
            }
            Anggota_barang::withTrashed()->where('id_barang', $id)->restore();
            

            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Di Pulihkan !', 'ButtonColor'=>'#66BB6A', 'type'=>'success']);
        } catch (\Exception $e) {
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Memulihkan Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }
    }

    public function get_list_in_barang()
    {
        $data_barang = Barang_masuk::orderBy('tanggal_masuk', 'desc')->get();
        return DataTables::of($data_barang->load('anggota_barang', 'anggota_barang.barang'))
            ->addIndexColumn()
            ->addColumn('nama_barang', function($row){return $row->anggota_barang->barang->nama_barang;})
            ->make(true);
    }

    public function get_list_out_barang()
    {
        $data_barang = Barang_keluar::orderBy('tanggal_keluar', 'desc')->get();
        return DataTables::of($data_barang->load('anggota_barang', 'anggota_barang.barang'))
            ->addIndexColumn()
            ->addColumn('nama_barang', function($row){return $row->anggota_barang->barang->nama_barang;})
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
            Penempatan_barang::where('kode_barang', $data)->delete();

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
