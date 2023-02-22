<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EmployeePageTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     */
    public function testOnlyAuthUserCanSeeTheirData()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    // ->assertSee('Register User')
                    ->type('name', 'kartik')
                    ->type('email', 'abc@gmail.com')
                    ->type('password', 'Aa@12345')
                    ->type('password_confirmation', 'Aa@12345')
                    ->press('register')
                    ->assertPathIs('/employees')
                    ->assertSee('User Employees')
                    ->visit('/employees/create')
                    ->assertSee('Create Employee')
                    ->type('name', 'myuser')
                    ->type('email', 'abc@gmail.com')
                    ->select('gender', 'Male')
                    ->type('phone', '1234567890')
                    ->check('hobbies[]')
                    ->press('add')
                    ->assertPathIs('/employees')
                    ->assertSee('MYUSER')
                    ;
        });
    }
}
