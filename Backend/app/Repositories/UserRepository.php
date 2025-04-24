<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\UserData;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return UserData::all();
    }

    public function paginate($perPage = 10)
    {
        return UserData::latest()->paginate($perPage); 
    }

    public function find($id)
    {
        return UserData::findOrFail($id);
    }

    public function create(array $data)
    {
        return UserData::create($data);
    }

    public function update($id, array $data)
    {
        $user = UserData::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = UserData::findOrFail($id);
        return $user->delete();
    }
}
