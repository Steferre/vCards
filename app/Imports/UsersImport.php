<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Promoter;

Use Exception;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class UsersImport implements ToCollection
{
    private $rownumber = 0;
    private $hasErrors = false;
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {

            $this->rownumber++;
            if ($this->rownumber===1) continue;

            try {
                echo 'parsing row: ' . $this->rownumber . ' => ' . $row[0] . ' => ';

                $user = new User();
                $user->email = $row[14];
                $user->name = $row[3] . ' ' . $row[4];
                $user->password = sha1($user->email.'r@43ca_ll4');
                $user->saveOrFail();

                echo $user->id;
                echo PHP_EOL;

                $promoter = new Promoter();

                $promoter->firstname = $row[3];
                $promoter->lastname = $row[4];

                $promoter->role = $row[5];
                //if ($promoter->role==='Wm') $promoter->role = 'Wealth Agent';
                $promoter->team = $row[6];

                $promoter->code = $row[1];
                $promoter->active = 1;
                $promoter->userId = $user->id;
                $promoter->area = $row[0];
                $promoter->company = $row[2];
                    //if ($promoter->company==='Wm') $promoter->company = 'Azimut Wealth Management';

                //$promoter->foto = $row[15];
                //$promoter->firma = $row[16];
                $promoter->mobile= $row[13];

                $promoter->cap1 = $row[7];
                $promoter->city1 = $row[8];
                $promoter->prov1 = $row[9];
                $promoter->addr1 = $row[10];
                if ($row[11])
                    if ($promoter->addr1)
                        $promoter->addr1 .= ', ' . $row[11];

                $promoter->phone1 = $row[12];

                /* try {

                    $lastmod = $row[18];
                    if ($lastmod) {
                        $lastmod .= ' 00:00:00';
                        $format = "d/m/Y H:i:s";
                        $dateobj = \DateTime::createFromFormat($format, $lastmod);
                        $promoter->created_at = $dateobj->format('Y-m-d');
                        $promoter->updated_at = $dateobj->format('Y-m-d');
                    }

                } catch (Exception $te) {
                    //do nothing

                } */

                $promoter->cap2 = $row[16];
                $promoter->city2 = $row[17];
                $promoter->prov2 = $row[18];
                $promoter->addr2 = $row[19];
                if ($row[20])
                    if ($promoter->addr2)
                        $promoter->addr2 .= ', ' . $row[20];
                $promoter->phone2 = $row[21];

                $promoter->cap3 = $row[22];
                $promoter->city3 = $row[23];
                $promoter->prov3 = $row[24];
                $promoter->addr3 = $row[25];
                if ($row[26])
                    if ($promoter->addr3)
                        $promoter->addr3 .= ', ' . $row[26];
                $promoter->phone3 = $row[27];

                if (!$row[28]) {
                    $promoter->extralogo = 'none';
                } else {
                    $promoter->extralogo = 'efpa';
                }


                if ($row[29])
                    $promoter->website = $row[29];


                $promoter->saveOrFail();

            } catch (Exception $e) {
                echo PHP_EOL;
                echo $e->getMessage();
                $this->hasErrors = true;
                break;
            }

        }
    }

    public function import($filename) {
        $error = null;
        try {
             Excel::import($this, $filename);
            if ($this->hasErrors)
                throw new Exception('Si sono verificati degli errori');

        } catch (\Exception $e) {
            $error = $e;
        } finally {
            return $error;
        }
    }

}
