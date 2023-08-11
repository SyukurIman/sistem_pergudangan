<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
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
        return view('masterdata.user.index', $this->data);
    }

    public function get_data()
    {
        $data_barang = Barang::all();
        return DataTables::of($data_barang->load('dimensi_barang'))
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
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

    public function edit()
    {
        $this->data['type'] = "edit_barang";
        return view('masterdata.barang.index', $this->data);
    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function create_qr()
    {

    }
}
