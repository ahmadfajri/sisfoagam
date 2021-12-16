<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DestinasiWisataVisitor;
use Illuminate\Support\Facades\Validator;

class DestinasiWisataVisitorController extends Controller
{
    //
    public function index($destinasi_wisata_id)
    {
        $visitors = DestinasiWisataVisitor::where('destinasi_wisata_id', $destinasi_wisata_id)->orderBy("periode", 'desc')->get();
        return view('admin.destinasi_wisata.visitor.index', compact('visitors', 'destinasi_wisata_id'));
    }

    public function edit($destinasi_wisata_id, DestinasiWisataVisitor $visitor)
    {
        $bulan = date("m", strtotime($visitor->periode));
        $tahun = date("Y", strtotime($visitor->periode));
        return view('admin.destinasi_wisata.visitor.form', compact('visitor', 'tahun', 'bulan'));
    }

    public function update($destinasi_wisata_id, DestinasiWisataVisitor $visitor, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'periode' => 'required|date_format:Y-m',
            'jumlah' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        $visitor->update([
            'periode' => $request->periode."-01",
            'visitor' => $request->jumlah
        ]);

        return ['status' => true, 'msg' => "Data pengunjung telah diperbaharui"];
    }


    public function create($destinasi_wisata_id)
    {
        $bulan = date("m");
        $tahun = date("Y");
        return view('admin.destinasi_wisata.visitor.form', compact('tahun', 'bulan', 'destinasi_wisata_id'));
    }
    public function store($destinasi_wisata_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'periode' => 'required|date_format:Y-m',
            'jumlah' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        DestinasiWisataVisitor::updateOrCreate([
            'destinasi_wisata_id' => $destinasi_wisata_id,
            'periode' => $request->periode."-01",
        ], [
            'visitor' => $request->jumlah
        ]);

        return ['status' => true, 'msg' => "Data pengunjung telah ditambahkan"];
    }

    public function destroy($destinasi_wisata_id, DestinasiWisataVisitor $visitor)
    {
        $visitor->delete();
        return ['pesan' => 'berhasil'];
    }
}
