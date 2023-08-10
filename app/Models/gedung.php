<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gedung extends Model
{
    use HasFactory;
    protected $table = 'gedung';
    protected $fillable = [
        'nama', 
        'lokasi',
        'kapasitas',
        'fasilitas_id',
        'deskripsi',
        'harga',
        'foto',
        'ketersediaan'
    ];

    //menambahkan relasi dengan entitas pemesanan
    public function booking()
    {
        return $this->hasMany(booking::class, 'gedung_id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(fasilitas::class, 'gedung_fasilitas', 'gedung_id', 'fasilitas_id');
    }
}
