<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Promoter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IndexController extends Controller
{
    public function index(Request $request)
    {
        // verificare se siamo loggati oppure no - e se sì, se come admin (User) o come promoter (Promoter)
        // se come promoter, il redirect va alla propria pagina di gestione

        $redirectToLogin = true;

        if (Auth::check()) {
            $user = Auth::user();

            if ($user) {
                if ($user->role==='admin') {
                    return redirect('/promoters');
                } else {
                    $promoter = Promoter::where([
                        ['userId', $user->id],
                        ['active', 1]
                    ])->first();
                    if ($promoter)
                     return redirect()->route('singleAccess.show', $promoter->id);
                }

            }

        }

        return view('auth.login');

    }
}
