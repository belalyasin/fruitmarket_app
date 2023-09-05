<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'phone' => 'required|string|exists:users,phone',
            'password' => 'required|string|min:7',
        ]);
        if (!$validator->fails()) {
            $user = User::where('phone', '=', $request->input('phone'))->first();
            if (Hash::check($request->input('password'), $user->password)) {
                $token = $user->createToken('User-Api');
                $user->setAttribute('token', $token->plainTextToken);
                return response()->json(
                    [
                        'message' => 'logged in successfully',
                        'data' => new UserResources($user),
                        'token' => $token->plainTextToken
                    ],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(
                    ['message' => 'login failed, error password'],
                    Response::HTTP_BAD_REQUEST,
                );
            }
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|unique:users,phone|regex:/^\+97\d{10}$/',
            // 'phone' => 'required|string|min:9|unique:users,phone|regex:/^(\+?\d{1,3})?[-.\s]?(\d{3,4})[-.\s]?(\d{3})[-.\s]?(\d{4})$/',
        ], [
            'required' => 'The phone number felid is required',
            'min' => 'The phone number should be at least 9 digits long',
            'unique' => 'The phone number has already been taken',
            'regex' => 'The phone number does not match the required format',
        ]);
        if (!$validator->fails()) {
            $otp = rand(1000, 9999);
            $user = new User();
            $user->phone = $request->phone;
            $user->otp = Hash::make($otp);
            $isSaved = $user->save();
            if ($isSaved) {
                $token = $user->createToken('User-Api');
                $user->setAttribute('token', $token->plainTextToken);
                $this->sendWhatsappNotification($otp, $user->phone);
                return response()->json(
                    [
                        'message' => $isSaved ? 'we sent the verify code to your whatsApp number' : 'registered failed',
                        // 'code' => $otp,
                        'token' => $token->plainTextToken
                    ],
                    $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        // dd($request);
        $user = $request->user();

        if ($user) {
            $token = $user->currentAccessToken();
            if ($token) {
                $token->delete();
                return response()->json(['message' => 'Logged out successfully'], Response::HTTP_OK);
            }
        }

        return response()->json(['message' => 'Logout failed!'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return 'App\Models\User'
     */
    protected function create(array $data)
    {
        $otp = rand(1000, 9999);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'otp' => Hash::make($otp),
        ]);

        // $this->sendWhatsappNotification($otp, $user->phone);
        return $user;
    }

    private function sendWhatsappNotification(string $otp, string $recipient)
    {
        $twilio_whatsapp_number = getenv("TWILIO_WHATSAPP_NUMBER");
        $account_sid = getenv("TWILIO_ACCOUNT_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);
        $message = "Your registration pin code is $otp";
        return $client->messages->create("whatsapp:$recipient", array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }

    public function verifyOtp(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|exists:users,phone',
            'otp' => 'required|numeric|digits:4'
        ]);

        $user = User::where('phone', $request->phone)->first();
        // $user = User::where('phone', auth()->user()->phone)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (Hash::check($request->otp, $user->otp)) {
            // OTP is valid
            $user->otp = null;
            $user->email_verified_at = now();
            $user->phone_verified_at = now();
            // You can update the user's verification status or perform other necessary actions
            return response()->json(['message' => 'verification Code verified successfully'], 200);
        } else {
            return response()->json(['message' => 'Invalid verification Code'], 400);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            // 'phone' => 'required|string|regex:/^(\+?\d{1,3})?[-.\s]?(\d{3,4})[-.\s]?(\d{3})[-.\s]?(\d{4})$/',
            'email' => 'nullable|string|max:255|unique:users',
            'address' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()->mixedCase()->uncompromised()],
        ]);
        $user = auth()->user();
        $user = User::where('phone', $user->phone)->first();
        if (!$validator->fails()) {
            // $otp = rand(1000, 9999);
            // $user = new User();
            $user->name = $request->name;
            // $user->phone = $request->phone;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->password = Hash::make($request->password);
            // $user->otp = Hash::make($otp);
            $isSaved = $user->save();
            if ($isSaved) {
                // $token = $user->createToken('User-Api');
                // $user->setAttribute('token', $token->plainTextToken);
                return response()->json(
                    [
                        'message' => $isSaved ? 'Profile information saved successfully.' : 'Failed to save profile information.',
                        'data' => new UserResources($user),
                        // $this->sendWhatsappNotification($otp, $user->phone);
                        // 'code' => $otp
                    ],
                    $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getCurrentUser()
    {
        //
        $user = auth()->user();
        if ($user) {
            $userData = new UserResources($user);

            return response()->json([
                'user' => $userData,
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not authenticated',
            ], 401);
        }
    }
    public function updateProfile(Request $request)
    {
        //
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'nullable|string|max:255|unique:users,email,' . auth()->id(),
            'address' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpeg,png,jpg'
        ]);
        if (!$validator->fails()) {
            $user = auth()->user();
            $user = User::where('id', '=', $user->id)->first();
            // dd(11);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // $path = \Storage::disk('public')->putFile('public/image', $image);
                // $path = \Storage::disk()->putFile('public/image', $image);
                $path = $image->store('public/image');
                // $path = time() . '.' . $image->getClientOriginalName();
                // $image->move(public_path('images'), $path);
                $user->image = $path;
            }
            $isSaved = $user->save();
            return response()->json(
                [
                    'message' => $isSaved ? 'Update Profile Successfully' :
                        'Update Profile Failed!',
                    "data" => new UserResources($user),
                ],
                $isSaved ? Response::HTTP_CREATED :
                    Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(["message" => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }
}
