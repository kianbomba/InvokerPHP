<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/1/2018
 * Time: 11:15 AM
 */

namespace KianBomba\InvokerList;


use KianBomba\Exception\InstanceNotMatchException;

interface ListProvider
{
	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 * @param mixed|object $item
	 * @throws InstanceNotMatchException
	 */
	public function push($item): void;

	/**
	 *
	 */
	public function empty(): void;


	/**
	 * @return mixed
	 */
	public function getCurrent();

	/**
	 * @return object
	 */
	public function getLastItem();

	/**
	 * @return object
	 */
	public function getFirstItem();

	/**
	 * @param int $iterator
	 * @return ListProvider
	 */
	public function setIterator(int $iterator): ListProvider;

	/**
	 * @return array
	 */
	public function getItems(): array;

	/**
	 * @return int
	 */
	public function getSize(): int;

	/**
	 * @param mixed $key
	 * @return bool
	 */
	public function remove($key): bool;
}