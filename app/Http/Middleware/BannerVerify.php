<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BannerVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();
        $kategori = $request->route()->parameter('kategori');

        if(in_array($kategori, ['akomodasi', 'destinasi_wisata', 'ekonomi_kreatif', 'event', 'berita', 'fasilitas_umum', 'bg-ekonomi', 'bg-wisata', 'bg-event'])) {
            return $next($request);
        } else {
            if(in_array($routeName, ['admin.master-data.banner.index','admin.master-data.banner.store'])) {
                return redirect()->back();
            }

            return response()->json(['status' => false, 'msg' => "kategori tidak tersedia"]);
        }
    }
}
