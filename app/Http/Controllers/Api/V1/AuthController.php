<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Enums\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Http\Resources\userResource;


class AuthController extends Controller
{
    use ApiResponse;

    public function setupAdmin(Request $request): JsonResponse
    {
        if(User::exists()) {
            return $this->error('Configuração inicial já concluída. Este endpoint não está mais disponível.', 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'ddd' => ['required', 'string', 'max:4'],
            'phone' => ['required', 'digits:9'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string'],
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'lastname' => $validated['lastname'],
            'birth_date' => $validated['birth_date'],
            'role' => Role::Admin->value,
            'ddd' => $validated['ddd'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $admin->createToken('api-token', ['*'], now()->addHours(8))->plainTextToken;

        return $this->created([
            'user' => $admin,
            'token' => $token,
            'expires_at' => now()->addHours(8)->toDateTimeString(),
        ], 'Conta de administrador criada com sucesso.');
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        
        $user = User::where('email', $validated['email'])->first();
        

        if (! $user || !Hash::check($validated['password'], $user->password)) {
            return $this->error('Credenciais inválidas.', 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token', ['*'], now()->addHours(8))->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token,
            'expires_at' => now()->addHours(8)->toDateTimeString(),
        ], 'Login efectuado com sucesso.');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(message: 'Sessão terminada com sucesso.');
    }

    public function me(Request $request): JsonResponse
    {
        return $this->success(
            new userResource($request->user())
        );
    }

    // public function updateMe(Request $request): JsonResponse
    // {
    //     $user = $request->user();
    //     $isAdmin = $user->isAdmin();

    //     $rules = [
    //         'phone' => ['sometimes', 'string', 'max:50'],
    //         'password' => ['sometimes', 'string'],
    //     ];

    //     if ($isAdmin) {
    //         $rules['name'] = ['sometimes', 'string', 'max:255'];
    //         $rules['lastname'] = ['sometimes', 'string', 'max:255'];
    //         $rules['email'] = ['sometimes', 'email', 'max:255', 'unique:users,email,' . $user->id];
    //     }

    //     $validated = $request->validate($rules);

    //     if (isset($validated['password'])) {
    //         $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
    //     }

    //     $user->update($validated);
    //     $user->refresh()->load('counter.country');

    //     return $this->success(
    //         new UserResource($user),
    //         'Perfil actualizado com sucesso.'
    //     );
    // }


}
