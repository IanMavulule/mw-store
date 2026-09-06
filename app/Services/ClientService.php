<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientService
{
    public function create(array $data)
    {
        $client = User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'password' => Hash::make($data['password']),
            'birth_date' => $data['birth_date'],
            'role' => Role::Client,
            'ddd' => $data['ddd'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);

        return $client;
    }

    public function list()
    {
        return User::where('role', Role::Client)->get();
    }

    public function listById(string $id, User $authUser)
    {
        if (! $this->isStaff($authUser) && (int) $id !== $authUser->id) {
            throw new \DomainException('Não tem permissão para ver os dados deste cliente.');
        }

        return User::where('role', Role::Client)->findOrFail($id);
    }

    public function update(string $id, array $data, User $authUser)
    {
        $isStaff = $this->isStaff($authUser);

        if (! $isStaff && (int) $id !== $authUser->id) {
            throw new \DomainException('Não tem permissão para atualizar os dados deste cliente.');
        }

        $client = User::where('role', Role::Client)->findOrFail($id);

        $clientUpdate = [
            'name' => $data['name'] ?? $client->name,
            'lastname' => $data['lastname'] ?? $client->lastname,
            'birth_date' => $data['birth_date'] ?? $client->birth_date,
            'ddd' => $data['ddd'] ?? $client->ddd,
            'phone' => $data['phone'] ?? $client->phone,
            'email' => $data['email'] ?? $client->email,
        ];

        if (! empty($data['new_password']) || ! empty($data['old_password'])) {
            if ($isStaff) {
                throw new \DomainException('Administradores não podem alterar a senha do cliente.');
            }

            if (empty($data['old_password'])) {
                throw new \DomainException(
                    'A palavra-passe atual é obrigatória.'
                );
            }

            if (! Hash::check($data['old_password'], $client->password)) {
                throw new \DomainException(
                    'A antiga palavra-passe é diferente da atual.'
                );
            }

            $clientUpdate['password'] = Hash::make($data['new_password']);
        }

        if (! empty($data['status'])) {
            if (! $isStaff) {
                throw new \DomainException('Apenas administradores podem ativar ou desativar a conta.');
            }

            $clientUpdate['status'] = $data['status'];
        }

        $client->update($clientUpdate);

        return $client;
    }

    public function delete(string $id, User $authUser)
    {
        if (! $this->isStaff($authUser) && (int) $id !== $authUser->id) {
            throw new \DomainException('Não tem permissão para eliminar esta conta.');
        }

        $client = User::where('role', Role::Client)->findOrFail($id);
        $client->delete();

        return true;
    }

    private function isStaff(User $authUser): bool
    {
        return in_array($authUser->role, [Role::Admin, Role::Manager], true);
    }
}
