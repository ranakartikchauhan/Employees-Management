<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Hobby;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_verify_logout_functionality()
    {
        $user = User::Factory()->create();
        $employee = Employee::Factory()->create(
            [
                'user_id' => $user->id,
            ]);
        $hobbies = Hobby::Factory()->create([
            'employee_id' => $employee->id,
        ]);

        $response = $this->actingAs($user)->get('/employees');
        $response->assertStatus(200);
        $response = $this->post('/logout');
        $response = $this->get('/employees');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_forgot_password_functionality()
    {
        $user = User::Factory()->create();
        $employee = Employee::Factory()->create(
            [
                'user_id' => $user->id,
            ]);
        $hobbies = Hobby::Factory()->create([
            'employee_id' => $employee->id,
        ]);
        $response = $this->post('/forgot-password', $user->toArray());
        $response->assertStatus(302);
        $response->assertSessionHasAll([
            'status' => 'We have emailed your password reset link!',
        ]);
    }
}
