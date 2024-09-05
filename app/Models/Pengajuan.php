<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengajuan extends Model
{
    use HasFactory;
    protected $table = 'pengajuan';
    protected $guarded = ['id_pengajuan'];
    protected $primaryKey = 'id_pengajuan';

    public function getIdAttribute()
    {
        return $this->attributes['id_pengajuan'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_users');
    }

    public function itemPengajuan(): HasMany
    {
        return $this->hasMany(PengajuanItem::class, 'pengajuan_id', 'id_pengajuan');
    }
}
