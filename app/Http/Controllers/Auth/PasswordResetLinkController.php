<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        //$data = $request->all();
        //[_token] => updOdT45j4A8r8URabqoCIl7K36NsNcPfnQ0R9uB
        //[email] => stefano.ferrera@keyos.it


        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // qui devo mettere la verifica del ruolo 
        // se admin proseguo
        // se promoter blocco

        $emailToVerify = $request->only('email');

        $admin = DB::table('users')
                    ->where([
                        ['users.email', $emailToVerify],
                        ['users.role', 'admin'],
                    ])->first();
        
        /* echo '<pre>';
        print_r($admin);
        echo '</pre>';
        die(); */

        if (!$admin) {
            // l'email inserita è di un promoter o non esiste 
            return redirect()->route('password.email')->with('magicerror', 'Email non trovata o non valida');
        } else {
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            $status == Password::RESET_LINK_SENT
                ? back()->with('status', __($status))
                : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);

            
            return redirect()->route('password.email')->with('magicmessage', 'Controlla la posta, è stata inviata una mail con il link per cambiare la password.');

        }
    }
}
