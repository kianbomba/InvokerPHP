<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/1/2018
 * Time: 11:19 AM
 */

namespace KianBomba\InvokerList;

use KianBomba\Exception\InstanceNotMatchException;

/**
 * Class ArrayList
 * @package KianBomba\InvokerList
 */
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

	/**
	 * @var mixed
	 */
	private $_iterator;

	/**
	 * ArrayList constructor.
	 * @param string $class_name
	 * @param array $data
	 * @throws InstanceNotMatchException
	 */
	public function __construct(string $class_name, array $data = [])
	{
		$this->_instance = $class_name;
		$this->_container = [];
		$this->_iterator = null;

		if (count($data) > 0)
		{
			foreach ($data as $item)
			{
				if ($item instanceof $this->_instance === false)
				{
					throw new InstanceNotMatchException($this->_instance, $item);
				}

				$this->_container[] = $item;
			}
		}
	}

	/**
	 * @return bool
	 * @description checking whether the container is empty or not
	 */
	public function isEmpty(): bool
	{
		return count($this->_container) === 0;
	}

	/**
	 * @param object|mixed $item
	 * @throws InstanceNotMatchException
	 *
	 * @description: when you are pushing any object to the container,
	 * the method will checking whether the object that is pushed to the container is the instance of the type
	 * specified in the constructor or not, if false, then Exception would be thrown
	 */
	public function push($item): void
	{
		if (is_object($item) && get_class($item) !== $this->_instance)
		{
			throw new InstanceNotMatchException($this->_instance, $item);
		}
		else if (!is_object($item) && gettype($item) !== $this->_instance)
		{
			throw new InstanceNotMatchException($this->_instance, $item);
		}

		$this->_container[] = $item;
	}

	/**
	 * @description reset the container to an empty array
	 */
	public function empty(): void
	{
		$this->_container = array();
	}

	/**
	 * @return mixed
	 */
	public function getCurrent()
	{
		if (!is_null($this->_iterator) && isset($this->_container[$this->_iterator])) return $this->_container[$this->_iterator];


		return $this->getFirstItem();
	}

	/**
	 * @return mixed|object
	 */
	public function getLastItem()
	{
		return end($this->_container);
	}

	/**
	 * @return mixed
	 */
	public function getFirstItem()
	{
		reset($this->_container);
		return current($this->_container);
	}

	/**
	 * @param mixed $iterator
	 * @return ListProvider
	 */
	public function setIterator(int $iterator): ListProvider
	{
		$this->_iterator = $iterator;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getItems(): array
	{
		return $this->_container;
	}

	/**
	 * @return int
	 */
	public function getSize(): int
	{
		return count($this->_container);
	}

	/**
	 * @param mixed $key
	 * @return bool
	 */
	public function remove($key): bool
	{
		if (is_null($key) || !isset($this->_container[$key])) return false;
		unset($this->_container[$key]);
		return true;
	}
}