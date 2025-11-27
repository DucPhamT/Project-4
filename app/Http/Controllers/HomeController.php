<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $token = session('api-token');
        return Inertia::render('HomePage', [
            'token' => $token,
            'user' => $user,
        ]);
    }

    

    


}
