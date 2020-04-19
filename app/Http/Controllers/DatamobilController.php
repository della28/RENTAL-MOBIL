<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataMobil;
use DB;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class DatamobilController extends Controller
{
    public function store(Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'id_jenis'=>'required',
          'nama_mobil'=>'required',
          'merk'=>'required',
          'plat_nomor'=>'required',
          'keterangan'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=DataMobil::create([
        'id_jenis'=>$request->id_jenis,
        'nama_mobil'=>$request->nama_mobil,
        'merk'=>$request->merk,
        'plat_nomor'=>$request->plat_nomor,
        'keterangan'=>$request->keterangan
      ]);
      $status=1;
      $message="Data Mobil Berhasil Ditambahkan";
      if($simpan){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function update($id,Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'id_jenis'=>'required',
          'nama_mobil'=>'required',
          'merk'=>'required',
          'plat_nomor'=>'required',
          'keterangan'=>'required'
        ]
    );

      if($validator->fails()){
      return Response()->json($validator->errors());
    }

      $ubah=DataMobil::where('id',$id)->update([
        'id_jenis'=>$request->id_jenis,
        'nama_mobil'=>$request->nama_mobil,
        'merk'=>$request->merk,
        'plat_nomor'=>$request->plat_nomor,
        'keterangan'=>$request->keterangan
      ]);
      $status=1;
      $message="Data Mobil Berhasil Diubah";
      if($ubah){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function tampil_mobil(){
      if(Auth::user()->level=="admin"){
        $data=DB::table('data_mobil')
        ->join('jenis_mobil','jenis_mobil.id','=','data_mobil.id_jenis')
        ->select('nama_mobil','jenis_mobil','merk','plat_nomor','harga_sewa','keterangan')
        ->get();
        $count=$data->count();
        $status=1;
        $message="Data Mobil Berhasil ditampilkan";
        return response()->json(compact('data','status','message','count'));
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function destroy($id){
      if(Auth::user()->level=="admin"){
      $hapus=DataMobil::where('id',$id)->delete();
      $status=1;
      $message="Data Mobil Berhasil Dihapus";
      if($hapus){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }
}
