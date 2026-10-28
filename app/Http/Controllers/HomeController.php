<?php

namespace App\Http\Controllers;

use App\Support\HomeContent;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class HomeController extends Controller
{
    /**
     * Display the landing page with the currently published content.
     */
    public function __invoke(): InertiaResponse
    {
        return Inertia::render('Home', [
            'content' => HomeContent::get(),
        ]);
    }
}
