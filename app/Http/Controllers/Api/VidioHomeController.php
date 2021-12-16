<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VidioHomeController extends Controller
{
    //
    public function toClient()
    {
        return (file_exists(public_path("vidio.txt")))? ['status' => true, 'url' => file_get_contents(public_path("vidio.txt"))] : ['status' => false, 'url' => "Vidio tidak tersedia"];
    }

    public function index()
    {
        $url = (file_exists(public_path("vidio.txt")))? file_get_contents(public_path("vidio.txt")) : '';
        return view('admin.master_data.vidio_banner.index', compact('url'));
    }

    public function change(Request $request)
    {
        if($request->has('url')) {
            $url = $request->url;
            $code = "";
            if(preg_match('/youtu.be/i', $url)) {
                $explode = explode('/', $url);
            } else {
                $explode =  explode('v=', $url);
            }

            $code = end($explode);

            file_put_contents(public_path('vidio.txt'), "https://www.youtube.com/embed/".$code);
        }
        return back()->with('success', "Berhasil diubah");
    }
}
