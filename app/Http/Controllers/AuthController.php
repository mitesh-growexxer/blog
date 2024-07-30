<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
     * Register Page
     */
    public function register()
    {
        return view('register');
    }
    
    public function registerPost(Request $request)
    {
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'password' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        
        // process the login
        if ($validator->fails()) {
            return redirect('register')
            ->withErrors($validator)
            ->withInput();
        } else {
            $user = new User();
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            
            $user->save();
            
            return back()->with('success', trans('messages.register-success'));
        }
        
    }
    
    /*
     * Login Page
     */
    public function login()
    {
        return view('login');
    }
    
    /*
     * CheckLogin Request
     */
    public function checkLogin(Request $request)
    {
        $rules = array(
            'email'      => 'required|email',
            'password' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        
        // process the login
        if ($validator->fails()) {
            return redirect('login')
            ->withErrors($validator)
            ->withInput();
        } else {
            $credetials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            
            if (Auth::attempt($credetials)) {
                return redirect('/dashboard')->with('success', trans('messages.login-success'));
            }
            
            return back()->with('error', trans('messages.email-password-not-match'));
        }
        
    }
    
    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('login');
    }
}
