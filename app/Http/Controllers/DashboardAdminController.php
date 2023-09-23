<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Barang_keluar;
use App\Models\Barang_masuk;
use App\Models\Masterdata\Rak;
use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public $data = [
        'title' => 'Dashboard',
        'modul' => 'Dashboard',
        'parent' => 'DashBoard',
    ];
    public function index()
    {
        $now = Carbon::now()->toDateString();
        $tahun = explode("-",$now)[0];
        $bulan = explode("-", $now)[1];

        $barang_masuk = []; 
        $barang_keluar = [];
        for ($i=1; $i < $bulan; $i++) { 
            if ($i < 10) {
                $mount = '0'.$i;
            } else {
                $mount = $i;
            }

            $data_dummy = [Barang_masuk::where('tanggal_masuk', 'like', '%'.$tahun.'-'.$mount.'-%')->count(), $tahun.'-'.$mount];
            array_push($barang_masuk, $data_dummy);
            $data_dummy = [Barang_keluar::where('tanggal_keluar', 'like', '%'.$tahun.'-'.$mount.'-%')->count(), $tahun.'-'.$mount];
            array_push($barang_keluar, $data_dummy);
        }
        
        $this->data['barang_masuk'] = $barang_masuk;
        $this->data['barang_keluar'] = $barang_keluar;

        $this->data['pegawai'] = Pegawai::all()->count();
        $this->data['barang'] = Barang::all()->count();
        $this->data['rak'] = Rak::all()->count();
        $this->data['akun'] = User::all()->count();
        return view('dashboardAdmin', $this->data);
    }
}
