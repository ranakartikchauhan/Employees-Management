<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function registerUser()
    {
        $response = $this->post('/register', [
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => 'User@1234',
            'password_confirmation' => 'User@1234',
        ]);
        $response->assertRedirect('/employees');
    }

    public function test_login_page_exist()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_login_with_valid_info()
    {
        $user = User::Factory()->create();
        $response = $this->actingAs($user)->post('/login');
        $response->assertRedirect('/employees');
    }

    public function test_user_can_not_login_with_invalid_email()
    {
        $response = $this->post('/login', [
            'email' => 'user@gmal.com',
            'password' => 'User@1234',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);
        $response->assertRedirect('/');
    }

    public function test_user_can_not_with_invalid_password()
    {
        $response = $this->post('/login', [
            'email' => 'user@gmail.com',
            'password' => 'User@12348',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.',
        ]);
        $response->assertRedirect('/');
    }

    public function test_user_can_not_login_with_blank_email_and_password()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);
        $response->assertRedirect('/');
    }

    public function test_forgot_password_functionality_is_working()
    {
        $response = $this->post('/forgot-password', [
            'email' => 'user@gmail.com',
        ]);
        $response->assertStatus(302);
        $response->dumpSession();
        $response->assertRedirect('/');
    }

    public function test_error_messages_in_login_form()
    {
        $response = $this->post('/login', [

            'email' => '',
            'password' => '',
        ]);
        $response->assertStatus(302);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
        ]);

        $response->dumpSession(['errors']);
    }

    public function user_can_login_with_new_password()
    {
        $this->post('/login', [

            'email' => 'abc@gmail.com',
            'password' => 'User@12345',
        ]);

        $this->post('/change-password', [

            'old_password' => 'User@12345',
            'new_password' => 'User@1122',
            'new_password_confirmation' => 'User@1122',
        ]);
        $response = $this->post('/login', [

            'email' => 'abc@gmail.com',
            'password' => 'User@1122',
        ]);

        $response->assertRedirect('/employees');
    }
}
