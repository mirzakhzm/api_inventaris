<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Cek username secara manual (jika tidak pakai validator)
        // if (User::where('username', $data['username'])->exists()) {
        //     throw new HttpResponseException(
        //         response(
        //             [
        //                 'errors' => [
        //                     'username' => ['Username already registered'],
        //                 ],
        //             ],
        //             400,
        //         ),
        //     );
        // }

        // if (User::where('email', $data['email'])->exists()) {
        //     throw new HttpResponseException(
        //         response(
        //             [
        //                 'errors' => [
        //                     'email' => ['Email already registered'],
        //                 ],
        //             ],
        //             400,
        //         ),
        //     );
        // }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(
                response(
                    [
                        'errors' => [
                            'message' => ['Username or password is incorrect'],
                        ],
                    ],
                    401,
                ),
            );
        }
        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'Logout successful',
            ],
            200,
        );
    }

    public function getUsers(Request $request): UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }
    public function getUserById(Request $request, $id): UserResource
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
    public function updateUser(UserUpdateRequest $request): UserResource
    {
        /** @var User $user */
        $user = Auth::user();
        $data = $request->validated();
        $user->update($data);
        return new UserResource($user);
    }
    public function deleteUser(int $id): JsonResponse
    {
        $user = Auth::user();
        $user = User::where('id', $id)->first();

        if (!$user) {
            throw new HttpResponseException(
                response()
                    ->json([
                        'errors' => [
                            'message' => 'User not found',
                        ],
                    ])
                    ->setStatusCode(404),
            );
        }
        $user->delete();
        return response()->json(
            [
                'success' => true,
                'message' => 'User deleted successfully',
            ],
            200,
        );
    }
}
