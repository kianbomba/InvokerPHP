<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/1/2018
 * Time: 11:19 AM
 */

namespace KianBomba\InvokerList;


use KianBomba\Exception\InstanceNotMatchException;

class ArrayList implements ListProvider
{
	/**
	 * @var string
	 */
	private $_instance;

	/**
	 * @var $this->_instance[]
	 */
	private $_container;

	public function __construct(string $class_name)
	{
		$this->_instance = $class_name;
		$this->_container = [];
	}

	public function isEmpty(): bool
	{
		return count($this->_container) === 0;
	}

	/**
	 * @param Object $item
	 * @throws InstanceNotMatchException
	 */
	public function push($item): void
	{
		if ($item instanceof $this->_instance === false) throw new InstanceNotMatchException($this->_instance, get_class($item));

		$this->_container[] = $item;
	}

	public function empty(): void
	{
		$this->_container = array();
	}

	public function getItem(int $index)
	{
		if (isset($this->_container[$index])) return $this->_container[$index];

		return null;
	}


}