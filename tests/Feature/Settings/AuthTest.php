<?php

use App\Models\User;

it('can authenticate with valid credentials', function () {
    // user mit credentials erstellen
    $user = User::factory()->create([
        'email' => 'info@codebar.ch',
        'password' => 'password',
    ]);

    // authenticate user methode mit correkten eingabem
    \Pest\Laravel\actingAs($user);
    // nach auth-> wird eine session erstellt (hat es einen cookie)
    expect(session()->has('user'))->toBeTrue();
    assert(session()->has('user.email'));
});
