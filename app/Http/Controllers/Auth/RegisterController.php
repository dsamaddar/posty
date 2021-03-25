<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    public function index(){
        return view('auth.register');
    }

    public function store(Request $request){
        //dd($request);
        //dd($request->email);

        //validation
        $this->validate($request,[
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        //Store Data
        User::Create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //sign in
        Auth::attempt($request->only('email','password'));

        //redirect user
        return redirect()->route('dashboard');

    }
}
