<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public $data = [
        'title' => 'Pegawai',
        'modul' => 'pegawai',
        'parent' => 'masterdata',
    ];
    
    public function index()
    {
        $this->data['type'] = "index";
        return view('masterdata.pegawai.index', $this->data);
    }

    
    public function create()
    {
        $this->data['type'] = "add_pegawai";
        return view('masterdata.pegawai.index', $this->data);
    }

    function get_data()
    {
        $data_pegawai = Pegawai::all();

        return DataTables::of($data_pegawai)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a class="btn btn-warning ml-1" href="/admin/update_pegawai/'.$row->id.'"><i class="icon-edit"></i></a> ';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })->make(true);
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'no_telp' => 'required',
        ]);

        $new_pegawai = Pegawai::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
        ]);

        if ($new_pegawai) {
            return redirect()->intended('/admin/pegawai')->with('msg', 'Data Pegawai Berhasil Di Tambahkan');;
        } else {
            return redirect()->intended('/admin/pegawai/add')->with('msg', 'Data Pegawai Tidak Berhasil Di Tambahkan');;
        }
    }

   
    public function edit($id)
    {
        $this->data['type'] = "edit_pegawai";
        if ($id != null){
            $this->data['data_pegawai'] = Pegawai::find($id);
        }
        return view('masterdata.pegawai.index', $this->data);
    
    }

    
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);
        $pegawai->nama = $request->input('nama');
        $pegawai->email = $request->input('email');
        $pegawai->alamat = $request->input('alamat');
        $pegawai->tanggal_lahir = $request->input('tanggal_lahir');
        $pegawai->no_telp = $request->input('no_telp');
        $pegawai->update();
        
        if ($pegawai) {
            return redirect()->back()->with('msg', 'Update Berhasil');
        } else {
            return redirect()->back()->with('msg', 'Update Gagal');
        }
            
    }

    
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            Pegawai::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menghapus Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        } 
    }
}
