<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    public function showSetupForm()
    {
        return view('auth.two-factor-setup');
    }

    public function verify(Request $request)
    {
        $request->validate(['two_factor_code' => 'required']);
        $user = Auth::user();
        $google2fa = new Google2FA();

        if ($google2fa->verifyKey($user->two_factor_secret, $request->two_factor_code)) {
            $user->two_factor_enabled = true;
            $user->save();

            return redirect()->route('dashboard')->with('status', 'Two Factor Authentication enabled.');
        }

        return back()->withErrors(['two_factor_code' => 'Invalid 2FA code.']);
    }
}