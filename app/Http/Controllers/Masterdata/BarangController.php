<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Dimensi_barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public $data = [
        'title' => 'Barang',
        'modul' => 'barang',
        'parent' => 'masterdata',
    ];

    public function index() 
    {
        $this->data['type'] = "index";
        return view('masterdata.barang.index', $this->data);
    }

    public function get_data()
    {
        $data_barang = Barang::all();
        return DataTables::of($data_barang->load('dimensi_barang', 'kategori'))
            ->addIndexColumn()
            ->addColumn('nama_kategori', function($row){return $row->kategori->nama_kategori;})
            ->addColumn('total_dimensi', function($row){return $row->dimensi_barang->total_dimensi;})
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<button class="btn btn-secondary btn-raised btn-xs" id="btn-generate" title="Generate"><i class="icon-camera"></i></button>';
                $btn .= '<a class="btn btn-warning ml-1" href="/admin/update_barang/'.$row->id.'"><i class="icon-edit"></i></a> ';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })->make(true);
    }

    public function create()
    {
        $this->data['type'] = "add_barang";
        $this->data['data_dimensi'] = Dimensi_barang::all();
        $this->data['data_kategori'] = Kategori::all();
        return view('masterdata.barang.index', $this->data);
    }

    public function create_dimensi()
    {
        $this->data['type'] = "add_dimensi_barang";
        return view('masterdata.barang.index', $this->data);
    }

    public function create_kategori()
    {
        $this->data['type'] = "add_kategori_barang";
        return view('masterdata.barang.index', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_barang' => 'required',
            'id_kategori' => 'required',
            'id_dimensi' => 'required',
            'berat_barang' => 'required',
        ]);

        $new_barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'id_dimensi' => $request->id_dimensi,
            'berat_barang' => $request->berat_barang,
        ]);

        if ($new_barang) {
            return redirect()->intended('/admin/barang')->with('msg', 'Data Barang Berhasil Di Tambahkan');;
        } else {
            return redirect()->intended('/admin/barang/add')->with('msg', 'Data Barang Tidak Berhasil Di Tambahkan');;
        }
    }

    public function store_dimensi(Request $request)
    {
        $this->validate($request, [
            'nama_dimensi' => 'required',
            'panjang' => 'required',
            'lebar' => 'required',
            'tinggi' => 'required',
            'total_dimensi' => 'required',
        ]);

        $new_dimensi_barang = Dimensi_barang::create([
            'nama_dimensi' => $request->nama_dimensi,
            'panjang' => $request->panjang,
            'lebar' => $request->lebar,
            'tinggi' => $request->tinggi,
            'total_dimensi' => $request->total_dimensi,
        ]);

        if ($new_dimensi_barang) {
            return redirect()->intended('/admin/barang/add')->with('msg', 'Data Barang Berhasil Di Tambahkan');;
        } else {
            return redirect()->intended('/admin/barang/dimensi/add')->with('msg', 'Data Barang Tidak Berhasil Di Tambahkan');;
        }
    }

    public function store_kategori(Request $request)
    {
        $this->validate($request, [
            'nama_kategori' => 'required',
        ]);

        $new_kategori_barang = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        if ($new_kategori_barang) {
            return redirect()->intended('/admin/barang/add')->with('msg', 'Data Barang Berhasil Di Tambahkan');;
        } else {
            return redirect()->intended('/admin/barang/kategori/add')->with('msg', 'Data Barang Tidak Berhasil Di Tambahkan');;
        }
    }

    public function edit($id)
    {
        $this->data['type'] = "edit_barang";
        $this->data['data_dimensi'] = Dimensi_barang::all();
        $this->data['data_kategori'] = Kategori::all();
        $this->data['data_barang'] = Barang::find($id);
        return view('masterdata.barang.index', $this->data);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        $barang->nama_barang = $request->input('nama_barang');
        $barang->id_dimensi = $request->input('id_dimensi');
        $barang->id_kategori = $request->input('id_kategori');
        $barang->berat_barang = $request->input('berat_barang');
        $barang->update();
        
        if ($barang) {
            return redirect()->back()->with('msg', 'Update Berhasil');
        } else {
            return redirect()->back()->with('msg', 'Update Gagal');
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            Barang::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menghapus Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        } 
    }

    public function create_qr($data)
    {
        $data_qr = QrCode::size(200)->generate($data);

        return $data_qr; 
    }
}
