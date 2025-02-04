<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactGeneral extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'type',
        'message',
    ];

    //protected $with = ['person', 'company', 'details'];

    public function person()
    {
        return $this->hasOne(ContactPerson::class);
    }

    public function company()
    {
        return $this->hasOne(ContactCompany::class);
    }

    public function detail(){
        return $this->hasOne(ContactDetail::class);
    }
}
