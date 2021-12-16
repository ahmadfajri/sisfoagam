<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AkomodasiVisitor extends Model
{
    use HasFactory;
    protected $fillable = ['periode', 'visitor', 'akomodasi_id'];

    /**
     * Get the akomodasi that owns the AkomodasiVisitor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function akomodasi(): BelongsTo
    {
        return $this->belongsTo(Akomodasi::class);
    }
}
