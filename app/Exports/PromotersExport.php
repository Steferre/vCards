<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PromotersExport implements FromCollection, WithHeadings
{

    protected $promoters;

    public function headings(): array
    {
        return [
            'Codice', 'Azienda', 'Stato', 'Nominativo', 'Email', 'Cellulare', 'Area', 'Team', 'Ruolo',
            'Indirizzo', 'Città', 'Provincia', 'CAP', 'Telefono Fisso',
            'Indirizzo2', 'Città2', 'Provincia2', 'CAP2', 'Telefono Fisso2',
            'Indirizzo3', 'Città3', 'Provincia3', 'CAP3', 'Telefono Fisso3'
        ];
    }

    public function __construct($promoters)
    {
        $this->promoters = $promoters;
    }

    public function collection()
    {
        return $this->promoters;
    }

/*
    public function map($promoter): array
    {
        return [
            $promoter->name,
            $promoter->email,
            $promoter->email_2,
            $promoter->description
        ];
    }
*/
}
