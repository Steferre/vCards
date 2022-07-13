<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Promoter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;



class noAuthPromoterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->only('guest_email');
        // ottengo la mail da verificare
        $emailToVerify = $data['guest_email'];
        // devo controllarne la presenza nel db
        // se presente
        // mostro un messaggio/view
        // se non presente
        // messaggio di cortesia
        $message = "";
        $url = "";

        $promoter = null;
        $user = User::where([['email', $emailToVerify], ['role', 'promoter']])->first();
        if ($user) {
            $promoter = Promoter::where([
                ['userId', $user->id],
                ['active', 1]
            ])->first();
        }

        if(!$promoter) {

            return redirect()->route('login')->with('magicerror', 'Email non trovata o account non attivo');

        } else {

            $url = URL::temporarySignedRoute('singleAccess.sign-in', now()->addMinutes(30), ['user' => $user]);

            Mail::send(
                'emails.magiclink',
                ['user' => $user, 'promoter' => $promoter, 'magiclink' => $url],
                function ($m) use ($user) {
                    $m->from('noreply@azimut.it', 'AZIMUT LIBERA IMPRESA');
                    $m->to($user->email, $user->name)->subject('Link di accesso a ' . e(config('app.name')));
                }
            );
            return redirect()->route('login')->with('magicmessage', 'Controlla la posta, è stata inviata una mail con il link di accesso.');

        }
    }

    public function signIn(Request $request, $promoter)
    {


        // TODO capire perchè con haproxy salta
        /*if (!$request->hasValidSignature()) {
            abort(401);
        }*/

        // nel caso URL valido
        $user = User::findOrFail($request->user);
        $promoter = Promoter::where([
            ['userId', $user->id],
            ['active', 1]
        ])->first();

        if (($user)&&($promoter)) {
            Auth::login($user);
            return redirect()->route('singleAccess.edit', $promoter->id);
        } else {
            return redirect()->route('login')->with('magicerror', 'Email non trovata o account on attivo');
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (!Auth::check()) {
            die('non siamo loggati, non va bene');
        }

        $user = Auth::user();
        $promoter = Promoter::findOrFail($id);
        if (!$promoter) {
            die('promoter non trovato o non attivo');
        }

        if ($promoter->userId !== $user->id) {
            die('autorizzatione negata');
        }

        return view('singleAccess.show', [
            'user' => $user,
            'promoter' => $promoter
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            die('non siamo loggati, non va bene');
        }

        $user = Auth::user();
        $promoter = Promoter::findOrFail($id);
        if (!$promoter) {
            die('promoter non trovato o non attivo');

        }

        if ($promoter->userId !== $user->id) {
            die('autorizzatione negata');

        }

        if ($promoter->file) {
            $fileurl = Storage::url($promoter->file);
        } else
            $fileurl = null;

        return view('singleAccess.edit', [
            'user' => $user,
            'promoter' => $promoter,
            'fileurl' => $fileurl
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $promoter = Promoter::findOrFail($id);
        $user = $promoter->user->find($promoter->userId);

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'email_2' => 'nullable',
            'mobile' => 'required',
            'role' => 'required',
            'description' => 'nullable',
            'code' => 'required',
            'team' => 'required',
            'active' => 'boolean',
            'file' => 'nullable',
        ]);

        $data = $request->all();

        if (isset($request->file)) {

            $fileExt = strtolower($request->file('file')->extension());
            $mimeType = strtolower($request->file('file')->getClientMimeType());
            $size =  $request->file('file')->getSize();
            $maxUploadSize = intval(env('MAX_UPLOAD_SIZE', '16384'));

            // controlli di coerenza
            if ($fileExt!=='pdf') {
                return back()->with('magicerror', 'estensione del file scelto non consentita');

            }
            if ($size > $maxUploadSize) {
                return back()->with('magicerror', 'dimensione file troppo grande');

            }
            if ($mimeType !== 'application/pdf') {
                return back()->with('magicerror', 'tipologia file non supportata');

            }

            $path = $request->file('file')->store('schede');
            if (!$path) {
                return back()->with('magicerror', 'problema nel caricamento del file');

            }

            if ($promoter->file) Storage::delete($promoter->file);

            unset($data['file']);
            $data['file'] = $path;


        }

        /* echo '<pre>';
        print_r($fileName);
        echo '<br>';
        print_r($data);
        echo '</pre>'; */

        //TODO aggiornare user solo se rendiamo i campi modificabili
        //$user->update(array('name' => $data['name'], 'email' => $data['email']));


        $promoter->update($data);

        return redirect()->route('singleAccess.edit', $promoter->id)->with('magicmessage', 'dati aggiornati con successo e file caricato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dropFile($id)
    {
        $promoter = Promoter::findOrFail($id);

        if ($promoter->file) Storage::delete($promoter->file);

        DB::table('promoters')->where('file', $promoter->file)->update(array('file' => null));

        return redirect()->route('singleAccess.edit', $promoter->id);
    }
}
