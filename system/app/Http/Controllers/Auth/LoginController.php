<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
use Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    protected function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!auth()->guard("web")->attempt($validator->validated())) {
            return $this->sendFailedLoginResponse($request);
        }

        if (!$token = auth()->guard("api")->attempt($validator->validated())) {
            return $this->sendFailedLoginResponse($request);
        }

        $genTokenApi = $this->respondWithToken($token);
        \Session::put('token', $genTokenApi);

        return redirect($this->redirectPath());
    }
    public function controlLogout()
    {
        Auth::logout();
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 100000
        ];
    }
}
