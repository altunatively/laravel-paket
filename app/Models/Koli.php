<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koli extends Model
{
    use HasFactory;
    protected $hidden = ['awb_sicepat', 'harga_barang', 'koli_code'];
}
