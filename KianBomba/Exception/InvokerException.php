<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 1/26/2018
 * Time: 12:42 PM
 */

namespace KianBomba\Exception;

use \Exception;

class InvokerException extends Exception
{
	public function __construct(string $message, int $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}