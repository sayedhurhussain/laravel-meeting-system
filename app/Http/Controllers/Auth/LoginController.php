<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function authenticate(LoginRequest $request)
    {
        $formFields = $request->validated();
    
        if (auth()->attempt($formFields)) {
            $request->session()->regenerateToken();
    
            return redirect('/meetings')->with('message', 'You are now logged in!');
        }
    
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
