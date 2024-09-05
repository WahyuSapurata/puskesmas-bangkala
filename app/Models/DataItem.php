<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataItem extends Model
{
    use HasFactory;
    protected $table = 'data_item';
    protected $guarded = ['id_data_item'];
    protected $primaryKey = 'id_data_item';

    public function getIdAttribute()
    {
        return $this->attributes['id_data_item'];
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'id_jenis');
    }
}
