<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $table = 'employes';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'birthdate',
        'adresse',
        'telephone',
        'family_situation',
        'number_of_children',
    ];
    
    protected $connection = 'mysql'; 
}