<?php

use App\Models\User;

test('a visitor can register', function () {
    $response = $this->post('/register', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'email' => 'jane@example.com',
        'name' => 'Jane Doe',
    ]);
});

test('a user can log in and log out', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);

    $this->post('/logout')->assertRedirect(route('posts.index'));

    $this->assertGuest();
});

test('invalid login credentials are rejected', function () {
    $user = User::factory()->create([
        'email' => 'jane@example.com',
        'password' => 'password',
    ]);

    $this->from('/login')
        ->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])
        ->assertRedirect('/login')
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('guests cannot access the dashboard', function () {
    $this->get('/dashboard')->assertRedirect(route('login'));
});
