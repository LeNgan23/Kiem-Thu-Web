<?php
namespace functional;

use \Codeception\Actor;

class UserLoginTest extends \Codeception\tests\functional
{
    public function testLoginWithValidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Username', 'validUser');
        $I->fillField('Password', 'validPassword');
        $I->click('Login');
        $I->see('Welcome validUser');
    }

    public function testLoginWithInvalidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('Username', 'invalidUser');
        $I->fillField('Password', 'invalidPassword');
        $I->click('Login');
        $I->see('Invalid username or password');
    }
}
