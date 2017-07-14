<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    //use DatabaseMigrations;

    public function testLoginShouldReturnATokenWhenItReceivesValidCredentials()
    {
        //$this->disableExceptionHandling();

        $user = factory(User::class)->create(['password' => bcrypt('admin')]);

        $this
            ->post(route('api.auth.login'),[
                'email' => $user->email,
                'password' => 'admin',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }

    public function testLoginShouldReturnAnErrorWhenItReceivesInvalidCredentials()
    {
        //$this->disableExceptionHandling();

        $this
            ->post(route('api.auth.login'),[
                'email' => 'test@gmail.com',
                'password' => 'test',
            ])
            ->assertStatus(422);
    }

    public function testRegisterReturnsATokenIfEmailDoesNotExists()
    {
        //$this->disableExceptionHandling();

        $this
            ->post(route('api.auth.register'),[
                'username' => 'Illia Morkva',
                'email' => 'illia@gmail.com',
                'password' => '123456',
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'token',
            ]);
    }

    public function testRegisterAnErrorIfEmailAlreadyExist()
    {
        //$this->disableExceptionHandling();

        $user = factory(User::class)->create();

        $this
            ->post(route('api.auth.register'),[
                'email' => $user->email,
                'username' => 'whatever',
                'password' => '123',
            ])
            ->assertStatus(422);
    }
}

