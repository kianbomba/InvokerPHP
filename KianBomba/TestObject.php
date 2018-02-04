<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/1/2018
 * Time: 11:58 AM
 */

namespace KianBomba;


class TestObject
{
	private $_name;

	public function __construct(string $name)
	{
		$this->_name = $name;
	}

	public function getName(): string
	{
		return $this->_name;
	}
}
