<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'people';

    protected $fillable = [
        'name',
        'email',
        'avatar', // base64 string ou null
    ];

    /**
     * Relacionamento 1:N -> Person hasMany Contact
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'person_id');
    }
}
