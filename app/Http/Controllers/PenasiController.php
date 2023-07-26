<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

use App\Models\Penasi;

class PenasiController extends Controller
{
    public function penasi()
    {
        return view('penasi.create');
    }

    public function index(){
        $user = Auth::user();
        $penasi = Penasi::all();
        return view('admin.penasi' , compact('user', 'penasi'));
    }

    public function laporan(){
        $user = Auth::user();
        $penasi = Penasi::all();
        return view('admin.laporan' , compact('user', 'penasi'));
    }

    public function check_penasi()
    {
        $user = Auth::user()->name;
        $penasi = Penasi::all()->where('pengirim', $user);
        return view('penasi.check' , compact('user', 'penasi'));
    }

    public function submit_penasi(Request $req)
    {   

        $validate = $req->validate([
            'jenis' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'berkasPendukung' => 'required',
        ]);

        $user = Auth::user()->name;

        $penasi = new Penasi;

        $penasi->kategori = $req->get('kategori');
        $penasi->deskripsi = $req->get('deskripsi');
        $penasi->jenis = $req->get('jenis');
        $penasi->berkasPendukung = $req->get('berkasPendukung');
        $penasi->status = "Proses";
        $penasi->pengirim = $user;

        if ($req->hasFile('berkasPendukung')) {
            $extension = $req->file('berkasPendukung')->extension();
            $filename = 'berkasPendukung'.time().'.'.$extension;
            $req->file('berkasPendukung')->storeAs(
                'public/berkasPendukung', $filename
            );
            $penasi->berkasPendukung = $filename ;
        }

        $penasi->save();

        $notification = array(
            'message' =>'Pengaduan/Aspirasi berhasil dikirim', 
            'alert-type' =>'success'
        );

        return redirect()->route('penasi')->with($notification);
    }

    public function getDataPenasi($id)
    {
        $penasi = Penasi::find($id);

        return response()->json($penasi);
    }

    public function update_penasi(Request $req){
        $penasi = Penasi::find($req->get('id'));

        $validate = $req->validate([
            'jenis' => 'required',
            'deskripsi' => 'required',
            'kategori' => 'required',
            'berkasPendukung' => 'required',
        ]);

        $penasi->judul = $req->get('judul');
        $penasi->penulis = $req->get('penulis');
        $penasi->tahun = $req->get('tahun');
        $penasi->penerbit = $req->get('penerbit');

        if($req->hasFile('cover')){
            $extension = $req->file('berkasPendukung')->extension();

            $filename = 'berkasPendukung'.time().'.'.$extension;

            $req->file('berkasPendukung')->storeAs(
                'public/cover_buku', $filename
            );

            Storage::delete('public/berkasPendukung/'.$req->get('old-berkasPendukung'));
            $penasi->berkasPendukung = $filename;
        }

        $penasi->save();

        $notification = array(
            'message' => 'Pengaduan/Aspirasi berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('penasi')->with($notification);
    }

    public function tanggapi_penasi(Request $req){
        $penasi = Penasi::find($req->get('id'));

        $validate = $req->validate([
            // 'jenis' => 'required',
            // 'deskripsi' => 'required',
            // 'kategori' => 'required',
            // 'berkasPendukung' => 'required',
            'tanggapan' => 'required',
        ]);

        // $penasi->judul = $req->get('judul');
        // $penasi->penulis = $req->get('penulis');
        // $penasi->tahun = $req->get('tahun');
        // $penasi->penerbit = $req->get('penerbit');
        $penasi->tanggapan = $req->get('tanggapan');
        $penasi->status = "Selesai";

        // if($req->hasFile('cover')){
        //     $extension = $req->file('berkasPendukung')->extension();

        //     $filename = 'berkasPendukung'.time().'.'.$extension;

        //     $req->file('berkasPendukung')->storeAs(
        //         'public/cover_buku', $filename
        //     );

        //     Storage::delete('public/berkasPendukung/'.$req->get('old-berkasPendukung'));
        //     $penasi->berkasPendukung = $filename;
        // }

        $penasi->save();

        $notification = array(
            'message' => 'Pengaduan/Aspirasi berhasil ditanggapi',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.penasi')->with($notification);
    }

    public function delete_penasi($id){
        $penasi = Penasi::find($id);        

        $user->delete();

        $success = true;
        $message = "Data penasi berhasil dihapus";

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
