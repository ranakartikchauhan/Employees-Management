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
                    ->visit('/employees')
                    ->waitForText('MYUSER')
                    ->assertSee('MYUSER');
        });
    }

    public function testDifferentUserCanLoginWithDiffrentBrowser()
    {
        $this->browse(function (Browser $first, Browser $second) {
            $first->visit('/register')
            ->type('name', 'userone')
            ->type('email', 'userone@gmail.com')
            ->type('password', 'Aa@12345')
            ->type('password_confirmation', 'Aa@12345')
            ->press('register')
            ->assertPathIs('/employees')
            ->assertSee('User Employees');

            $second->visit('/register')
            ->type('name', 'usertwo')
            ->type('email', 'usertwo@gmail.com')
            ->type('password', 'Aa@123456')
            ->type('password_confirmation', 'Aa@123456')
            ->press('register')
            ->assertPathIs('/employees')
            ->assertSee('User Employees');
        });
    }

    public function testPressBackButtonUserNotSeeDataAfterLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    // ->assertSee('Register User')
                    ->type('name', 'saurav')
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
                    ->visit('/employees')
                    ->waitForText('MYUSER')
                    ->assertSee('MYUSER')
                    ->logout()
                    ->visit('/employees')
                    ->assertDontSee('MYUSER');
        });
    }

    public function testSearchFunctonality()
    {
        $this->browse(function (Browser $browser) {
            $browser
                    ->visit('/register')
                    ->type('name', 'vijay')
                    ->type('email', 'hari@gmail.com')
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
                    ->waitForText('MYUSER')
                    ->assertSee('MYUSER')
                    ->visit('/employees/create')
                    ->assertSee('Create Employee')
                    ->type('name', 'myusertwo')
                    ->type('email', 'abcd@gmail.com')
                    ->select('gender', 'Male')
                    ->type('phone', '1234567890')
                    ->check('hobbies[]')
                    ->press('add')
                    ->assertPathIs('/employees')
                    ->visit('/employees')
                    ->type('search-input', 'MYUSERTWO')
                    ->waitForText('MYUSERTWO')
                    ->assertSee('MYUSERTWO');
        });
    }
}
