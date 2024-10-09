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
        //render register page
        return view('register');
    }
    
    public function registerPost(Request $request)
    {
        //check validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'password' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        
        // process the register
        if ($validator->fails()) {
            return redirect('register')
            ->withErrors($validator)
            ->withInput();
        } else {
            $user = new User();
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            
            //save user
            $user->save();
            
            //redirect with success message
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
        //return response()->json(['dd' => 'ss'],200);
        //check validation
        $rules = array(
            'email'      => 'required|email',
            'password' => 'required'
        );
        //return response()->json('ssss', 422);
       
        $validator = Validator::make($request->all(), $rules);
       
        $apiRequest =  ( $request->is('api/*') || $request->expectsJson() );
        // process the login
        if ($validator->fails()) {
            if ($apiRequest != false) {
                return response()->json($validator->errors(), 422);
            } else {
                return redirect('login')
                ->withErrors($validator)
                ->withInput();
            }
        } else {
            //post params for login
            $credetials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            
            //try login
            if (Auth::attempt($credetials)) {
                if ($apiRequest != false) {
                    $token = str_random(60);
                    $user = Auth::user();
                    //return response()->json(trans('messages.email-password-not-match'), 400);
                    //return response()->json(['dd' => 'ss'],400)->header("Access-Control-Allow-Origin",  "*");;
                    return response()->json(['token' => $token,'user' => $user],200);
                } else {
                    return redirect('/dashboard')->with('success', trans('messages.login-success'));
                }
                
            }
            
            //redirect with error
            if ($apiRequest != false) {
                return response()->json(trans('messages.email-password-not-match'), 400);
            } else {
                return back()->with('error', trans('messages.email-password-not-match'));
            }
            
        }
        
    }
    
    /*
     * Logout
     */
    public function logout()
    {
        //execute logout
        Auth::logout();
        
        //redirect login page
        return redirect()->route('login');
    }
}
