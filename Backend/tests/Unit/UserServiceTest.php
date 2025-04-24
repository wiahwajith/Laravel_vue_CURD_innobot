<?php

namespace Tests\Unit;

use App\Services\UserService;
use App\Interfaces\UserRepositoryInterface;
use App\Models\UserData;
use PHPUnit\Framework\TestCase;
use Mockery;

class UserServiceTest extends TestCase
{
    protected $userService;
    protected $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        // Mock the UserRepositoryInterface
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        
        // Instantiate the service and inject the mocked repository
        $this->userService = new UserService($this->userRepositoryMock);
    }

    public function test_getAllUsersPaginated_returns_paginated_users()
    {
        // Arrange: Prepare mock data
        $users = collect([
            new UserData(['id' => 1, 'name' => 'John Doe']),
            new UserData(['id' => 2, 'name' => 'Jane Doe']),
        ]);
        
        $this->userRepositoryMock
            ->shouldReceive('paginate')
            ->once()
            ->with(10)
            ->andReturn($users);
        
        // Act: Call the method
        $result = $this->userService->getAllUsersPaginated(10);

        // Assert: Ensure the result is as expected
        $this->assertCount(2, $result);
        $this->assertEquals('John Doe', $result[0]->name);
        $this->assertEquals('Jane Doe', $result[1]->name);
    }

    public function test_findUserById_returns_user()
    {
        // Arrange: Prepare mock data
        $user = new UserData(['id' => 1, 'name' => 'John Doe']);
        
        $this->userRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($user);
        
        // Act: Call the method
        $result = $this->userService->findUserById(1);

        // Assert: Ensure the result is as expected
        $this->assertEquals('John Doe', $result->name);
    }

    public function test_createUser_creates_and_returns_user()
    {
        // Arrange: Prepare mock data
        $userData = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $user = new UserData($userData);
        
        $this->userRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($userData)
            ->andReturn($user);
        
        // Act: Call the method
        $result = $this->userService->createUser($userData);

        // Assert: Ensure the result is as expected
        $this->assertEquals('John Doe', $result->name);
        $this->assertEquals('john@example.com', $result->email);
    }

    public function test_updateUser_updates_and_returns_user()
    {
        // Arrange: Prepare mock data
        $userData = ['name' => 'John Doe Updated'];
        $user = new UserData(['id' => 1, 'name' => 'John Doe']);
        
        $this->userRepositoryMock
            ->shouldReceive('update')
            ->once()
            ->with(1, $userData)
            ->andReturn($user);
        
        // Act: Call the method
        $result = $this->userService->updateUser(1, $userData);

        // Assert: Ensure the result is as expected
        $this->assertEquals('John Doe', $result->name);
    }

    public function test_deleteUser_deletes_and_returns_user()
    {
        // Arrange: Prepare mock data
        $user = new UserData(['id' => 1, 'name' => 'John Doe']);
        
        $this->userRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);
        
        // Act: Call the method
        $result = $this->userService->deleteUser(1);

        // Assert: Ensure the result is as expected
        $this->assertTrue($result);
    }

    // Clean up after tests
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
