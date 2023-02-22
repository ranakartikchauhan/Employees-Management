<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Hobby;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_employees_page_can_not_access_by_unAuth_user()
    {
        $response = $this->get('/employees');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    public function test_employees_page_exist_and_access_by_auth_user()
    {
        $user = User::Factory()->create();
        $response = $this->actingAs($user)->get('/employees');
        $response->assertStatus(200);
    }

    public function test_create_employees_page_exist()
    {
        $user = User::Factory()->create();
        $response = $this->actingAs($user)->get('/employees/create');
        $response->assertStatus(200);
    }

    public function test_employees_data_is_storing()
    {
        $employee = Employee::Factory()->create();
        $hobbies = Hobby::Factory()->create();
        $this->assertDatabaseHas('employees', $employee->toArray());
        $this->assertDatabaseHas('employee_hobbies', $hobbies->toArray());
    }

    public function test_employee_can_access_by_auth_user()
    {
        $user = User::Factory()->create();
        $employee = Employee::Factory()->create(
            [
                'user_id' => $user->toArray()['id'],
            ]);
        $hobbies = Hobby::Factory()->create([
            'employee_id' => $employee->toArray()['id'],
        ]);
        $employeeId = $employee->toArray()['id'];
        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('employees', $employee->toArray());
        $response = $this->actingAs($user)->get("/employees/$employeeId");
        $response->assertStatus(200);
    }
    // public function test_update_employee_functionality()
    // {
    //     $user = User::Factory()->create();
    //     $employee = Employee::Factory()->create(
    //         [
    //             'user_id'=>$user->toArray()['id']
    //         ]);
    //     $employeeId = $employee->toArray()['id'];
    //     $hobbies = Hobby::Factory()->create([
    //         'employee_id'=>$employee->toArray()['id']
    //     ]);

    //     $updateEmployee = Employee::Factory()->create(
    //         [
    //             'user_id'=>$user->toArray()['id'],
    //         ]);

    //     $updatedHobbies= [['hobbies'=>'Dancing'],['hobbies'=>'Playing']];
    //     $employeeWithHobbies = array_merge($updateEmployee->toArray(),$hobbies);
    //     dd($employeeWithHobbies);
    //     $response = $this->actingAs($user)->put("/employees/$employeeId",$employeeWithHobbies);
    //     $response->assertStatus(302);
    //     $response->assertRedirect('/employees');
    //     $this->assertDatabaseHas('employees', );
    // }

    public function test_employee_delete_functionality()
    {
        $user = User::Factory()->create();
        $employee = Employee::Factory()->create(
            [
                'user_id' => $user->toArray()['id'],
            ]);
        $hobbies = Hobby::Factory()->create([
            'employee_id' => $employee->toArray()['id'],
        ]);
        $employeeId = $employee->toArray()['id'];
        $response = $this->actingAs($user)->delete("employees/$employeeId");
        $response->assertStatus(302);
        $response->assertRedirect('/employees');
        $this->assertDatabaseMissing('employees', $employee->toArray());
        $this->assertDatabaseMissing('employee_hobbies', ['hobbies' => 'Dancing']);
    }
}
