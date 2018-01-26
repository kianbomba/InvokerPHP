<?php

declare(strict_types=1);

namespace KianBomba;

use KianBomba\Exception\InvokerException;

class Invoker
{
	public const ENTITY_NAME = 1;
	public const ENTITY_NUMBER = 2;

	private $_translations = array(
		1 => array (
			'&' => "&amp;",
			' ' => "&nbsp;",
			'<' => "&lt;",
			'>' => "&gt;",
			'"' => "&quot;",
			'\'' => "&apos;",
			'¢' => "&cent;",
			'£' => "&pound;",
			'¥' => "&yen;",
			'€' => "&euro;",
			'©' => "&copy;",
			'®' => "&reg;",
		),
		2 => array (
			'&' => "&#38;",
			' ' => "&#160;",
			'<' => "&#60;",
			'>' => "&#62;",
			'"' => "&#34;",
			'\'' => "&#39;",
			'¢' => "&#162;",
			'£' => "&#163;",
			'¥' => "&#165;",
			'€' => "&#8364;",
			'©' => "&#169;",
			'®' => "&#174;",
		)
	);

	private static $_invoker;

	private $_defineItems = ["*", "[", "]", "(", ")", "^", "%", "#", "!", "-", "=", "+", "&", "$", "`", "~", " ", "{", "}", ",", "<", ">", "?", "/", "|"];

	/**
	 * @return Invoker
	 */
	public static function getInstance() {
		if (!isset(self::$_invoker)) self::$_invoker = new Invoker();

		return self::$_invoker;
	}

	/**
	 * Invoker constructor.
	 */
	private function __construct() {}

	/**
	 * @param string $email
	 * @return bool
	 *
	 * @description return true which is email is valid and false otherwise
	 */
	public function isEmail(string $email): bool
	{
		$checker = filter_var($email, FILTER_VALIDATE_EMAIL);

		if (!$checker) return $checker;

		unset($checker);
		$pattern = "/^[a-zA-Z0-9_.-]+@[a-zA-Z]+.[a-zA-Z]+$/";
		$checker = preg_match($pattern, $email);

		if (!is_int($checker)) return false;

		unset($checker);
		$count = substr_count($email, ".");
		if ($count > 2) return false;

		for ($i = 0; $i < count($this->_defineItems); $i++)
		{
			if (stripos($email, $this->_defineItems[$i]) !== false) return false;
		}

		return true;
	}

	/**
	 * @param int $number
	 * @return int
	 */
	public function numberFilter($number): int
	{
		if (!is_numeric($number)) return 0;

		return (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT, ['options' => array ('default' => 0)]);
	}

	/**
	 * @param float $number
	 * @return float
	 */
	public function floatFilter($number): float
	{
		if (!is_numeric($number)) return 0;

		return (float) filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT, ['options' => array('default' => 0)]);
	}

	/**
	 * @param string $haystack
	 * @param bool $encodeSpecialChars
	 * @return string
	 */
	public function stringFilter($haystack, bool $encodeSpecialChars = false): string
	{
		if (!is_string($haystack) || is_null($haystack)) return "";

		if (!$encodeSpecialChars) return preg_replace( '/[^a-zA-Z0-9._\-: ]/', '', $haystack);

		try {
			$haystack = $this->encodeSpecialChars($haystack);

			return preg_replace( '/[^a-zA-Z0-9._\-:&#; ]/', '', $haystack);
		}
		catch (InvokerException $ie)
		{
			return preg_replace( '/[^a-zA-Z0-9._\-: ]/', '', $haystack);
		}
	}

	/**
	 * @param string $haystack
	 * @param int $entityType
	 * @return string
	 *
	 *
	 * @throws InvokerException
	 */
	public function encodeSpecialChars(string $haystack, int $entityType = Invoker::ENTITY_NAME): string
	{
		if (!isset($this->_translations[$entityType]))
		{
			throw new InvokerException("No entity type found for key {$entityType}");
		}

		$translations = $this->_translations[$entityType];

		foreach ($translations as $i => $key)
		{
				$haystack = str_replace($i, $key, $haystack);
		}

		unset($translations);
		return $haystack;
	}
}