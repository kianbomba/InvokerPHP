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
	 * @param Object $item
	 * @throws InstanceNotMatchException
	 */
	public function push($item): void;

	/**
	 *
	 */
	public function empty(): void;

	/**
	 * @param int $index
	 * @return mixed
	 */
	public function getItem(int $index);
}