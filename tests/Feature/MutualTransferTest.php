<?php

use App\Models\User;

test('teacher can update profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put('/teacher/profile', [
        'ehrms_code' => 'TEACH123',
        'phone' => '1234567890',
        'current_district' => 'District A',
        'current_block' => 'Block 1',
        'current_school' => 'School X',
        'desired_district' => 'District B',
        'desired_block' => 'Block 2',
    ]);

    $response->assertSessionHasNoErrors();
    $user->refresh();

    expect($user->ehrms_code)->toBe('TEACH123');
    expect($user->current_district)->toBe('District A');
    expect($user->desired_district)->toBe('District B');
});

test('teacher finds mutual match', function () {
    // Teacher A: Currently in Dis A, Wants Dis B
    $teacherA = User::factory()->create([
        'name' => 'Teacher A',
        'current_district' => 'District A',
        'desired_district' => 'District B',
    ]);

    // Teacher B: Currently in Dis B, Wants Dis A (Match!)
    $teacherB = User::factory()->create([
        'name' => 'Teacher B',
        'current_district' => 'District B',
        'desired_district' => 'District A',
    ]);

    // Teacher C: Currently in Dis C, Wants Dis A (No Match for A)
    $teacherC = User::factory()->create([
        'name' => 'Teacher C',
        'current_district' => 'District C',
        'desired_district' => 'District A',
    ]);

    $response = $this->actingAs($teacherA)->get('/teacher/matches');

    $response->assertInertia(fn(Inertia\Testing\AssertableInertia $page) => $page
    ->component('Matches')
    ->has('matches', 1)
    ->where('matches.0.id', $teacherB->id)
    );
});
