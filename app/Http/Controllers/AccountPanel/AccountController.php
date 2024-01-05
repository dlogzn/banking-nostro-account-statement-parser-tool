<?php

namespace App\Http\Controllers\AccountPanel;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AccountController extends Controller
{
    public function logout(): Response
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('account/panel/login');
    }
}
