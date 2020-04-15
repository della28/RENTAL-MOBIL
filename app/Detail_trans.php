<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_trans extends Model
{
  protected $table="detail_trans";
  protected $primaryKey="id";
  protected $fillable = [
    'id_trans',
    'id_mobil',
    'qty',
    'subtotal'
  ];
}
