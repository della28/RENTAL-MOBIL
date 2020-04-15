<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penyewa;
use JWTAuth;
use Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class PenyewaController extends Controller
{
    public function store(Request $request){
      if(Auth::user()->level=="admin"){
      $validator=Validator::make($request->all(),
        [
          'nama_penyewa'=>'required',
          'alamat'=>'required',
          'telp'=>'required',
          'no_ktp'=>'required',
          'foto'=>'required'
        ]
      );

      if($validator->fails()){
        return Response()->json($validator->errors());
      }

      $simpan=Penyewa::create([
        'nama_penyewa'=>$request->nama_penyewa,
        'alamat'=>$request->alamat,
        'telp'=>$request->telp,
        'no_ktp'=>$request->no_ktp,
        'foto'=>$request->foto
      ]);
      $status=1;
      $message="Penyewa Berhasil Ditambahkan";
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
          'nama_penyewa'=>'required',
          'alamat'=>'required',
          'telp'=>'required',
          'no_ktp'=>'required',
          'foto'=>'required'
        ]
    );

      if($validator->fails()){
      return Response()->json($validator->errors());
    }

      $ubah=Penyewa::where('id',$id)->update([
        'nama_penyewa'=>$request->nama_penyewa,
        'alamat'=>$request->alamat,
        'telp'=>$request->telp,
        'no_ktp'=>$request->no_ktp,
        'foto'=>$request->foto
      ]);
      $status=1;
      $message="Penyewa Berhasil Diubah";
      if($ubah){
        return Response()->json(compact('status','message'));
      }else {
        return Response()->json(['status'=>0]);
      }
    } else{
      return response()->json(['status'=>'anda bukan admin']);
    }
  }

    public function tampil_penyewa(){
      if(Auth::user()->level=="admin"){
      $data_penyewa=Penyewa::get();
      $count=$data_penyewa->count();
      $arr_data=array();
      foreach ($data_penyewa as $dt_pw){
        $arr_data[]=array(
          'id' => $dt_pw->id,
          'nama_penyewa' => $dt_pw->nama_penyewa,
          'alamat' => $dt_pw->alamat,
          'telp' => $dt_pw->telp,
          'no_ktp' => $dt_pw->no_ktp,
          'foto' => $dt_pw->foto
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
      $hapus=Penyewa::where('id',$id)->delete();
      $status=1;
      $message="Penyewa Berhasil Dihapus";
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
