<?php

namespace App\Http\Controllers;

use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function enableTwoFactor(Request $request)
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
    
        $user->two_factor_secret = $google2fa->generateSecretKey();
        $user->two_factor_enabled = true;
        $user->save();
    
        return redirect()->back()->with('status', 'Two Factor Authentication enabled.');
    }
    
    public function disableTwoFactor(Request $request)
    {
        $user = Auth::user();
        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->save();
    
        return redirect()->back()->with('status', 'Two Factor Authentication disabled.');
    }
}