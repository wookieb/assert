<?php

namespace Wookieb\Assert\Tests;

use Wookieb\Assert\Assert;

class AssertTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $name
     * @param mixed $value value to test
     * @param string $message error message - if provided then we will expect an assert exception to be thrown
     */
    private function runMethod($name, $value, $message)
    {
        $arguments = array_slice(func_get_args(), 1);
        if ($message) {
            $this->setExpectedException('Wookieb\Assert\AssertException', $message);
        }
        call_user_func_array(array('Wookieb\Assert\Assert', $name), $arguments);
    }

    public function notBlankDataProvider()
    {
        return array(
            'correct value' => array('landing'),
            'correct value with wrapping whitespaces' => array('  twitt  '),
            'whitespaces' => array('   ', 'Value cannot be blank'),
            'empty value' => array('', 'Name cannot be blank'),
            'falsy value' => array(false, 'Value cannot be blank')
        );
    }

    /**
     * @dataProvider notBlankDataProvider
     */
    public function testNotBlank($value, $message = null)
    {
        $this->runMethod('notBlank', $value, $message);
    }

    public function notEmptyDataProvider()
    {
        return array(
            'correct value' => array('OK'),
            'false' => array(false, 'Value cannot be empty'),
            'blank balue' => array('', 'name cannot be empty')
        );
    }

    /**
     * @dataProvider notEmptyDataProvider
     */
    public function testNotEmpty($value, $message = null)
    {
        $this->runMethod('notEmpty', $value, $message);
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


    public function okDataProvider()
    {
        return array(
            'true' => array(true),
            'truthy value' => array('some data'),
            'false' => array(false, 'Value cannot be falsy'),
            'falsy value' => array(0, 'Number cannot be 0')
        );
    }

    /**
     * @dataProvider okDataProvider
     */
    public function testOk($value, $message = null)
    {
        $this->runMethod('ok', $value, $message);
    }

    public function falsyDataProvider()
    {
        return array(
            'false' => array(false),
            'falsy value' => array(0),
            'true' => array(true, 'Value cannot be truthy'),
            'truthy value' => array('some data', 'Property contains some data')
        );
    }

    /**
     * @dataProvider falsyDataProvider
     */
    public function testFalsy($value, $message = null)
    {
        $this->runMethod('falsy', $value, $message);
    }

    public function notNullDataProvider()
    {
        return array(
            'truthy string' => array('name'),
            'falsy value' => array(0),
            'empty array' => array(array()),
            'null wit' => array(null, 'Value cannot be null')
        );
    }

    /**
     * @dataProvider notNullDataProvider
     */
    public function testNotNull($value, $message = null)
    {
        $this->runMethod('notNull', $value, $message);
    }

    public function numberDataProvider()
    {
        return array(
            'float' => array(1.11),
            'zero' => array(0),
            'integer' => array(10),
            'numerish' => array('11.1'),
            'true' => array('true', 'Value is not a number'),
            'object' => array(new \stdClass(), 'Object is not a number')
        );
    }

    /**
     * @dataProvider numberDataProvider
     */
    public function testNumber($value, $message = null)
    {
        $this->runMethod('number', $value, $message);
    }

    public function positiveNumberProvider()
    {
        return array(
            'positive number' => array(1),
            'not a number' => array('name', 'Value is not a positive number'),
            'negative number' => array(-1, 'Value cannot be less than zero please!'),
            'zero' => array(0, 'Value is not a positive number')
        );
    }

    /**
     * @dataProvider positiveNumberProvider
     */
    public function testPositiveNumber($value, $message = null)
    {
        $this->runMethod('positiveNumber', $value, $message);
    }

    public function negativeNumberProvider()
    {
        return array(
            'negative number' => array(-1),
            'not a number' => array('name', 'Value is not a negative number'),
            'positive number' => array(10, 'Value cannot be greater than zero please!'),
            'zero' => array(0, 'Value is not a negative number')
        );
    }

    /**
     * @dataProvider negativeNumberProvider
     */
    public function testNegativeNumber($value, $message = null)
    {
        $this->runMethod('negativeNumber', $value, $message);
    }
}
