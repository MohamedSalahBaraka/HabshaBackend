<?php

namespace App\Http\Controllers;

use App\Models\Delivary;
use App\Models\Dish;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $pages = Page::all();
        $logo = Setting::where('key', 'logo')->first();
        $sitename = Setting::where('key', 'sitename')->first();
        return view('home', ['pages' => $pages, 'logo' => $logo, 'sitename' => $sitename]);
    }
    public function page($page)
    {
        $page = Page::where('title', $page)->first();
        abort_if(is_null($page), 404);
        $pages = Page::all();
        $logo = Setting::where('key', 'logo')->first();
        $sitename = Setting::where('key', 'sitename')->first();
        return view('page', ['page' => $page, 'pages' => $pages, 'logo' => $logo, 'sitename' => $sitename]);
    }
}
