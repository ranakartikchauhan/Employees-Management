<?php
namespace Tests\Browser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use RefreshDatabase;
    /**
     * A basic functional test example.
     *
     * @return void
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



    public function testLoginPage()
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
    public function testLoginPageEnterKey()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/employees')
            ->logout()
            ->visit('login')
            ->type('email','abc@gmail.com')
            ->type('password','Aa@12345')
            ->keys('.password', '{enter}')
            ->assertPathIs('/employees')
            ->assertSee('User Employees');
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
