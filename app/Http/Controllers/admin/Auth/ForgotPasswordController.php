<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function broker()
    {
        return Password::broker('admins');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Attempt to send the reset link
        $response = $this->broker()->sendResetLink(
            ['email' => $request->input('email')]
        );

        if ($response == Password::RESET_LINK_SENT) {
            $user = $this->broker()->getUser($request->only('email'));
            $token = $this->broker()->createToken($user);

            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));
            return back()->with('status', trans($response));
        } else {
            return back()->withErrors(['email' => trans($response)]);
        }
    }
}
