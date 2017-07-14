<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    public function testFindByEmailShouldFindAnUserByItsEmail()
    {
        factory(User::class, 10)->create()->each(function($user){
            $foundUser = User::findByEmail($user->email);
            $this->assertEquals($foundUser->username, $user->username);
            $this->assertEquals($foundUser->email, $user->email);
            $this->assertEquals($foundUser->password, $user->password);
        });
    }
}
