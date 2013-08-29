<?php

namespace Wookieb\Assert;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 *
 * @method static nullOrNotBlank($value, $message = 'Value cannot be blank')
 * @method static nullOrNotEmpty($value, $message = 'Value cannot be empty')
 */
class Assert
{
    /**
     * Assert that value is not blank
     *
     * @param string $value
     * @param string $message
     * @throws AssertException
     */
    public static function notBlank($value, $message = 'Value cannot be blank')
    {
        $value = trim($value);
        if ($value === '') {
            throw new AssertException($message);
        }
    }

    /**
     * Assert that value cannot be empty
     * List of "empty" values http://pl1.php.net/empty
     *
     * @param mixed $value
     * @param string $message
     * @throws AssertException
     */
    public static function notEmpty($value, $message = 'Value cannot be empty')
    {
        if (empty($value)) {
            throw new AssertException($message);
        }
    }

    /**
     * Handle call of methods like "nullOr[assertionName]"
     * If value is null then assertion will not be called
     *
     * @param mixed $name
     * @param array $arguments
     * @throws \BadMethodCallException when method does not exist
     */
    public static function __callStatic($name, $arguments)
    {
        $prefix = substr($name, 0, 6);
        if ($prefix === 'nullOr') {
            $value = reset($arguments);
            if ($value === null) {
                return;
            }
            $method = substr($name, 6);
            $calledClass = get_called_class();
            if (method_exists($calledClass, $method)) {
                call_user_func_array(array($calledClass, $method), $arguments);
                return;
            }
        }

        throw new \BadMethodCallException('Method "'.$name.'" does not exist');
    }
} 
