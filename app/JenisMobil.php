<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisMobil extends Model
{
  protected $table="jenis_mobil";
  protected $primaryKey="id";
  protected $fillable = [
    'jenis_mobil',
    'harga_sewa'
  ];
}
