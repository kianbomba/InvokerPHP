<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/1/2018
 * Time: 11:21 AM
 */

namespace KianBomba\Exception;

use Exception;


/**
 * Class InstanceNotMatchException
 * @package KianBomba\Exception
 */
class InstanceNotMatchException extends Exception
{

    /**
     * InstanceNotMatchException constructor.
     * @param string $expected_instance
     * @param $input
     * @param int $code
     * @param Exception|null $previous
     */
	public function __construct(string $expected_instance, $input, int $code = 0, Exception $previous = null)
	{
		$actual_instance = gettype($input);
		if (is_object($input)) $actual_instance = get_class($input);
		$message = "Expected Input Instance to be {$expected_instance} but received the {$actual_instance}";

		parent::__construct($message, $code, $previous);
	}
}