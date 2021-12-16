<?php

namespace App\Http\Controllers\Admin\MasterData\FotoSlider;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FotoSliderController extends Controller
{
    //
    public function index()
    {
        $data['slider'] = DB::table('sliders')->get();
        return view("admin.master_data.foto_slider.index", $data);
    }

    public function destroy($id)
    {
        DB::table('sliders')->where('id',$id)->delete();

        return redirect()
            ->route('admin.foto-slider.index');
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_slider' => 'required|image',
            'deskripsi' => 'required|string',
        ]);

        if($validator->fails()) {
            return back()->with("error", $validator->errors()->first());
        }
        $foto = Slider::find($id);

        list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $foto->file);
        if(Storage::disk("public")->exists(implode('/', [$dir, $file]))) {
            Storage::disk('public')->delete(implode('/', [$dir, $file]));
        }

        $file_upload = $request->file("foto_slider");
        $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
        $file_location = $file_upload->storeAs("public/foto_slider", $file_name);

        $foto->update([
            'file' => storage_url(substr($file_location, 7)),
            'description' => $request->deskripsi,
        ]);

        return redirect()->route('admin.foto-slider.index')->with("success", "Slide berhasil diubah");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_slider' => 'required|image',
            'deskripsi' => 'required|string',
        ]);

        if($validator->fails()) {
            return back()->with("error", $validator->errors()->first());
        }

        $file_upload = $request->file("foto_slider");
        $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
        $file_location = $file_upload->storeAs("public/foto_slider", $file_name);

        Slider::create([
            'file' => storage_url(substr($file_location, 7)),
            'description' => $request->deskripsi,
        ]);

        return redirect()->route('admin.foto-slider.index')->with("success", "Slide berhasil diubah");
    }
}
