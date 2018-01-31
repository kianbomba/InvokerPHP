<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/1/2018
 * Time: 11:21 AM
 */

namespace KianBomba\Exception;

use Exception;

class InstanceNotMatchException extends Exception
{
	public function __construct(string $expected_instance, string $actual_instance, int $code = 0, Exception $previous = null)
	{
		$message = "Expected Instance {$expected_instance} but received the {$actual_instance}";
		parent::__construct($message, $code, $previous);
	}
}