<?php

namespace App\Http\Controllers\web\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Nutrition;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $products, $categories, $subCategories, $nutritions, $users;

    /**
     * Display a Login View.
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
    public function welcom()
    {
        //
        $this->categories = count(Category::where('parent_id', '=', null)->get('title'));
        $this->subCategories = count(Category::where('parent_id', '!=', null)->get('title'));
        $this->products = count(Product::get('name'));
        $this->nutritions = count(Nutrition::get('name'));

        return response()->view('cms.dashboard', [
            'categories' => $this->categories,
            'subCategories' => $this->subCategories,
            'products' => $this->products,
            'nutritions' => $this->nutritions,
        ]);

    }

    public function show_profile()
    {
        //


        return response()->view('cms.auth.admin.admin_profile');

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
    public function edit_profile(Admin $admin)
    {
        //
        return response()->view('cms.auth.admin.edit', ['admin' => $admin]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
//        dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            "profile_image" => 'nullable|file|mimes:jpeg,png,jpg',
        ]);
        if (!$validator->fails()) {
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                // Save the image path to the admin
                $path = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('images'), $path);
                $admin->profile_image = $path;
            }
            $isSaved = $admin->save();
             response()->json(
                ['message' => $isSaved ? 'Updated successfully' : 'Update failed'],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
            );
            return redirect()->route('admin.admin_profile');
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
