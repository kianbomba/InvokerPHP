<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/2/2018
 * Time: 8:06 AM
 */

namespace KianBomba\Exception;

use \Exception;
use Throwable;

class InvalidCharException extends Exception
{
	public function __construct(int $length, int $code = 0, Throwable $previous = null)
	{
		$message = "Expecting the length of parameter to construct char object is 1, but it is {$length}, failed to construct";
		parent::__construct($message, $code, $previous);
	}
}