<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginView(Request $request)
    {
        //
        session()->put('guard', 'admin');
        $validator = Validator(['guard' => 'admin'], [
            'guard' => 'required|string|in:admin'
        ]);
        if (!$validator->fails()) {
            return response()->view('cms.auth.login');
        } else {
            abort(Response::HTTP_NOT_FOUND, 'The page you have requested is not found');
        }
    }
    public function login(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "email" => "required|email|exists:admins,email",
            "password" => "required|string|min:7",
        ]);
        $guard = session()->get('guard');
        // dd($request->input('password'),Hash::make($request->input('password')));
        if (!$validator->fails()) {
            $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
            if (Auth::guard($guard)->attempt($credentials)) {
                return response()->json(['message' => 'Login success'], Response::HTTP_OK);
            } else {
                return response()->json(
                    ['message' => 'Login failed, check login credentials'],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function logout(Request $request)
    {
        $guard = session('guard');
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        return redirect()->route('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
