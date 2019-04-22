<?php

namespace App\Tests;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * Define custom actions here
     */

    public function amAuthenticated($email = 'user1@example.com', $password = 'user1')
    {
        $this->amOnPage("/login");
        $this->submitForm('form', [
            'email' => $email,
            'password' => $password
        ], 'Sign in');
        $this->seeResponseCodeIsSuccessful();
    }
}
