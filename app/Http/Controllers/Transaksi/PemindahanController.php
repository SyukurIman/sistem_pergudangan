<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Masterdata\Penempatan_barang;
use App\Models\Masterdata\Pemindahan_barang;
use App\Models\Masterdata\Rak;
use App\Models\Anggota_barang;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;


class PemindahanController extends Controller
{
    public $data = [
        'title' => 'Pemindahan',
        'modul' => 'pemindahan',
        'parent' => 'transaksi',
    ];
    
    function pemindahan(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function create(){
        $this->data['type'] = "create";
        $this->data['data'] = null;
        $this->data['penempatan_barang']= Penempatan_barang::with([
                                        'rak','anggotabarang'
                                    ])->get();
        $this->data['barang'] = Barang::get();                   
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }
    function lihat($id_sektor){
        $this->data['type'] = "lihat";
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function table(){
        $query = Pemindahan_barang::with([
                    'rakAsal','rakTujuan','anggotabarang'
                    ])
                ->orderBy('pemindahan_barangs.id','desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a href="'.'/penempatan/lihat/'.$row->id.'" class="btn btn-primary btn-raised btn-xs" id="btn-lihat" title="Lihat"><i class="icon-search-new"></i></a> &nbsp;';
                $btn .= '<a href="'.'/penempatan/update/'.$row->id.'" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a> &nbsp;';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })
            ->make(true);
    }

    function createform(Request $request){
        DB::beginTransaction();
        try{
                $data = $request->only(
                    [
                        'nama_barang',
                        'id',
                        'kode_barang',
                        'kode_rak_asal',
                        'kode_rak', 
                    ]
                );

                if ($data['nama_barang']) {
                    foreach ($data['nama_barang'] as $key => $value) {
                        $cek_kode_barang = $data['kode_barang'][$key];
                        $cek = DB::table('penempatan_barangs')
                        ->select('id')
                        ->where('kode_barang', '=', $cek_kode_barang )
                        ->first();
                        if($cek != null){
                            $id_rak_asal = Rak::where('kode_rak', '=', $data['kode_rak_asal'][$key])->value('id_rak');
                            $id_rak_tujuan= Rak::where('kode_rak', '=', $data['kode_rak'][$key])->value('id_rak');
                            $pemindahan = new Pemindahan_barang();
                            $pemindahan->tanggal_pemindahan =  Carbon::now();
                            $pemindahan->kode_barang = $data['kode_barang'][$key];
                            $pemindahan->id_rak_asal = $id_rak_asal;
                            $pemindahan->id_rak_tujuan = $id_rak_tujuan;
                            $pemindahan->save();
                            
                            $id_rak = Rak::where('kode_rak', '=', $data['kode_rak'][$key])->value('id_rak');
                            Penempatan_barang::where('id', $data['id'][$key])
                            ->update(
                                [
                                    'id_rak' => $id_rak,
                                ]
                            );
                        }else{
                            DB::rollback();
                            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Barang dengan kode '.$cek_kode_barang.' belum ada dirak', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
                        }
                    }
                }
                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Ditambah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
                
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }
    }

    // function deleteform(Request $request){

    //     DB::beginTransaction();
    //     try{
    //         Orangtua::where('id_orangtua', $request->id_orangtua)->delete();
    //         Siswa::where('id_orangtua', $request->id_orangtua)->delete();
    //         DB::commit();
 
    //         return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
    //     }catch(\Exception $e){
    //         DB::rollback();
    //         return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
    //     }   
    // }

    // public function create_qr($data)
    // {
    //     $data_qr = QrCode::size(200)->generate($data);

    //     return $data_qr; 
    // }
}