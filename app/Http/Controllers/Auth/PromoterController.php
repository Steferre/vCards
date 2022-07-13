<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Promoter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\PromotersExport;
use Maatwebsite\Excel\Facades\Excel;
use function Ramsey\Uuid\v1;


class PromoterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request['q_name'];
        $role = $request['q_role'];
        $code = $request['q_code'];
        $bool = $request['q_bool'];

        $queryObject = DB::table('promoters')
            ->join('users', 'users.id', '=', 'promoters.userId')
            ->select('users.name', 'users.email', 'promoters.*');

        if ($name !== null)
            if ($name !== '') {
                $queryObject->where([
                    ['name', 'like', '%'.$name.'%'],
                ]);
            }
        if ($code !== null)
            if ($code !== '') {
                $queryObject->where([
                    ['code', 'like', '%'.$code.'%'],
                ]);
            }
        if ($role !== null)
            if ($role !== '') {
                $queryObject->where([
                    ['promoters.role', 'like', '%'.$role.'%'],
                ]);
            }

        if ($bool !== null)
            if ($bool !== '') {
                $queryObject->where([
                    ['active', $bool],
                ]);
            }

        $promoters = $queryObject->paginate(10);
        return view('promoters.index', [
            'promoters' => $promoters,
            'name' => $name,
            'active' => $bool,
            'role' => $role,
            'code' => $code
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('promoters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        die(); */
        // validazione dei dati che arrivano
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
            'mobile' => 'required|regex:/^[0-9]{3}+\ +[0-9]{6,10}$/',
            'role' => 'required',
            'description' => 'nullable',
            'code' => 'required',
            'team' => 'nullable',
            'area' => 'required',
            'company' => 'required',
            'active' => 'boolean|required',
            'addr1' => 'required',
            'city1' => 'required',
            'prov1' => 'required|max:2',
            'cap1' => 'digits:5|required',
            'phone1' => 'nullable|regex:/^[0]+[1-9]{1,3}+\ +[0-9]{5,10}$/',
            'addr2' => 'nullable',
            'city2' => 'nullable',
            'prov2' => 'nullable|max:2',
            'cap2' => 'nullable|digits:5',
            'phone2' => 'nullable|regex:/^[0]+[1-9]{1,3}+\ +[0-9]{5,10}$/',
            'addr3' => 'nullable',
            'city3' => 'nullable',
            'prov3' => 'nullable|max:2',
            'cap3' => 'nullable|digits:5',
            'phone3' => 'nullable|regex:/^[0]+[1-9]{1,3}+\ +[0-9]{5,10}$/',
            'pictureInput' => 'nullable',
            'pictureAction' => 'nullable',
            'signatureInput' => 'nullable',
            'signatureAction' => 'nullable',
            'website' => 'nullable',
            'extralogo' => 'required'
        ]);

        $data = $request->all();

        $user = new User;
        $user->name = $request->firstname . ' ' . $request->lastname;
        $user->email = $request->email;
        $user->password = sha1($request->email.'r@43ca_ll4');
        $user->saveOrFail();

        // prima di salvare il nuovo promoter devo verificare
        // se è stata inserita la foto o la firma o entrambe
        // qualore siano state aggiunte una o entrambe
        // allora devo salvarle anche nel filesystem
        $maxUploadSize = intval(env('MAX_UPLOAD_SIZE', '16384'));
        /* echo '<pre>';
        print_r($data['pictureInput']->getSize());
        echo '</pre>';
        die(); */
        $promoter = new Promoter;

        if (isset($data['pictureInput'])) {
            $fileExt = strtolower($data['pictureInput']->extension());
            $mimeType = strtolower($data['pictureInput']->getClientMimeType());
            $size = $data['pictureInput']->getSize();
            if ($fileExt !== 'jpg') {
                return back()->with('magicerror', 'Estensione del file FOTO non consentita');
            }
            if ($size > $maxUploadSize) {
                return back()->with('magicerror', 'La dimensione del file FOTO supera il limite consentito');
            }
            if ($mimeType !== 'image/jpeg') {
                return back()->with('magicerror', 'La tipologia del file FOTO non è supportata');
            }
            // arrivato qui i controlli sono superati
            $filename = $promoter->code . '_foto.jpg';
            $data['pictureInput']->storeAs('foto', $filename, 'public');
        }

        if (isset($data['signatureInput'])) {
            $fileExt = strtolower($data['signatureInput']->extension());
            $mimeType = strtolower($data['signatureInput']->getClientMimeType());
            $size = $data['signatureInput']->getSize();
            if ($fileExt !== 'jpg') {
                return back()->with('magicerror', 'Estensione del file FIRMA non consentita');
            }
            if ($size > $maxUploadSize) {
                return back()->with('magicerror', 'La dimensione del file FIRMA supera il limite consentito');
            }
            if ($mimeType !== 'image/jpeg') {
                return back()->with('magicerror', 'La tipologia del file FIRMA non è supportata');
            }
            // controlli superati con successo
            $filename = $promoter->code . '_firma.jpg';
            $data['signatureInput']->storeAs('firma', $filename, 'public');
        }


        $promoter->mobile = $request->mobile;
        $promoter->role = $request->role;
        $promoter->description = $request->description;
        $promoter->code = $request->code;
        $promoter->team = $request->team;
        $promoter->active = $request->active;
        $promoter->userId = $user->id;
        $promoter->area = $request->area;
        $promoter->company = $request->company;
        $promoter->team = $request->team;
        $promoter->foto = $request->pictureInput ? $promoter->code . '_foto.jpg' : null;
        $promoter->firma = $request->signatureInput ? $promoter->code . '_firma.jpg' : null;
        $promoter->addr1 = $request->addr1;
        $promoter->city1 = $request->city1;
        $promoter->prov1 = $request->prov1;
        $promoter->cap1 = $request->cap1;
        $promoter->phone1 = $request->phone1;
        $promoter->addr2 = $request->addr2;
        $promoter->city2 = $request->city2;
        $promoter->prov2 = $request->prov2;
        $promoter->cap2 = $request->cap2;
        $promoter->phone2 = $request->phone2;
        $promoter->addr3 = $request->addr3;
        $promoter->city3 = $request->city3;
        $promoter->prov3 = $request->prov3;
        $promoter->cap3 = $request->cap3;
        $promoter->phone3 = $request->phone3;
        $promoter->firstname = $request->firstname;
        $promoter->lastname = $request->lastname;
        $promoter->website = $request->website;
        $promoter->extralogo = $request->extralogo;

        $promoter->save();

        return redirect()->route('promoters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $id)
    {
        $data = $request->all();
        /* echo '<pre>';
        print_r($data);
        echo '</pre>';
        die(); */
        $promoter = Promoter::findOrFail($id);
        $user = User::findOrFail($promoter->userId);

        /* echo '<pre>';
        print_r($user);
        echo '</pre>';
        echo '<pre>';
        print_r($promoter);
        echo '</pre>';
        die(); */

        $pictureFilename   = 'foto/' . $promoter->code . '_foto.jpg';
        $signatureFilename = 'firma/' . $promoter->code . '_firma.jpg';

        $hasPicture = Storage::disk('public')->exists($pictureFilename);
        /* echo '<pre>';
        var_dump($hasPicture);
        echo '</pre>';
        die(); */
        $hasSignature = Storage::disk('public')->exists($signatureFilename);
        $pictureUrl = $hasPicture ? Storage::disk('public')->url($pictureFilename): null;
        /* echo '<pre>';
        var_dump($pictureUrl);
        echo '</pre>';
        die(); */
        $signatureUrl = $hasSignature ? Storage::disk('public')->url($signatureFilename) : null;

        return view('promoters.show', [
            'promoter' => $promoter,
            'user' => $user,
            'data' => $data,
            'foto' => $pictureUrl,
            'firma' => $signatureUrl,
            'fotopath' => $hasPicture ? $pictureFilename : null,
            'firmapath' => $hasSignature ? $signatureFilename : null
        ]);

    }
    // si può anche usare la dependency injection passando tutta l'istanza del model
    /* public function show(Promoter $promoter)
    {
        return view('promoters.show', compact('promoter'));
    } */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = $request->all();

        // recupero il promoter tramite id, ma potrei passare tutta l'istanza del model alla funzione edit
        $promoter = Promoter::findOrFail($id);
        $user = User::findOrFail($promoter->userId);

        $pictureFilename   = 'foto/' . $promoter->code . '_foto.jpg';
        $signatureFilename = 'firma/' . $promoter->code . '_firma.jpg';
        $hasPicture = Storage::disk('public')->exists($pictureFilename);
        $hasSignature = Storage::disk('public')->exists($signatureFilename);
        $pictureUrl = $hasPicture ? Storage::disk('public')->url($pictureFilename): null;
        $signatureUrl = $hasSignature ? Storage::disk('public')->url($signatureFilename) : null;


        // simile alla funzione create ma questa è per lo specifico id che vogliamo modificare
        // si deve limitare a mostrare una pagina con un form per modificare il contatto desiderato
        return view('promoters.edit', [
            'promoter' => $promoter,
            'user' => $user,
            'foto' => $pictureUrl,
            'firma' => $signatureUrl,
            'fotopath' => $hasPicture ? $pictureFilename : null,
            'firmapath' => $hasSignature ? $signatureFilename : null,
            'fullUrl' => $data['fullUrl']
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
        // Trovo il promoter che voglio modificare
        $promoter = Promoter::findOrFail($id);
        $user = User::findOrFail($promoter->userId);

        // validazione dei dati che arrivano
       $request->validate([

            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|regex:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',

            'mobile' => 'required|regex:/^[0-9]{3}+\ +[0-9]{6,10}$/',

            'phone1' => 'nullable|regex:/^[0]+[0-9]{1,3}+\ +[0-9]{5,10}$/',
            'phone2' => 'nullable|regex:/^[0]+[0-9]{1,3}+\ +[0-9]{5,10}$/',
            'phone3' => 'nullable|regex:/^[0]+[0-9]{1,3}+\ +[0-9]{5,10}$/',

            'role' => 'required',
            'description' => 'nullable',
            'code' => 'required',
            'team' => 'nullable',
            'area' => 'required',
            'company' => 'required',
            'active' => 'boolean|required',
            'website' => 'nullable',
            'extralogo' => 'required',

            'addr1' => 'required',
            'city1' => 'required',
            'prov1' => 'required|max:2',
            'cap1' => 'digits:5',


            'addr2' => 'nullable',
            'city2' => 'nullable',
            'prov2' => 'nullable|max:2',
            'cap2' => 'digits:5|nullable',


            'addr3' => 'nullable',
            'city3' => 'nullable',
            'prov3' => 'nullable|max:2',
            'cap3' => 'digits:5|nullable',


            'pictureInput' => 'nullable',
            'pictureAction' => 'nullable',
            'signatureInput' => 'nullable',
            'signatureAction' => 'nullable',
        ]);
        // recupero i dati dalla request
        $data = $request->all();


        $maxUploadSize = intval(env('MAX_UPLOAD_SIZE', '16384'));

        if (isset($data['pictureInput'])) {
            $fileExt = strtolower($data['pictureInput']->extension());
            $mimeType = strtolower($data['pictureInput']->getClientMimeType());
            $size = $data['pictureInput']->getSize();
            if ($fileExt !== 'jpg') {
                return back()->with('magicerror', 'Estensione del file FOTO non consentita');
            }
            if ($size > $maxUploadSize) {
                return back()->with('magicerror', 'La dimensione del file FOTO supera il limite consentito');
            }
            if ($mimeType !== 'image/jpeg') {
                return back()->with('magicerror', 'La tipologia del file FOTO non è supportata');
            }
        }

        if (isset($data['signatureInput'])) {
            $fileExt = strtolower($data['signatureInput']->extension());
            $mimeType = strtolower($data['signatureInput']->getClientMimeType());
            $size = $data['signatureInput']->getSize();
            if ($fileExt !== 'jpg') {
                return back()->with('magicerror', 'Estensione del file FIRMA non consentita');
            }
            if ($size > $maxUploadSize) {
                return back()->with('magicerror', 'La dimensione del file FIRMA supera il limite consentito');
            }
            if ($mimeType !== 'image/jpeg') {
                return back()->with('magicerror', 'La tipologia del file FIRMA non è supportata');
            }
        }

        /* SE ARRIVIAMO QUI i controlli sono  stati superati, possiamo gestire lo storage o la cancellazione delle due immagini */
        if (isset($data['pictureInput'])) {
            $filename = $promoter->code . '_foto.jpg';
            $data['pictureInput']->storeAs('foto', $filename, 'public');
        } else if ($data['pictureAction'] === 'delete') {
                if ($data['oldPicture'])
                    Storage::disk('public')->delete($data['oldPicture']);
        }

        if (isset($data['signatureInput'])) {
            $filename = $promoter->code . '_firma.jpg';
            $data['signatureInput']->storeAs('firma', $filename, 'public');


        } else if ($data['signatureAction']==='delete') {
            if ($data['oldSignature'])
                Storage::disk('public')->delete($data['oldSignature']);
        }

        unset($data['oldPicture']);
        unset($data['pictureAction']);
        unset($data['oldSignature']);
        unset($data['signatureAction']);

        /* echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
 */
        $promoter->extralogo = $data['extralogo'];
        // faccio l'update passando i data tramite la funzione update
        $promoter->update($data);
        $user->update( array('name' => $data['firstname'] . ' ' . $data['lastname'], 'email' => $data['email']));

        return redirect()->route('promoters.show', $promoter->id);
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

    public function disable(Request $request, $id)
    {
        $promoter = Promoter::findOrFail($id);

        $data = $request->only('active');

        $promoter->update($data);

        return redirect()->back();
    }

    public function export(Request $request) {

        $params = [];
        $name = isset($request['q_name']) ? ($request['q_name']!=='' ? $request['q_name'] : null) : null;
        $code = isset($request['q_code']) ? ($request['q_code']!=='' ? $request['q_code'] : null) : null;
        //$team = isset($request['q_team']) ? ($request['q_team']!=='' ? $request['q_team'] : null) : null;
        $bool = isset($request['q_bool']) ? ($request['q_bool']!=='' ? $request['q_bool'] : null) : null;
        if ($name) $params[] = ['name', 'like', '%'.$name.'%'];
        if ($code) $params[] = ['code', 'like', '%'.$code.'%'];
        if ($bool !== null) $params[] = ['active', $bool];

        $promoters = Promoter::join('users', 'users.id', '=', 'promoters.userId')
            ->select('promoters.code as Codice', 'promoters.company as Azienda', DB::raw("case promoters.active when 0 then 'Sospeso' when 1 then 'Attivo' end as Stato"),
                    'users.name as Nominativo', 'users.email as Email', 'promoters.mobile as Cellulare',
                    'promoters.area as Area', 'promoters.team as Team', 'promoters.role as Ruolo',
                    'promoters.addr1 as Indirizzo', 'promoters.city1 as Città', 'promoters.prov1 as Provincia',
                    'promoters.cap1 as CAP', 'promoters.phone1 as Telefono1',
                    'promoters.addr2 as Indirizzo2', 'promoters.city2 as Città2', 'promoters.prov2 as Provincia2',
                    'promoters.cap2 as CAP2', 'promoters.phone2 as Telefono2',
                    'promoters.addr3 as Indirizzo3', 'promoters.city3 as Città3', 'promoters.prov3 as Provincia3',
                    'promoters.cap3 as CAP3', 'promoters.phone3 as Telefono3'
                )
            ->where($params)
            ->get();

        /* echo '<pre>';
        print_r($promoters); die(); */

        return Excel::download(new PromotersExport($promoters), 'promoters.xlsx', \Maatwebsite\Excel\Excel::XLSX);

    }
}
