<?php

namespace App\Models;

use App\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promoter extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    protected $fillable = [
        'role',
        'description',
        'code',
        'team',
        'active',
        'userId',
        'file',
        'area',
        'company',
        'team',
        'foto',
        'firma',
        'cap1',
        'city1',
        'prov1',
        'addr1',
        'phone1',
        'cap2',
        'city2',
        'prov2',
        'addr2',
        'phone2',
        'cap3',
        'city3',
        'prov3',
        'addr3',
        'phone3',
        'mobile',
        'website',
        'extralogo'
    ];
}
