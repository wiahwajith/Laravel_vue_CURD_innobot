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

    /**
     * Get all users paginated
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllUsersPaginated(int $perPage = 10)
    {
        return $this->userRepository->paginate($perPage);
    }

    /**
     * Find a user by ID
     *
     * @param int $id
     * @return mixed
     */
    public function findUserById(int $id)
    {
        return $this->userRepository->find($id);
    }

    /**
     * Create a user
     *
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data)
    {
        $data['profile_picture'] = $this->handleProfilePicture($data['profile_picture'] ?? null);

        return $this->userRepository->create($data);
    }

    /**
     * Update user information
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateUser(int $id, array $data)
    {
        $data['profile_picture'] = $this->handleProfilePicture($data['profile_picture'] ?? null);

        return $this->userRepository->update($id, $data);
    }

    /**
     * Delete user by ID
     *
     * @param int $id
     * @return bool
     */
    public function deleteUser(int $id)
    {
        return $this->userRepository->delete($id);
    }

    /**
     * Handle profile picture upload if exists
     *
     * @param mixed $profilePicture
     * @return string|null
     */
    private function handleProfilePicture($profilePicture): ?string
    {
        if ($profilePicture) {
            return $profilePicture->store('profile_pictures', 'public');
        }

        return null;
    }
}
