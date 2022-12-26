<?php

namespace App\Http\Controllers\Auth;
use illuminate\support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Models\User;
class LoginController extends Controller
{



    use AuthenticatesUsers;


    protected $redirectTo = RouteServiceProvider::HOME;

    protected function _registerOrLoginUser($data){
        $user = User::where('email',$data->email)->first();
          if(!$user){
             $user = new User();
             $user->name = $data->name;
             $user->email = $data->email;
             $user->provider_id = $data->id;
             $user->avatar = $data->avatar;
             $user->save();
          }
        Auth::login($user);
        }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->stateless()->redirect();

    }
    public function handleGoogleCallback(){

      $user = Socialite::driver('google')->stateless()->user();
      
      $this->_registerorLoginUser($user);
      return redirect()->route('home');
        }

}

