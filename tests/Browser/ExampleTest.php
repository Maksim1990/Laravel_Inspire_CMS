<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLoginTest()
    {

        $user=User::where('email','like','test@%')->where('admin',0)->first();
        $password="testtest";

        $this->browse(function ($first) use($user,$password) {
            $first->visit('/en/login')
                ->assertSee('Login')
                ->type('email',$user->email)
                ->type('password',$password)
                ->click('#button')
                ->assertSee('Dashboard');
        });
    }
}
