<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    // Show the reset password form
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Handle the password reset
    public function reset(Request $request)
    {
        // Validate the request
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Attempt to reset the password
        $response = $this->broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();

                event(new PasswordReset($user));

                Auth::guard('admin')->login($user);
            }
        );

        // Handle the response
        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('admin.home')->with('status', __($response));
        } else {
            return back()->withErrors(['email' => [__($response)]]);
        }
    }

    // Get the broker for admins
    protected function broker()
    {
        return Password::broker('admins');
    }
}
