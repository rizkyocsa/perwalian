<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
class UsersController extends Controller
{
    public function user()
    {
        $user = User::All();
        return view('admin.user', compact('user'));
    }

    public function submit_user(Request $req)
    {   

        $validate = $req->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);

        $user = new User;

        $user->name = $req->get('name');
        $user->username = $req->get('username');
        $user->email = $req->get('email');
        $user->password = Hash::make('12345678');
        $user->roles_id = 2;

        $user->save();

        $notification = array(
            'message' =>'Tambah Data Siswa berhasil', 
            'alert-type' =>'success'
        );

        return redirect()->route('admin.user')->with($notification);
    }

    public function getDataPengguna($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    public function update_user(Request $req){
        $user = User::find($req->get('id'));
        // $user = User::All();

        // dd($user);

        $validate = $req->validate([
            'name' => 'required',
            // 'username' => 'required',
            // 'email' => 'required',
        ]);

        $user->name = $req->get('name');
        // $user->username = $req->get('username');
        // $user->email = $req->get('email');

        $user->save();

        $notification = array(
            'message' =>'Update Data Siswa berhasil', 
            'alert-type' =>'success'
        );

        return redirect()->route('admin.user')->with($notification);
    }

    public function delete_user($id){
        $user = User::find($id);        

        $user->delete();

        $success = true;
        $message = "Data user berhasil dihapus";

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
