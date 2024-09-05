<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanItem extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_item';
    protected $guarded = ['id_pengajuan_item'];
    protected $primaryKey = 'id_pengajuan_item';

    public function getIdAttribute()
    {
        return $this->attributes['id_pengajuan_item'];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(DataItem::class, 'data_item_id', 'id_data_item');
    }
}
