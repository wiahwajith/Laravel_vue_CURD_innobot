<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); 
        $users = $this->userRepository->paginate($perPage);
    
        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
        $user = $this->userRepository->create($validated);
        return response()->json($user, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        return response()->json($user);
    }

    public function update(UserRequest $request, $id)
    {
        $validated = $request->validated();

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = $this->userRepository->update($id, $validated);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);
        return response()->json(['message' => 'User deleted successfully.']);
    }
}
