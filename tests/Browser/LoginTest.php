<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function registerUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('Register User')
                    ->type('name', 'kartik')
                    ->type('email', 'abc@gmail.com')
                    ->type('password', 'Aa@12345')
                    ->type('password_confirmation', 'Aa@12345')
                    ->press('register')
                    ->assertPathIs('/employees')
                    ->assertSee('User Employees');
        });
    }

    public function loginUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/employees')
            ->logout()
            ->visit('login')
            ->type('email', 'abc@gmail.com')
            ->type('password', 'Aa@12345')
            ->press('login')
            ->assertPathIs('/employees')
            ->assertSee('User Employees');
        });
    }

    public function testLoginPageEnterKey()
    {
        $this->browse(function (Browser $browser) {
            $this->registerUser();
            $browser->visit('/employees')
            ->logout()
            ->visit('login')
            ->type('email', 'abc@gmail.com')
            ->type('password', 'Aa@12345')
            ->keys('.password', '{enter}')
            ->assertPathIs('/employees')
            ->assertSee('User Employees');
        });
    }
}
