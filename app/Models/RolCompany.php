<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolCompany extends Model
{
    use HasFactory;

    protected $table = 'rol_company';
    protected $fillable = [
        'title',
        'min_salary',
        'max_salary',
        'currency',
        'status'
    ];
}