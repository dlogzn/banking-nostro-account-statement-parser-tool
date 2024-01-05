<?php

namespace App\Http\Controllers\FrontPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontPanel\LoginRequest;




use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;


class LoginController extends Controller
{
    public function loadAccountLogin(): View
    {
        $title = 'Account Log in';
        $activeNav = 'Account Log in';
        return view('FrontPanel.account_login', compact('title', 'activeNav'));
    }

    public function authenticateAccountLogin(LoginRequest $request): JsonResponse
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'Active'], (int)$request->remember_me)) {
                $request->session()->regenerate();
                return response()->json(['message' => 'Authorized access', 'payload' => null], Response::HTTP_OK);
            }
            return response()->json(['message' => 'Unauthorized access!', 'payload' => null], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
