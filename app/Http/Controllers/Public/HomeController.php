<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display landing page with latest news and featured UMKM.
     */
    public function index(FirebaseService $firebase): View
    {
        $homeData = $firebase->getHomeData();

        return view('public.home', [
            'latestNews' => $homeData['latestNews'],
            'featuredUmkm' => $homeData['featuredUmkm'],
        ]);
    }
}
