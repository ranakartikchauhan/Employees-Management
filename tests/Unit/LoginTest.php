<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_user_can_register()
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
    public function test_user_can_login_with_valid_email_and_password()
    {

        $response = $this->post('/login', [

            'email' => 'user@gmail.com',
            'password' => 'User@1234',
        ]);
        $response->assertRedirect('/employees');
    }

    public function test_user_can_not_login_with_invalid_email_and_valid_password()
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

    public function test_user_can_not_login_with_valid_email_and_invalid_password()
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

    public function test_user_can_not_login_with_blank_email_and_blank_password()
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
            'email' => "user@gmail.com",
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
