<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
class EmployeesPageTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     */
    public function registerUser()
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


    public function loginUser()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/employees')
            ->logout()
            ->visit('login')
            ->type('email','abc@gmail.com')
            ->type('password','Aa@12345')
            ->press('login')
            ->assertPathIs('/employees')
            ->assertSee('User Employees');
        });
    }

 
    public function testEmployeeShowPageAccessByAuthenticatedUser()
    {   $this->loginUser();
        $this->browse(function (Browser $browser) {
            $browser->visit('/employees/1')
            ->assertSee('hello');
            ;
        });
    }


    public function testEmployeePageNotAccessByUnauthenticatedUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/employees')
            ->logout()
            ->visit('/employees')
            ->assertSee('LOG IN');

        });
    }


    
}
