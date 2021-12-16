<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanduanAplikasi extends Model
{
    use HasFactory;
    protected $table = "panduan_aplikasi";
    protected $fillable = ['title', 'body', 'slug'];
}
