<?php

namespace App\Services;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService {
    public function create(array $data) {
        $role = Role::from($data["role"]);

        $user = User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'password' => Hash::make($data['password']),
            'birth_date' => $data['birth_date'],
            'role' => $role,
            'ddd' => $data['ddd'],
            'phone' => $data['phone'],
            'email' => $data['email']
        ]);

        return $user;
    }

    public function list() {
        $users = User::whereIn("role", ["admin", "manager"])->get();
        return $users;
    }

    public function listById(string $id) {
        $user = User::findOrFail($id);
        return $user;
    }

    public function delete(string $id, User $authUser) {
        if($id === (string) $authUser->id) {
            throw new \DomainException('Não pode eliminar a sua própria conta.');
        }
        $user = User::findOrfail($id);
        $user->delete();
        return true;
    }

   public function update(string $id, array $data, User $authUser)
    {
        // Apenas o próprio usuário ou um Admin pode editar
        if ((int) $id !== $authUser->id && !$authUser->isAdmin()) {
            throw new \DomainException(
                'Não tem permissão para atualizar dados deste usuário.'
            );
        }

        $user = User::findOrFail($id);

        $userUpdate = [
            'name' => $data['name'] ?? $user->name,
            'lastname' => $data['lastname'] ?? $user->lastname,
            'birth_date' => $data['birth_date'] ?? $user->birth_date,
            'ddd' => $data['ddd'] ?? $user->ddd,
            'phone' => $data['phone'] ?? $user->phone,
            'email' => $data['email'] ?? $user->email,
        ];

        // Alteração da password
        if (!empty($data['new_password'])) {

            // Se estiver a alterar a própria password,
            // precisa confirmar a password antiga
            if ((int) $id === $authUser->id) {

                if (empty($data['old_password'])) {
                    throw new \DomainException(
                        'A palavra-passe atual é obrigatória.'
                    );
                }

                if (!Hash::check($data['old_password'], $user->password)) {
                    throw new \DomainException(
                        'A antiga palavra-passe é diferente da atual.'
                    );
                }
            }

            $userUpdate['password'] = Hash::make($data['new_password']);
        }

        // Alteração do role
        if (!empty($data['role'])) {

            if (!$authUser->isAdmin()) {
                throw new \DomainException(
                    'Apenas administradores podem atualizar o role.'
                );
            }

            $userUpdate['role'] = $data['role'];
        }

        $user->update($userUpdate);

        return $user;
    }

    public function generateNewPass(string $id, User $authUser) {
        if(!$authUser->isAdmin()) {
            throw new \DomainException('Apenas administradores geram novas passwords');
        }

        $password = $this->generateUserCode();
        $new_password = Hash::make($password);

        $user = User::findOrFail($id);
        $user->update([
            "password" => $new_password
        ]);
    }

    private function generateUserCode(): string
    {
        $code = "MW" . '-' . strtoupper(Str::random(8));

        return $code;
    }

}
