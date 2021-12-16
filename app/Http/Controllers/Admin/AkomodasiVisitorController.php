<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkomodasiVisitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AkomodasiVisitorController extends Controller
{
    //
    public function index($akomodasi_id)
    {
        $visitors = AkomodasiVisitor::where('akomodasi_id', $akomodasi_id)->orderBy("periode", 'desc')->get();
        return view('admin.akomodasi.visitor.index', compact('visitors', 'akomodasi_id'));
    }

    public function edit($akomodasi_id, AkomodasiVisitor $visitor)
    {
        $bulan = date("m", strtotime($visitor->periode));
        $tahun = date("Y", strtotime($visitor->periode));
        return view('admin.akomodasi.visitor.form', compact('visitor', 'tahun', 'bulan'));
    }

    public function update($akomodasi_id, AkomodasiVisitor $visitor, Request $request)
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


    public function create($akomodasi_id)
    {
        $bulan = date("m");
        $tahun = date("Y");
        return view('admin.akomodasi.visitor.form', compact('tahun', 'bulan', 'akomodasi_id'));
    }
    public function store($akomodasi_id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'periode' => 'required|date_format:Y-m',
            'jumlah' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return ['status' => false, 'msg' => $validator->errors()->first()];
        }

        AkomodasiVisitor::updateOrCreate([
            'akomodasi_id' => $akomodasi_id,
            'periode' => $request->periode."-01",
        ], [
            'visitor' => $request->jumlah
        ]);

        return ['status' => true, 'msg' => "Data pengunjung telah ditambahkan"];
    }

    public function destroy($destinasi_wisata_id, AkomodasiVisitor $visitor)
    {
        $visitor->delete();
        return ['pesan' => 'berhasil'];
    }
}
