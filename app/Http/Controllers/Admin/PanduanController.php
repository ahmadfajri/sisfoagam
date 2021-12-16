<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PanduanAplikasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PanduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $panduan = PanduanAplikasi::select('title', 'slug', 'id')->get();
        return view('admin.panduan_aplikasi.index', compact('panduan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.panduan_aplikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:panduan_aplikasi,title',
            'body' => 'required',
        ]);

        if($validator->fails()) {
            return back()->with("error", $validator->errors()->first());
        }

        PanduanAplikasi::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body
        ]);

        return redirect()->route('admin.galeri-parawisata.index')->with("success", "Panduan berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PanduanAplikasi  $panduan
     * @return \Illuminate\Http\Response
     */
    public function show($panduan_slug=null)
    {
        //
        // return $panduan;
        $panduan = ($panduan_slug != null) ? PanduanAplikasi::where('slug', $panduan_slug)->first() : null;
        $list_panduan = PanduanAplikasi::select('title', 'slug')->orderBy('title', 'asc')->get();
        return view('admin.panduan_aplikasi.detail', compact('panduan', 'list_panduan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PanduanAplikasi  $panduan
     * @return \Illuminate\Http\Response
     */
    public function edit(PanduanAplikasi $panduan)
    {
        //
        return view('admin.panduan_aplikasi.edit', compact('panduan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PanduanAplikasi  $panduan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PanduanAplikasi $panduan)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:panduan_aplikasi,title,'.$panduan->id,
            'body' => 'required',
        ]);

        if($validator->fails()) {
            return back()->with("error", $validator->errors()->first());
        }

        $panduan->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body
        ]);

        return redirect()->route('admin.galeri-parawisata.index')->with("success", "Panduan berhasil ditambahkan");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PanduanAplikasi  $panduan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PanduanAplikasi $panduan)
    {
        //
        $panduan->delete();
        return ['pesan' => 'berhasil'];
    }
}
