<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DestinasiWisataVisitor extends Model
{
    use HasFactory;
    protected $fillable = ['destinasi_wisata_id', 'periode', 'visitor'];

    /**
     * Get the akomodasi that owns the AkomodasiVisitor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function destinasi_wisata(): BelongsTo
    {
        return $this->belongsTo(DestinasiWisata::class);
    }
}
