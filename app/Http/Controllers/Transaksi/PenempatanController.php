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


class PenempatanController extends Controller
{
    public $data = [
        'title' => 'Penempatan',
        'modul' => 'penempatan',
        'parent' => 'transaksi',
    ];
    
    function penempatan(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function create(){
        $this->data['type'] = "create";
        $this->data['data'] = null;
        $this->data['rak'] = Rak::get();
        $this->data['barang'] = Barang::get();
        $this->data['barang_scan']= Anggota_barang::with([
                                        'barang',
                                    ])->get();
        $this->data['cek_penempatan']= Penempatan_barang::with(['rak','anggotabarang'])->whereNull('penempatan_barangs.deleted_at')->get();
        // dd($this->data['cek_penempatan']);
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }
    function lihat($id_sektor){
        $this->data['type'] = "lihat";
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function table(){
        $query = Penempatan_barang::with([
                    'rak'
                    ])
                ->orderBy('penempatan_barangs.id','desc');
        $query = $query->get();
        return DataTables::of($query->load('anggotabarang', 'anggotabarang.barang'))
            ->addIndexColumn()
            ->addColumn('nama_barang', function($row){return $row->anggotabarang->barang->nama_barang;})
            ->addColumn('status', function($row){
                if($row->created_at == $row->updated_at){
                    return 'Baru';
                }else{
                    return 'Berpindah';
                }
                })
            ->make(true);
    }

    function createform(Request $request){
        DB::beginTransaction();
        try{
                $data = $request->only(
                    [
                        'nama_barang',
                        'kode_barang',
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
                        $id_rak = Rak::where('kode_rak', '=', $data['kode_rak'][$key])->value('id_rak');
                        $check_kapasitas = $this->check_kapasitas($id_rak, $data['kode_barang'][$key]);
                        if($cek == null && $check_kapasitas == true){
                            $penempatan = new Penempatan_barang();
                            $kode_barang=$data['kode_barang'][$key];
                            $penempatan->kode_barang=$kode_barang;
                            
                            $penempatan->id_rak = $id_rak;
                            $penempatan->save();

                            $pemindahan = new Pemindahan_barang();
                            $pemindahan->tanggal_pemindahan =  Carbon::now();
                            $pemindahan->kode_barang = $data['kode_barang'][$key];
                            $pemindahan->id_rak_asal = $id_rak;
                            $pemindahan->id_rak_tujuan = $id_rak;
                            $pemindahan->save();
                        }else{
                            DB::rollback();
                            if($check_kapasitas == false){
                                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Barang dengan kode '.$cek_kode_barang.' dan seterusnya tidak dapat ditambahkan, Rak sudah Penuh !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
                            }
                            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Barang dengan kode '.$cek_kode_barang.' sudah ada dirak', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
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

    private function check_kapasitas($id_rak, $kode_barang)
    {
        $total_dimensi = Rak::where('id_rak', $id_rak)->first()->dimensirak->total_dimensi;
        $penempatan = Penempatan_barang::where('id_rak', $id_rak)->get();
        $kode_barangs = $penempatan->pluck('kode_barang')->toArray();
        $barang = Anggota_barang::whereIn('kode_barang', $kode_barangs)->get();
        $id_barang = $barang->pluck('id_barang')->toArray();

        if(count($id_barang) >= 1){
            $dimensi = Barang::where('id', $id_barang[0])->with('dimensi_barang')->get(); // Menggunakan with() untuk eager loading
            $persentase = $dimensi->pluck('dimensi_barang.total_dimensi')->sum();
            $dimensi_barang = intval($persentase) * count($barang);

            
            $barang_new = Anggota_barang::where('kode_barang', $kode_barang)->first()->barang->dimensi_barang->total_dimensi;
            $total_dimensi_now = (intval($dimensi_barang) + intval($barang_new)) / $total_dimensi ;

            if ($total_dimensi_now*100 >= 100){
                return False; 
            } 
        } 
        return True; 
        
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