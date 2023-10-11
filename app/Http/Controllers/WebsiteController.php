<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Alert;


class WebsiteController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->get();
        return view('website.index', compact('barang'));
        
    }
    
    public function cart()
    {
        return view('website.cart');
    }
    // public function about()
    // {
    //     return view('website.about');
    // }
    // public function kontak()
    // {
    //     return view('website.kontak');
    // }


    public function daftar()
    {
        return view('website.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'alamat' => 'required',

        ]);
    
        $user = new User;
        $user->nama = $request->input('nama');
        $user->username = $request->input('username'); 
        $user->role ='customer';
        $user->password = bcrypt($request->input('password')); 
        $user->alamat = $request->input('alamat'); 

        $user->save();
    
        return redirect()->back()->with('success', 'Akun berhasil dibuat!');
    }



 }
