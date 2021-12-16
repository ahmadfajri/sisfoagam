<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EventParawisata;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventParawisataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $events = EventParawisata::all();
        return view('admin.event_parawisata.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("admin.event_parawisata.create");
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
            'jenis_event' => 'required|string',
            'start_at' => 'required|date_format:Y-m-d',
            'end_at' => 'required|date_format:Y-m-d',
            'keterangan' => 'required|string',
            'foto' => 'required|image',
        ]);

        if($validator->fails()) {
            return back()->with("error", $validator->errors()->first());
        }


        if($request->has("foto")) {
            $file_upload = $request->file("foto");
            $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/event_parawisata", $file_name);
        }

        EventParawisata::create([
            'jenis_event' => $request->jenis_event,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'keterangan' => $request->keterangan,
            'foto' => storage_url(substr($file_location, 7)),
            'slug_event_parawisata' => rand(10000,99999).'-'.Str::slug($request->jenis_event)
        ]);

        return redirect()->route('admin.event-parawisata.index')->with("success", "Event Parawisata berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventParawisata  $event_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function show(EventParawisata $event_parawisatum)
    {
        //
        return $event_parawisatum;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventParawisata  $event_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function edit(EventParawisata $event_parawisatum)
    {
        //
        return view('admin.event_parawisata.edit', compact('event_parawisatum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventParawisata  $event_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventParawisata $event_parawisatum)
    {
        //
        $validator = Validator::make($request->all(), [
            'jenis_event' => 'required|string',
            'start_at' => 'required|date_format:Y-m-d',
            'end_at' => 'required|date_format:Y-m-d',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image',
        ]);

        if($validator->fails()) {
            return back()->with("error", $validator->errors()->first());
        }

        $update = [
            'jenis_event' => $request->jenis_event,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'keterangan' => $request->keterangan,
            'slug_event_parawisata' => rand(10000,99999).'-'.Str::slug($request->jenis_event)
        ];

        if($request->hasFile("foto")) {
            $file_upload = $request->file("foto");
            $file_name = rand(100,333)."-".time().".".$file_upload->getClientOriginalExtension();
            $file_location = $file_upload->storeAs("public/event_parawisata", $file_name);

            list($protocol, $blank, $domain, $path, $dir, $file) = explode("/", $event_parawisatum->foto);
            Storage::disk('public')->delete(implode('/', [$dir, $file]));

            $update['foto'] = storage_url(substr($file_location, 7));
        }

        $event_parawisatum->update($update);

        return redirect()->route('admin.event-parawisata.index')->with("success", "Event Parawisata berhasil diperbaharui");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventParawisata  $event_parawisatum
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventParawisata $event_parawisatum)
    {
        //
        $event_parawisatum->delete();
        return ['pesan' => 'berhasil'];
    }
}
