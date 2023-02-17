<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class RegisterTest extends DuskTestCase
{
    use RefreshDatabase;
    
    /**
     * A Dusk test example.
     */
    public function testRegisterPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('register')
                    ->type('name','kartik')
                    ->type('email','abc@gmail.com')
                    ->type('password','Aa@12345')
                    ->type('password_confirmation','Aa@12345')
                    ->press('register')
                    ->assertPathIs('/employees')
                    ->assertSee('User Employees');
        });
    }

}
