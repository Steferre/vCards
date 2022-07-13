<?php

namespace App\Http\Controllers;

use \setasign\Fpdi\Fpdi;
use \setasign\Fpdi\PdfReader;

use App\Models\User;
use App\Models\Promoter;

use FPDF;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

//require_once('fpdf/fpdf.php');
require_once( base_path() . '/pdfparser/src/autoload.php');

class vCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Promoter $promoter)
    {
        $promotersList = Promoter::all();
        echo '<pre>';
        print_r($promotersList);
        echo '</pre>';

        return view('bdv.index', [
            'promoters' => $promotersList,
        ]);
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
    public function show(Request $request ,$code)
    {
        $data = null;

        $data = Promoter::where([['code', $code], ['active', 1]])->first();



        if (!$data) {
            // pagina con mex di cortesia, promoter non attivo
            return view('bdv/errorPage');

        } else {
            $otherData = User::find($data['userId']);
            /* echo '<pre>';
            var_dump($data);
            echo '<br>';
            var_dump($otherData['name']);
            echo '</pre>';
            die(); */

            return view('bdv.show', [
                'promoter' => $data,
                'user' => $otherData,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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


    public function scheda(Request $request ,$code)
    {
        $promoter = Promoter::where('code', $code)->first();
        if ($promoter) {
            if ($promoter->file) {
                return Storage::download($promoter->file, 'scheda_promoter_'. $code . '.pdf');
            }
        }
        abort('404');
    }


    public function vcard($code)
    {
        $promoter = Promoter::where('code', $code)->first();
        if (!$promoter) {
            return back();
        }
        $user = $promoter->user;
        if (!$user) {
            return back();
        }


        $vcard = 'BEGIN:VCARD'.PHP_EOL.
        'VERSION:4.0'.PHP_EOL.
        'KIND:individual'.PHP_EOL.
        'N:'.$promoter->lastname . ';' . $promoter->firstname . PHP_EOL.
        'FN:'.$user->name.PHP_EOL.
        'EMAIL:'.$user->email.PHP_EOL;

        if ($promoter->company) $vcard .= 'ORG:'.$promoter->company.PHP_EOL;
        if ($promoter->role) $vcard .= 'TITLE:'.$promoter->role.PHP_EOL;

        if ($promoter->mobile) $vcard .= 'TEL;type=CELL,VOICE,PREF;Cellulare:'.$promoter->mobile.PHP_EOL;
        if ($promoter->phone1) $vcard .= 'TEL;TYPE=OTHER,VOICE;Fisso:'.$promoter->phone1.PHP_EOL;
        if ($promoter->phone2) $vcard .= 'TEL;TYPE=OTHER,VOICE;Altro:'.$promoter->phone2.PHP_EOL;
        if ($promoter->phone3) $vcard .= 'TEL;TYPE=OTHER,VOICE;Altro:'.$promoter->phone3.PHP_EOL;

        if ($promoter->addr1&&$promoter->city1) {
            $vcard .= 'ADR;indirizzo1:;;' . $promoter->addr1 . ';' . $promoter->city1 . ';' . $promoter->prov1 . ';' . $promoter->cap1 . ';Italia'.PHP_EOL;
        }

        if ($promoter->addr2&&$promoter->city2) {
            $vcard .= 'ADR;indirizzo2:;;' . $promoter->addr2 . ';' . $promoter->city2 . ';' . $promoter->prov2 . ';' . $promoter->cap2 . ';Italia'.PHP_EOL;
        }

        if ($promoter->addr3&&$promoter->city3) {
            $vcard .= 'ADR;indirizzo3:;;' . $promoter->addr3 . ';' . $promoter->city3 . ';' . $promoter->prov3 . ';' . $promoter->cap3 . ';Italia'.PHP_EOL;
        }

        $vcard .= 'END:VCARD'.PHP_EOL;


        header('Content-Type: text/x-vcard');
        header('Content-Disposition: attachment; filename="' . $user->name . '.vcf"');
        header('Expires: 0');
        header("Cache-control: no-cache, must-revalidate");
        header("Cache-control: private");
        header('Cache-Control: max-age=0');
        header("Pragma:public");

        echo $vcard;
        exit();
        /* echo '<pre>';
        print_r($headers);
        echo '<br>';
        print_r($vcard);
        echo '</pre>';
        die();

        Special notes:  The structured type value consists of a sequence of
      address components.  The component values MUST be specified in
      their corresponding position.  The structured type value
      corresponds, in sequence, to
         the post office box;
         the extended address (e.g., apartment or suite number);
         the street address;
         the locality (e.g., city);
         the region (e.g., state or province);
         the postal code;
         the country name (full name in the language specified in
         Section 5.1).

      When a component value is missing, the associated component
      separator MUST still be specified.








        */
    }


    public function pdf($code)
    {
        //controlla se è presente il promoter
        $promoter = Promoter::where('code', $code)->first();
        if (!$promoter) {
            return back();
        }// controlla se è anche utente registrato
        $user = $promoter->user;
        if (!$user) {
            return back();
        }

        $outputfile =  $user->name . '.pdf';

        $addrcount = 0;
        if ($promoter->addr1&&$promoter->city1) {
            $addrcount++;
            $row1 = $promoter->cap1 . ' ' . $promoter->city1 . ' ' . '(' . $promoter->prov1 . ')';
        }
        if ($promoter->addr2&&$promoter->city2) {
            $addrcount++;
            $row2 = $promoter->cap2 . ' ' . $promoter->city2 . ' ' . '(' . $promoter->prov2 . ')';
        }
        if ($promoter->addr3&&$promoter->city3) {
            $addrcount++;
            $row3 = $promoter->cap3 . ' ' . $promoter->city3 . ' ' . '(' . $promoter->prov3 . ')';
        }

        $storagePath = Storage::disk('public')->getAdapter()->getPathPrefix();

        $azimutWM = $storagePath . 'images/Logo_AZ_WM.png';
        $azimutCM = $storagePath . 'images/Logo_AZ_CM.png';


        $w = 403;
        if (($addrcount===3||$addrcount===2) && $promoter->extralogo==='efpa') {
            $base = $storagePath . 'pdf/AZIMUT_BDV_EFPA_EXTRA.pdf';
        } else if (($addrcount===3||$addrcount===2) && $promoter->extralogo==='none') {
            $base = $storagePath . 'pdf/AZIMUT_BDV_BASE_EXTRA.pdf';
        } else if ($promoter->extralogo==='efpa') {
            $base = $storagePath . 'pdf/AZIMUT_BDV_EFPA_Base.pdf';
        }else {
            $base = $storagePath . 'pdf/AZIMUT_BDV_BASE_Base.pdf';
        }

        $pdf = new Fpdi();

        $pdf->AddFont('Futura-Book','','futurabook.php');
        $pdf->AddFont('Futura-Book','I','futurabooki.php');

        $pdf->setSourceFile($base);
        $pageId = $pdf->importPage(1, PdfReader\PageBoundaries::MEDIA_BOX);
        $pagesize = $pdf->getImportedPageSize($pageId);
        $pdf->SetAutoPageBreak(true, 1);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->setRightMargin(0);
        $pdf->setLeftMargin(16);
        $pdf->setTopMargin(53);
        $pdf->AddPage(
            ( $pagesize['width'] > $pagesize['height'] ) ? 'L' : 'P',
            [ $pagesize['width'], $pagesize['height'] ]
        );
        $pdf->useImportedPage($pageId);

        // NOME PROMOTER
        $pdf->SetFont('Futura-Book', '', 23);
        $pdf->Write(10, $user->name . "\n");

        // RUOLO
        $pdf->SetFontSize(17);
        $pdf->SetTextColor(0, 98, 106);
        $pdf->Write(8, $promoter->role. "\n");

        // NOME DEL TEAM
        $pdf->SetTextColor(128, 128, 128);
        $promoter->team ? $pdf->Write(8, $promoter->team . "\n") : '';
        $pdf->Write(4, " \n");

        switch ($addrcount) {
            case 3:
                // COMPAGNIA
                $pdf->SetFontSize(17);
                $pdf->SetTextColor(64, 64, 64);
                $pdf->Write(15, $promoter->company . "\n");
                $pdf->Write(2, " \n");
                // INDIRIZZO 1
                $pdf->SetFontSize(16);
                $pdf->Write(6, $row1 . "\n");
                $pdf->Write(6, $promoter->addr1 . "\n");
                $promoter->phone1 ? $pdf->Write(6, 'T +39 ' . $promoter->phone1 . "\n") : $pdf->Write(0, "\n");

                $pdf->Write(5, " \n");
                // INDIRIZZO 2 se presente, gestire con uno switch
                $pdf->Write(6, $row2 . "\n");
                $pdf->Write(6, $promoter->addr2 . "\n");
                $promoter->phone2 ? $pdf->Write(6, 'T +39 ' . $promoter->phone2 . "\n") : $pdf->Write(0, "\n");
                $pdf->Write(5, " \n");

                // INDIRIZZO 3 se presente
                $pdf->Write(6, $row3 . "\n");
                $pdf->Write(6, $promoter->addr3 . "\n");
                $promoter->phone3 ? $pdf->Write(6, 'T +39 ' . $promoter->phone3 . "\n") : $pdf->Write(0, "\n");

                // MOBILE
                $promoter->phone2 ? $pdf->Write(9, 'M +39 ' . $promoter->mobile . "\n") : $pdf->Write(15, 'M +39 ' . $promoter->mobile . "\n");

                // EMAIL
                $pdf->SetTextColor(0, 98, 106);
                $promoter->phone2 ? $pdf->Write(7, $user->email . "\n") : $pdf->Write(8, $user->email . "\n");

                //WEBSITE
                $promoter->phone2 ? $pdf->Write(4, (isset($promoter->website) ? $promoter->website . "\n" : "\n") ) : $pdf->Write(5, (isset($promoter->website) ? $promoter->website . "\n" : "\n") . "\n");
                break;

            case 2:
                // COMPAGNIA
                $pdf->SetFontSize(17);
                $pdf->SetTextColor(64, 64, 64);
                $pdf->Write(15, $promoter->company . "\n");
                // INDIRIZZO 1
                $pdf->SetFontSize(16);
                $pdf->Write(7, $row1 . "\n");
                $pdf->Write(7, $promoter->addr1 . "\n");
                $promoter->phone1 ? $pdf->Write(6, 'T +39 ' . $promoter->phone1 . "\n") : $pdf->Write(0, "\n");

                $pdf->Write(5, " \n");
                // INDIRIZZO 2 se presente, gestire con uno switch
                $pdf->Write(7, $row2 . "\n");
                $pdf->Write(7, $promoter->addr2 . "\n");
                $promoter->phone2 ? $pdf->Write(6, 'T +39 ' . $promoter->phone2 . "\n") : $pdf->Write(0, " \n");
                // MOBILE
                $pdf->Write(15, 'M +39 ' . $promoter->mobile . "\n");
                // EMAIL
                $pdf->SetTextColor(0, 98, 106);
                $pdf->Write(8, $user->email . "\n");
                // WEBSITE
                $promoter->website ? $pdf->Write(5, $promoter->website . "\n") : null;
                break;
            default:
                // caso in cui c'è solo un indirizzo
                // COMPAGNIA
                $pdf->SetFontSize(17);
                $pdf->SetTextColor(64, 64, 64);
                $pdf->Write(15, $promoter->company . "\n");
                // INDIRIZZO 1
                $pdf->SetFontSize(16);
                $pdf->Write(7, $row1 . "\n");
                $pdf->Write(7, $promoter->addr1 . "\n");
                $promoter->phone1 ? $pdf->Write(6, 'T +39 ' . $promoter->phone1 . "\n") : $pdf->Write(0, " \n");
                // MOBILE
                $pdf->Write(15, 'M +39 ' . $promoter->mobile . "\n");
                // EMAIL
                $pdf->SetTextColor(0, 98, 106);
                $pdf->Write(8, $user->email . "\n");
                // WEBSITE
                $promoter->website ? $pdf->Write(5, $promoter->website . "\n") : null;
                break;
        }

        $pdf->Output('D', $outputfile);


        /*        $pdf = new FPDF('P','pt', [$h,$w]);
                $pdf->SetCompression(false);
                $pdf->AddPage();
                $pdf->setRightMargin(0);
                $pdf->setTopMargin(0);
                $pdf->Image($azimutWM,28, 24, -300 );
        */

 //       $pdf->SetFont('Helvetica', '', 12);
   //     $pdf->Cell(40,120,'Hello World!');






/*
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $user->name . '.vcf"');
        header('Expires: 0');
        header("Cache-control: no-cache, must-revalidate");
        header("Cache-control: private");
        header('Cache-Control: max-age=0');
        header("Pragma:public");
*/
        //echo $vcard;
        exit();

    }
}
