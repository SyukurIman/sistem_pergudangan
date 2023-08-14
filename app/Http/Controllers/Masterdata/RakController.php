<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Masterdata\Rak;
use App\Models\Masterdata\DimensiRak;
use App\Models\Masterdata\SektorRak;
use Illuminate\Support\Facades\Auth;


class RakController extends Controller
{
    public $data = [
        'title' => 'Rak',
        'modul' => 'rak',
        'parent' => 'masterdata',
    ];
    
    function rak(){
        $this->data['type'] = "index";
        $this->data['data'] = null;
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function create(){
        $this->data['type'] = "create";
        $this->data['data'] = null;
        $this->data['dimensi'] = DimensiRak::get();
        $latest_id_sektor = DB::table('sektor_rak')
        ->whereMonth('created_at', '=', date('m'))
        ->whereYear('created_at', '=', date('Y'))
        ->max('id_sektor');
        $kode_sektor = $latest_id_sektor + 1;
        $this->data['kode_sektor'] = $kode_sektor;
        $last_two_digits_year = substr(date('Y'), -2);
        $this->data['kode_sektor_random'] = $last_two_digits_year . date('m') . str_pad($kode_sektor, 4, '0', STR_PAD_LEFT);
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }
    function lihat($id_sektor){
        $this->data['type'] = "lihat";
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function data_rak(){
        $query = Rak::with([
            'sektorrak'
            ])
        ->orderBy('rak.id_rak','desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<input type="checkbox" data-nama="" data-kode-rak="" class="sp-checked" value="'.$row->id_rak.'">';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('qrcode', function($row){
                $data_qr = QrCode::size(200)->generate($row->kode_rak);
                return $data_qr;
            })
            ->make(true);
    }
    
    function update($id_sektor){
        $this->data['type'] = "update";
        $query = SektorRak::where('id_sektor', '=', $id_sektor)
        ->orderBy('sektor_rak.id_sektor');
        $query = $query->first();
        $this->data['data'] = $query;
        $this->data['dimensi'] = DimensiRak::get();
        $rak = Rak::with([
            'dimensirak'
        ])
            ->where('id_sektor', '=', $id_sektor)
            ->orderBy('rak.id_rak');
        $rak = $rak->get();
        $this->data['rak'] = $rak;
        $count = $rak->count();
        $this->data['count'] = $count;

        if ($query) {
            $kode_sektor = $query->kode_sektor;
            $position_of_s = strpos($kode_sektor, 'S');
            $position_of_dash = strpos($kode_sektor, '-');
        
            if ($position_of_s !== false && $position_of_dash !== false && $position_of_s < $position_of_dash) {
                $angka_antara_s_dan_dash = substr($kode_sektor, $position_of_s + 1, $position_of_dash - $position_of_s - 1);
                $this->data['angka_antara_s_dan_dash'] = $angka_antara_s_dan_dash;
            } else {
                $this->data['angka_antara_s_dan_dash'] = 'Tidak ada angka antara S dan -';
            }
        } else {
            $this->data['angka_antara_s_dan_dash'] = 'Data tidak ditemukan';
        }
        $kode_sektor = $this->data['angka_antara_s_dan_dash'];
        $this->data['kode_sektor'] = $kode_sektor;
    	return view($this->data['parent'].'.'.$this->data['modul'].'.index', $this->data);
    }

    function table(){
        $query = Rak::with([
                    'sektorrak'
                    ])
                ->orderBy('rak.id_rak','desc');
        $query = $query->get();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a href="'.'/rak/lihat/'.$row->id_sektor.'" class="btn btn-primary btn-raised btn-xs" id="btn-lihat" title="Lihat"><i class="icon-search-new"></i></a> &nbsp;';
                $btn .= '<a href="'.'/rak/update/'.$row->id_sektor.'" class="btn btn-warning btn-raised btn-xs" id="btn-ubah" title="Ubah"><i class="icon-edit"></i></a> &nbsp;';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })
            ->make(true);
    }
    function createdimensi(Request $request){
        DB::beginTransaction();
        try{
                $dimensiRak = new DimensiRak();
                $dimensiRak->panjang = $request->panjang;
                $dimensiRak->lebar = $request->lebar;
                $dimensiRak->tinggi = $request->tinggi;
                $dimensiRak->total_dimensi = $request->total_dimensi;
                $dimensiRak->save();
    

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
    function createform(Request $request){
        DB::beginTransaction();
        try{
            $cek = DB::table('sektor_rak')
            ->select('id_sektor')
            ->where('kode_sektor', '=', $request->kode_sektor)
            ->first();
            if($cek == null){
                $sektorRak = new SektorRak();
                $sektorRak->nama_sektor = $request->nama_sektor;
                $sektorRak->kode_sektor = $request->kode_sektor;
                $sektorRak->save();

                $data = $request->only(
                    [
                        'nama_rak',
                        'kode_rak', 
                        'tipe_rak', 
                        'id_dimensi',
                        'daya_tampung',
                    ]
                );

                if ($data['nama_rak']) {
                    foreach ($data['nama_rak'] as $key => $value) {
                        $rak = new Rak();
                        $rak->id_sektor=$sektorRak->id;
                        $rak->nama_rak=$data['nama_rak'][$key];
                        $rak->kode_rak = $data['kode_rak'][$key];
                        $rak->tipe_rak = $data['tipe_rak'][$key];
                        $rak->id_dimensi_rak = $data['id_dimensi'][$key];
                        $rak->daya_tampung = $data['daya_tampung'][$key];
                        $rak->save();
                    } 
                }

                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Ditambah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
            } else{
                DB::rollback();
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'kode sektor sama!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
            
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }
    }

    function updateform(Request $request){
        DB::beginTransaction();
        try{
            $cek = DB::table('sektor_rak')
            ->select('id_sektor')
            ->where('kode_sektor', '=', $request->kode_sektor)
            ->where('id_sektor', '!=', $request->id_sektor)
            ->first();
            if($cek == null){
                SektorRak::where('id_sektor', $request->id_sektor)
                ->update(
                    [
                        'nama_sektor' => $request->nama_sektor,
                        'kode_sektor' => $request->kode_sektor,            
                    ]
                );

                $data = $request->only(
                    [
                        'nama_rak',
                        'kode_rak', 
                        'tipe_rak', 
                        'id_dimensi',
                        'daya_tampung',
                    ]
                );

                if ($data['nama_rak']) {
                    if (count(Rak::where('id_sektor', $request->id_sektor)->get()) == 0) {
                        foreach ($data['nama_rak'] as $key => $value) {
                            $rak = new Rak();
                            $rak->id_sektor=$request->id_sektor;
                            $rak->nama_rak=$data['nama_rak'][$key];
                            $rak->kode_rak = $data['kode_rak'][$key];
                            $rak->tipe_rak = $data['tipe_rak'][$key];
                            $rak->id_dimensi_rak = $data['id_dimensi'][$key];
                            $rak->daya_tampung = $data['daya_tampung'][$key];
                            $rak->save();
                        }
                    }else {
                        Rak::where('id_sektor', $request->id_sektor)->delete();
                        foreach ($data['nama_rak'] as $key => $value) {
                            $rak = new Rak();
                            $rak->id_sektor=$request->id_sektor;
                            $rak->nama_rak=$data['nama_rak'][$key];
                            $rak->kode_rak = $data['kode_rak'][$key];
                            $rak->tipe_rak = $data['tipe_rak'][$key];
                            $rak->id_dimensi_rak = $data['id_dimensi'][$key];
                            $rak->daya_tampung = $data['daya_tampung'][$key];
                            $rak->save();
                        }
                    }
                }

                DB::commit();
                return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Diubah!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
            } else{
                DB::rollback();
                return response()->json(['title'=>'Error','icon'=>'error','text'=>'Username Sudah Digunakan!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
            }
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Email tidak valid!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }   
    }

    function deleteform(Request $request){

        DB::beginTransaction();
        try{
            Orangtua::where('id_orangtua', $request->id_orangtua)->delete();
            Siswa::where('id_orangtua', $request->id_orangtua)->delete();
            DB::commit();
 
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>$e->getMessage(), 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        }   
    }

    public function create_qr($data)
    {
        $data_qr = QrCode::size(200)->generate($data);

        return $data_qr; 
    }
}