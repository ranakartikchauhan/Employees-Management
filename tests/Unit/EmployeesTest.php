<?php

namespace Tests\Unit;

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
        // dd($user->toArray());
        // $createUser =$user->toArray();
        // $response = $this->post('register',$createUser);
        // $response->assertStatus(302);
        // $response->assertRedirect('/employees');
        // $logUser= $user->toArray();
        $this->assertDatabaseHas('employees', ['name' => $user['name'], 'email' =>$user['email']]);

        // dd($logUser);
        $response = $this->post('/login',['_token' => csrf_token(),'email'=>$user['email'],'password'=>$user['password']]);
        $response->assertStatus(302);
        $response->assertRedirect('/employees');
        $response = $this->get('/employees');
        $response->assertStatus(200);
    }

    public function test_create_employees_page_exist()
    {
        $this->login();
        $response = $this->get('/employees/create');
        $response->assertStatus(200);
    }

    public function test_employees_data_is_storing()
    {
        $this->login();
        $response = $this->post('/employees', [
            '_token' => csrf_token(),
            'name' => "abced",
            'email' => "test@gmai.com",
            'gender' => "Male",
            "is_active" => "1",
            'phone' => '1234567890',
            'hobbies' => ["Dancing"],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/employees');

        $this->assertDatabaseHas('employees', ['name' => 'abced', 'email' => "test@gmai.com",
            'gender' => "Male",
            "is_active" => "1",
            'phone' => '1234567890']);
        $this->assertDatabaseHas('employee_hobbies', ['hobbies' => 'Dancing']);

    }

    public function test_employee_can_access_by_auth_user()
    {
        $this->login();
        $response = $this->get('employees/1');
        $response->assertStatus(200);

    }
    public function test_update_employee_functionality()
    {

        $this->login();
        $response = $this->put('/employees/1', [
            '_token' => csrf_token(),
            'user_id' => '1',
            'name' => 'nametwo',
            'email' => 'test2@employee.com',
            'gender' => 'Male',
            'phone' => '1234567890',
            'hobbies' => ['Playing'],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', [
            'user_id' => '1',
            'name' => 'nametwo',
            'email' => 'test2@employee.com',
            'gender' => 'Male',
            'phone' => '1234567890']);
    }

    public function test_employee_delete_functionality()
    {
        $this->login();
        $response = $this->delete('employees/1');
        $response->assertStatus(302);
        $response->assertRedirect('/employees');
        $this->assertDatabaseMissing('employees', ['name' => 'abced', 'email' => "test@gmai.com",
        'gender' => "Male",
        "is_active" => "1",
        'phone' => '1234567890']);

        $this->assertDatabaseMissing('employee_hobbies', ['hobbies' => 'Dancing']);

    }

}
