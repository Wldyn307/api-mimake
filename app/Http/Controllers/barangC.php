<?php

namespace App\Http\Controllers;
use App\Models\barangM;
use Illuminate\Http\Request;
use App\Http\Resources\barangR;
use Illuminate\Routing\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class barangC extends Controller
{
    public function index()
    {
        $barang = barangM::latest()->paginate(5);

        return new barangR (true, 'List Data barang', $barang);
    }

    public function store (Request $request){
        $validator = Validator::make($request->all(), [
            'nama_barang'    => 'required',
            'gambar_barang'  => 'required|image|mimes:jpeg,png,jpg,gif,svg,webm',
            'qty'            => 'required',
            'harga'          => 'required',
            'barcode'        => 'required',
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $gambar_barang = $request->file('gambar_barang');
        $gambar_barang->storeAs('public/barang', $gambar_barang->hashName());

        $barang = barangM::create([
            'nama_barang'          => $request->nama_barang,
            'gambar_barang'     => $gambar_barang->hashName(),
            'qty'                  => $request->qty,
            'harga'                => $request->harga,
            'barcode'              => $request->barcode,
        ]);

        return new barangR(true, 'Data Barang Berhasil Ditambahkan!', $barang);
    }

    public function show(barangM $barang){
        return new barangR(true, 'Data Barang Ditemukan!', $barang);
    }

    public function update(Request $request, barangM $barang){
        $validator = Validator::make($request->all(), [
            'qty'   => 'required',
            'harga'   => 'required',
            'barcode'   => 'required',
            
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
    }

    if ($request->hasFile('image')){
        $gambar_barang = $request->file('gambar_barang');
        $gambar_barang->storeAs('public/barang', $gambar_barang->hashName());

        storage::delete('public/barang/'.$barang->gambar_barang);

        $barang->update([
            'nama_barang'          => $request->nama_barang,
            'gambar_barang'        => $request->hashName(),
            'qty'                  => $request->qty,
            'harga'                => $request->harga,
            'barcode'              => $request->barcode,
    ]);

    }else{
        $barang->update([
            'nama_barang'          => $request->nama_barang,
            'qty'                  => $request->qty,
            'harga'                => $request->harga,
            'barcode'              => $request->barcode,
        ]);
    }

    return new barangR(true, 'Data Barang Berhasil Diubah!', $barang);
  }

  public function destroy(barangM $barang){
    storage::delete('public/barang/'.$barang->gambar_barang);

    $barang->delete();

    return new barangR(true, 'Data Barang Berhasil Di hapus!', null);
  }

}
