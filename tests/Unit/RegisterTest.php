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

    public function test_all_registration(){
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testi@example.com',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/employees');
        $response->assertStatus(200);
    }

    public function test_name_field(){
        $response = $this->post('/register', [
            'name' => '1234',
            'email' => 'testi@example.com',
            'password' => 'Aa@12345',
            'password_confirmation' => 'Aa@12345',
        ]);
        $response->assertRedirect('/');
        $response->assertStatus(302);
    }
}
