<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataMobil extends Model
{
  protected $table="data_mobil";
  protected $primaryKey="id";
  protected $fillable = [
    'id_jenis',
    'nama_mobil',
    'merk',
    'plat_nomor',
    'keterangan'
  ];
}
