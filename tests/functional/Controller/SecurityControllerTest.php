<?php namespace App\Tests\Controller;

use Codeception\Test\Unit;

class SecurityControllerTest extends Unit
{
    /**
     * @var \App\Tests\FunctionalTester
     */
    protected $tester;

    public function testAuthenticate()
    {
        $this->tester->amOnPage("/login");
        $this->tester->see('Sign in', 'h1');
        $this->tester->seeResponseCodeIsSuccessful();
        $this->tester->submitForm('form', [
            'email' => 'user1@example.com',
            'password' => 'user1'
        ], 'Sign in');

        $this->tester->seeResponseCodeIsSuccessful();
        $this->tester->see('Logged as user1@example.com', 'header');
        $this->tester->seeInCurrentUrl('/news/my');
    }

    public function testAuthenticateInvalid()
    {
        $this->tester->amOnPage("/login");
        $this->tester->see('Sign in', 'h1');
        $this->tester->seeResponseCodeIsSuccessful();
        $this->tester->submitForm('form', [
            'email' => 'user1@example.com',
            'password' => 'user2'
        ], 'Sign in');

        $this->tester->seeResponseCodeIsSuccessful(); // yeah it should be 400 or sth. but it's built in SF
        $this->tester->see('Sign in', 'h1');
        $this->tester->dontSee('Logged as user1@example.com', 'header');
        $this->tester->dontSeeInCurrentUrl('/news/my');
        $this->tester->seeInCurrentUrl('/login');
        $this->tester->see('Invalid credentials.', '.alert-danger');
    }
}