<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisMobil;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class JenisController extends Controller
{
    public function store(Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'jenis_mobil'=>'required',
          'harga_sewa'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=JenisMobil::create([
        'jenis_mobil'=>$request->jenis_mobil,
        'harga_sewa'=>$request->harga_sewa
      ]);
      $status=1;
      $message="Jenis Mobil Berhasil Ditambahkan";
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
          'jenis_mobil'=>'required',
          'harga_sewa'=>'required'
        ]
    );

      if($validator->fails()){
      return Response()->json($validator->errors());
    }

      $ubah=JenisMobil::where('id',$id)->update([
        'jenis_mobil'=>$request->jenis_mobil,
        'harga_sewa'=>$request->harga_sewa
      ]);
      $status=1;
      $message="Jenis Mobil Berhasil Diubah";
      if($ubah){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function tampil_jenis(){
      if(Auth::user()->level=="admin"){
      $data_jenis=JenisMobil::get();
      $count=$data_jenis->count();
      $arr_data=array();
      foreach ($data_jenis as $dt_jn){
        $arr_data[]=array(
          'id' => $dt_jn->id,
          'jenis_mobil' => $dt_jn->jenis_mobil,
          'harga_sewa' => $dt_jn->harga_sewa
        );
      }
      $status=1;
      return Response()->json(compact('status','count','arr_data'));
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function destroy($id){
      if(Auth::user()->level=="admin"){
      $hapus=JenisMobil::where('id',$id)->delete();
      $status=1;
      $message="Jenis Mobil Berhasil Dihapus";
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
