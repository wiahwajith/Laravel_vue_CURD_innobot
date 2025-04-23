<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Interfaces\UserRepositoryInterface;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsersPaginated($perPage = 10)
    {
        return $this->userRepository->paginate($perPage);
    }

    public function findUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data)
    {
        if (isset($data['profile_picture'])) {
            $data['profile_picture'] = $data['profile_picture']->store('profile_pictures', 'public');
        }

        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        if (isset($data['profile_picture'])) {
            $data['profile_picture'] = $data['profile_picture']->store('profile_pictures', 'public');
        }

        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }
}
