<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'number' => ['nullable', 'string', 'max:255', 'unique:'.User::class],
            'bio' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'exists:countries,id'],
            'city' => ['required', 'exists:cities,id'],
            'favourite_country' => ['nullable', 'exists:countries,id'],
            'favourite_color' => ['nullable', 'string', 'max:255'],
            'favourite_food' => ['nullable', 'string', 'max:255'],
            'want_to_visit' => ['nullable', 'string', 'max:255'],
            'media' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp', 'max:10240'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'number' => $request->number,
            'country_id' => $request->country,
            'bio' => $request->bio,
            'city_id' => $request->city,
            'favourite_country' => $request->favourite_country,
            'favourite_color' => $request->favourite_color,
            'favourite_food' => $request->favourite_food,
            'want_to_visit' => $request->want_to_visit,
        ]);

        if ($request->hasFile('media')) {
            (new MediaService())->store($user, $request->file('media'));
        }

        event(new Registered($user));

        $token = $user->createToken('access_token')->accessToken;

        return response()->json([
            'user' => UserResource::make($user->load(['media', 'country', 'city'])),
            'token' => $token,
        ]);
    }
}
