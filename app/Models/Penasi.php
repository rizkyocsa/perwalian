<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'deskripsi',
        'kategori',
        'berkasPendukung',
        'tanggapan',
        'status',
        'pengirim',
    ];
}
