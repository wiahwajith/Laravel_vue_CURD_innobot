<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;
    use ApiResponser;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function index(Request $request)
    {
        return $this->handleAction(function () use ($request) {
            $perPage = $request->input('per_page', 10);
            $users = $this->userRepository->paginate($perPage);
            return $this->successResponse($users, 'Users fetched successfully');
        }, 'Failed to fetch users');
    }

    public function store(UserRequest $request)
    {
        return $this->handleAction(function () use ($request) {
            $validated = $this->handleFileUpload($request);
            $user = $this->userRepository->create($validated);
            return $this->successResponse($user, 'User created successfully', Response::HTTP_CREATED);
        }, 'Failed to create user');
    }

    public function show($id)
    {
        return $this->handleAction(function () use ($id) {
            $user = $this->userRepository->find($id);
            return $this->successResponse($user, 'User details retrieved');
        }, 'Failed to retrieve user');
    }

    public function update(UserRequest $request, $id)
    {
        return $this->handleAction(function () use ($request, $id) {
            $validated = $this->handleFileUpload($request);
            $user = $this->userRepository->update($id, $validated);
            return $this->successResponse($user, 'User updated successfully');
        }, 'Failed to update user');
    }

    public function destroy($id)
    {
        return $this->handleAction(function () use ($id) {
            $this->userRepository->delete($id);
            return $this->successResponse(null, 'User deleted successfully');
        }, 'Failed to delete user');
    }

    private function handleFileUpload(UserRequest $request): array
    {
        $validated = $request->validated();

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        return $validated;
    }

    
}
