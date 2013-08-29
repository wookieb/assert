<?php

namespace Wookieb\Assert\Tests;

use Wookieb\Assert\Assert;

class AssertTest extends \PHPUnit_Framework_TestCase
{

    public function notBlankDataProvider()
    {
        return array(
            'correct value' => array('landing'),
            'correct value with wrapping whitespaces' => array('  twitt  '),
            'whitespaces' => array('   ', false, 'Value cannot be blank'),
            'empty value' => array('', false, 'Name cannot be blank')
        );
    }

    /**
     * @dataProvider notBlankDataProvider
     */
    public function testNotBlank($value, $isCorrect = true, $message = null)
    {
        if ($isCorrect) {
            Assert::notBlank($value);
        } else {
            $this->setExpectedException('Wookieb\Assert\AssertException', $message);
            Assert::notBlank($value, $message);
        }
    }

    public function notEmptyDataProvider()
    {
        return array(
            'correct value' => array('OK'),
            'false' => array(false, false, 'Value cannot be empty'),
            'blank balue' => array('', false, 'name cannot be empty')
        );
    }

    /**
     * @dataProvider notEmptyDataProvider
     */
    public function testNotEmpty($value, $isCorrect = true, $message = null)
    {
        if ($isCorrect) {
            Assert::notEmpty($value);
        } else {
            $this->setExpectedException('Wookieb\Assert\AssertException', $message);
            Assert::notEmpty($value, $message);
        }
    }

    /**
     * @depends testNotBlank
     * @test method with "nullOr" prefix
     */
    public function testMethodsWithNullOrPrefix()
    {
        Assert::nullOrNotBlank(null);
        Assert::nullOrNotBlank('a');
        $this->setExpectedException('Wookieb\Assert\AssertException', 'Name cannot be blank');
        Assert::nullOrNotBlank('', 'Name cannot be blank');
    }

    public function testExceptionWhenAssertionMethodDoesNotExist()
    {
        $this->setExpectedException('\BadMethodCallException', '"assertion" does not exist');
        Assert::assertion('land');
    }

    public function testExceptionWhenAssertionMethodDoesNotExist2()
    {
        $this->setExpectedException('\BadMethodCallException', '"nullOrAssertion" does not exist');
        Assert::nullOrAssertion('land');
    }
}
