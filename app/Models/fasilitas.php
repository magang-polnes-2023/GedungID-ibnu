<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fasilitas extends Model
{
    use HasFactory;
    protected $table = 'fasilitas';
    protected $fillable = [
        'foto',
        'fasilitas',
        'unit',
        'harga',
    ];

    public function gedung()
    {
        return $this->belongsToMany(gedung::class, 'gedung_fasilitas', 'fasilitas_id', 'gedung_id',);
    }

    public function bookings()
    {
        return $this->belongsToMany(booking::class, 'fasilitas_bookings', 'fasilitas_id', 'bookings_id',);
    }

}