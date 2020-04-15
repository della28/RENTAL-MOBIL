<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
  protected $table="transaksi";
  protected $primaryKey="id";
  protected $fillable = [
    'id_penyewa',
    'id_petugas',
    'tgl_trans',
    'tgl_sewa',
    'tgl_kembali',
    'deadline'
  ];
}
