<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public $data = [
        'title' => 'User',
        'modul' => 'user',
        'parent' => 'masterdata',
    ];
    
    public function index()
    {
        $this->data['type'] = "index";
        return view('masterdata.user.index', $this->data);
    }

    
    public function create()
    {
        $this->data['type'] = "add_pegawai";
        $id_pegawai = User::where('status_id', 1)->pluck('id_role');
        $this->data['data_pegawai'] = Pegawai::whereNotIn('id', $id_pegawai)->get();
        
        return view('masterdata.user.index', $this->data);
    }

    function get_data()
    {
        $data_user = User::all();

        return DataTables::of($data_user)
            ->addIndexColumn()
            ->addColumn('status', function($row){
                if($row->status_id == 1){
                    return 'Pegawai';
                } else {
                    return 'Admin';
                }
            })->addColumn('action', function($row){
                $btn = '';
                $btn .= '<div class="text-center">';
                $btn .= '<div class="btn-group btn-group-solid mx-5">';
                $btn .= '<a class="btn btn-warning ml-1" href="/admin/update_user/'.$row->id.'"><i class="icon-edit"></i></a> ';
                $btn .= '<button class="btn btn-danger btn-raised btn-xs" id="btn-hapus" title="Hapus"><i class="icon-trash"></i></button>';
                $btn .= '</div>';    
                $btn .= '</div>';
                return $btn;
            })->make(true);
    }

    
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $cek = DB::table('users')->select('id')
                    ->where('username', '=', $request->username)->first();

            if ($cek == null) {
                $data = $request->only(
                    [
                        'username', 
                        'password', 
                        'id_penghubung'
                    ]
                );

                if ($data['username']) {
                    $user = new User();
                    $user->username = $data['username'];
                    $user->status_id = '1';
                    $user->password = Hash::make($data['password']);
                    $user->id_role= $data['id_penghubung'];
                    $user->save();
                    
                }
                DB::commit();
                return redirect()->intended('/admin/user')->with('msg', 'Data User Berhasil Di Tambahkan');
            }else{
                DB::rollback();
                return redirect()->intended('/admin/user/add')->with('msg', 'Data User Sudah Ada'); 
            }
            
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return redirect()->intended('/admin/user/add')->with('msg', 'Gagal Menyimpan Data User');  
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->intended('/admin/user/add')->with('msg', 'Gagal Menyimpan Data User'); 
        }
    }

   
    public function edit($id)
    {
        $this->data['type'] = "edit_pegawai";
        
        if ($id != null){
            $this->data['data_user'] = user::find($id);
            $this->data['data_pegawai'] = Pegawai::find($this->data['data_user']->id_role);
        }
        return view('masterdata.user.index', $this->data);
    
    }

    
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
                $cek = DB::table('users')->select('id')->where('username', '=', $request->username)
                        ->where('id', '!=', $id)->first();
                
                if ($cek == null) {
                    User::where('id', $id)
                        ->update(
                            [ 'username' => $request->username,]
                        );
                        if ($request->password != "") {
                            User::where('id', $id)
                                ->update([
                                    'password' => Hash::make($request->password),
                                ]);
                        }

                DB::commit();
                return redirect()->back()->with('msg', 'Data User Berhasil Di Ubah');
            }else{
                DB::rollback();
                return redirect()->back()->with('msg', 'Data User Sudah Ada'); 
            }
            
        }catch(\Illuminate\Validation\ValidationException $em){
            DB::rollback();
            return redirect()->back()->with('msg', 'Gagal Menyimpan Data User');  
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('msg', 'Gagal Menyimpan Data User'); 
        }         
    }

    
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            User::where('id', $request->id)->delete();
            DB::commit();
            return response()->json(['title'=>'Success!','icon'=>'success','text'=>'Data Berhasil Dihapus!', 'ButtonColor'=>'#66BB6A', 'type'=>'success']); 
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['title'=>'Error','icon'=>'error','text'=>'Terjadi Error Saat Menghapus Data !!', 'ButtonColor'=>'#EF5350', 'type'=>'error']); 
        } 
    }
}
