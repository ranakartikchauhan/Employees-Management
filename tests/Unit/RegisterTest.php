<?php

namespace Tests\Unit;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_register_page_exist()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_all_registration_field()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/employees');
    }

    public function test_name_can_be_filled_with_string()
    {
        $response = $this->post('/register', [
            'name' => 'abc',
            'email' => 'abc@gmail.com',
            'password' => 'Aa@#1234',
            'password_confirmation' => 'Aa@#1234',
        ]);
        $response->assertRedirect('/employees');
     
    }

   


  


    public function test_name_not_accept_numerical()
    {
        $response = $this->post('/register', [
            'name' => '1234',
            'email' => 'testi@example.com',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
    }
    public function test_email_not_accept_numerical_input()
    {
        $response = $this->post('/register', [
            'name' => 'Abc',
            'email' => '1234',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
    }

    public function test_email_not_accept_only_character()
    {
        $response = $this->post('/register', [
            'name' => 'Abc',
            'email' => 'Abc',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
    }

    public function test_email_not_accept_without_dot()
    {
        $response = $this->post('/register', [
            'name' => 'Abc',
            'email' => 'abc@',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
    }

    public function test_email_not_accept_without_atTheRate()
    {
        $response = $this->post('/register', [
            'name' => 'Abc',
            'email' => 'abc.',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
    }

    public function test_email_not_accept_if_dotAndAtTheRateTogether()
    {
        $response = $this->post('/register', [
            'name' => 'Abc',
            'email' => 'abc@.com',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
    }
    public function test_email_not_accept_if_atTheRateInStart_and_dotInEnd()
    {
        $response = $this->post('/register', [
            'name' => 'Abc',
            'email' => '@abccom.',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
    }

    public function test_user_cant_register_with_same_email_which_already_exist()
    {
        $response = $this->post('/register', [
            'name' => 'abc',
            'email' => 'abc@gmail.com',
            'password' => 'Aa@#1234',
            'password_confirmation' => 'Aa@#1234',
        ]);
        $response->assertRedirect('/');
    }


    public function test_verify_user_can_use_all_alphabates_numbers_special_character_in_password()
    {
        $response = $this->post('/register', [
            'name' => 'regiwithallpass',
            'email' => 'regiwithallpass@gmail.com',
            'password' => 'Aa@#1234',
            'password_confirmation' => 'Aa@#1234',
        ]);
        $response->assertRedirect('/employees');
    }


    public function test_user_cant_not_register_if_password_and_confirm_not_match()
    {
        $response = $this->post('/register', [
            'name' => 'abc',
            'email' => 'abc1@gmail.com',
            'password' => 'Aa@#1234',
            'password_confirmation' => 'Aa@#123',
        ]);
        
        $response->assertSessionHasErrors([
            'password' => 'The password confirmation does not match.'
        ]);
        $response->assertRedirect('/');
    }


    public function test_user_cant_register_if_password_less_than_eight_character()
    {
        $response = $this->post('/register', [
            'name' => 'abc',
            'email' => 'abc1@gmail.com',
            'password' => 'Aa@#123',
            'password_confirmation' => 'Aa@#123',
        ]);
        
        $response->assertSessionHasErrors([
            'password' => 'The password must be at least 8 characters.'
        ]);
        $response->assertRedirect('/');
    }

    public function test_error_messages_showing_to_invalid_input()
    {
        $response = $this->post('/register', [
            'name' => '1234',
            'email' => '',
            'password' => 'Abc1122',
            'password_confirmation' => 'abc@#1234',
        ]);
        $response->dumpSession(['errors']);
        $response->assertRedirect('/');
    }


}
