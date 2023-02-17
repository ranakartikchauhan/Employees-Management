<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class EmployeesPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    use RefreshDatabase;
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


    public function testLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('employees')
            ->logout()
            ->visit('login')
            ->type('email','abc@gmail.com')
            ->type('password','Aa@12345')
            ->press('login')
            ->assertPathIs('/employees')
            ->assertSee('User Employees');
        });
    }
    
    // public function testCreateEmployeePage()
    // {
    //     $this->testLoginPage();
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/employees')
    //             ->assertSee('User Employees')
    //             ->visit('employees/create')
    //             ->assertSee('Create Employee')
    //             ->type('name','hello')
    //             ->type('email','hello@gmail.com')
    //             ->select('gender') 
    //             ->check('status')
    //             ->type('phone','1234567890')
    //             ->check('hobbies[]')
    //             ->press('ADD')
    //             ->visit('employees')
    //             ->assertSee("hello");
    //     });
    // }

 
    // public function testEmployeeShowPageAccessByAuthenticatedUser()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/employees/1')
    //         ->assertSee('hello');
    //         ;
    //     });
    // }
}
