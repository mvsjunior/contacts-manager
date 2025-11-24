<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = [
        'person_id',
        'country_code',
        'number',
    ];

    /**
     * Relacionamento -> Contact belongsTo Person
     */
    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}
