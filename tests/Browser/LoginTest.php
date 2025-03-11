<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function test_user_can_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://localhost:8000/login')
                ->waitFor('input[name="email"]', 5)
                ->screenshot('login-page')
                ->type('email', 'vb@abc.de')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/')
                ->assertSee('Successfully logged in');
        });
    }
}
