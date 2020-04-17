<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Detail_trans;
use App\DataMobil;
use DB;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class TransaksiController extends Controller
{
    public function report($tgl_awal, $tgl_akhir){
      if(Auth::user()->level=="petugas"){
        $transaksi=DB::table('transaksi')
        ->join('penyewa', 'penyewa.id', '=', 'transaksi.id_penyewa')
        ->where('transaksi.tgl_trans', '>=', $tgl_awal)
        ->where('transaksi.tgl_trans', '<=', $tgl_akhir)
        ->select('transaksi.id','tgl_trans', 'nama_penyewa', 'penyewa.alamat', 'penyewa.telp', 'tgl_sewa','tgl_kembali')
        ->get();

        $datatrans=array(); $no=0;
        foreach ($transaksi as $tr) {
          $datatrans[$no]['id transaksi'] = $tr->id;
          $datatrans[$no]['tgl_trans'] = $tr->tgl_trans;
          $datatrans[$no]['nama penyewa'] = $tr->nama_penyewa;
          $datatrans[$no]['alamat'] = $tr->alamat;
          $datatrans[$no]['telepon'] = $tr->telp;
          $datatrans[$no]['tgl_sewa'] = $tr->tgl_sewa;
          $datatrans[$no]['tgl_kembali'] = $tr->tgl_kembali;

          $grand=DB::table('detail_trans')->groupBy('id_trans')
          ->select(DB::raw('sum(subtotal) as grand_total'))->first();

          $datatrans[$no]['grand_total'] = $grand->grand_total;
          $detail=DB::table('detail_trans')
          ->join('data_mobil','data_mobil.id', '=', 'detail_trans.id_mobil')
          ->join('jenis_mobil','jenis_mobil.id', '=', 'data_mobil.id_jenis')
          ->where('id_trans', $tr->id)
          ->select('jenis_mobil.jenis_mobil','data_mobil.nama_mobil', 'jenis_mobil.harga_sewa', 'detail_trans.qty', 'detail_trans.subtotal')
          ->get();

          $datatrans[$no]['detail'] = $detail;
          $no++;
          }
        return response()->json(compact("datatrans"));
      } else{
        return response()->json(['status'=>'anda bukan petugas']);
      }
        }



    public function store(Request $request){
      if(Auth::user()->level=="petugas"){
      $validator=Validator::make($request->all(),
        [
          'id_penyewa'=>'required',
          'id_petugas'=>'required',
          'tgl_trans'=>'required',
          'tgl_sewa'=>'required',
          'tgl_kembali'=>'required',
          'deadline'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Transaksi::create([
        'id_penyewa'=>$request->id_penyewa,
        'id_petugas'=>$request->id_petugas,
        'tgl_trans'=>$request->tgl_trans,
        'tgl_sewa'=>$request->tgl_sewa,
        'tgl_kembali'=>$request->tgl_kembali,
        'deadline'=>$request->deadline
      ]);
      $status=1;
      $message="Transaksi Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan petugas']);
    }
  }











  // detail transaksi
    public function simpan(Request $request){
      if(Auth::user()->level=="petugas"){

      $validator=Validator::make($request->all(),
        [
          'id_trans'=>'required',
          'id_mobil'=>'required',
          'qty'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }
      $harga=DB::table('jenis_mobil')->first();
      $subtotal = $harga->harga_sewa * $request->qty;
      $simpan=Detail_trans::create([
        'id_trans'=>$request->id_trans,
        'id_mobil'=>$request->id_mobil,
        'subtotal'=>$subtotal,
        'qty'=>$request->qty
      ]);
      $status=1;
      $message="Detail Transaksi Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan petugas']);
    }
  }





}
