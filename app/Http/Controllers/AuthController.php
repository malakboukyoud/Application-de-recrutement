<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'=>'required',
            'password'=>'required'
        ]);

        $user = DB::table('utilisateurs')
            ->where('login',$request->login)
            ->where('mot_de_passe',$request->password)
            ->first();

        if($user)
        {
            session([
                'user'=>$user
            ]);

            return redirect('/dashboard');
        }

        return back()->with('error','Identifiant ou mot de passe incorrect.');
    }
}
