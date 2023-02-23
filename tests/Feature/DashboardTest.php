<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Hobby;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_dashboard_page_exist_and_access_by_admin()
    {
        $user = User::Factory()->create([
            'is_admin' => '1',
        ]);
        $employee = Employee::Factory()->create(
            [
                'user_id' => $user->id,
            ]);
        $hobbies = Hobby::Factory()->create([
            'employee_id' => $employee->id,
        ]);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_dashboard_page_not_acessable_by_users()
    {
        $user = User::Factory()->create();
        $employee = Employee::Factory()->create(
            [
                'user_id' => $user->id,
            ]);
        $hobbies = Hobby::Factory()->create([
            'employee_id' => $employee->id,
        ]);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(403);
    }
}
