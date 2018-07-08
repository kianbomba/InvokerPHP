<?php

declare(strict_types=1);

namespace KianBomba;

use KianBomba\Exception\InvokerException;

class Invoker
{
	public const ENTITY_NAME = 1;
	public const ENTITY_NUMBER = 2;

	private $translations = array(
		1 => array (
			'&' => "&amp;",
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

	/**
	 * @var Invoker
	 */
	private static $invoker;

	private $defineItems = ["*", "[", "]", "(", ")", "^", "%", "#", "!", "-", "=", "&", "$", "`", "~", "\"", "{", "}", ",", "<", ">", "?", "/", "|", "@", ".", "_", "+"];

	/**
	 * @return Invoker
	 */
	public static function getInstance() {
		if (!isset(self::$invoker)) self::$invoker = new Invoker();

		return self::$invoker;
	}


	/**
	 * @param string $email
	 * @return bool
	 *
	 * @description return true which is email is valid and false otherwise. The method is only useful for the common email
	 * only
	 */
	public function isEmail(string $email): bool
	{
		$checker = filter_var($email, FILTER_VALIDATE_EMAIL);

		if (!$checker) return $checker;

		unset($checker);
		$pattern = "/^[a-zA-Z0-9_.-]+@[a-zA-Z]+.[a-zA-Z]+$/";
		$checker = preg_match($pattern, $email);

		if (!is_int($checker)) return false;

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
	 * @param bool $noStrict
	 * @return string
	 */
	public function stringFilter($haystack, bool $noStrict = false): string
	{
		if (!is_string($haystack) || is_null($haystack)) return "";

		if (!$noStrict)
		{
			$regex = "/[^a-zA-Z0-9._\-: ]/";

			$sanitized = preg_replace($regex, '', $haystack);
			return $sanitized;
		}

		try 
		{
			$regex = "/[^a-zA-Z0-9._\-:&#@;\\n\\t~!`$%^*(){}\[\]<>?\/=\+ ]/";
			$haystack = $this->encodeSpecialChars($haystack);
			$haystack = strip_tags($haystack);

			return preg_replace($regex, '', $haystack);
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
	public function encodeSpecialChars(string $haystack, int $entityType = self::ENTITY_NAME): string
	{
		if (!isset($this->translations[$entityType]))
		{
			throw new InvokerException("No entity type found for key {$entityType}");
		}

		$translations = $this->translations[$entityType];

		foreach ($translations as $i => $key)
		{
			$haystack = str_replace($i, $key, $haystack);
		}

		return $haystack;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function isValidName($name): bool
	{
		if (is_null($name) || !is_string($name)) return false;

		for ($i = 0; $i < count($this->defineItems);$i++)
		{
			if (stripos($name, $this-> gdefineItems[$i]) !== false) return false;
		}

		return true;
	}

    /**
     * @param $value
     * @return bool
     */
	public function isTrue($value): bool
    {
        if (is_null($value)) return false;
        if (is_bool($value)) return $value;

        return in_array(strtolower($value), ["y", "yes", "1", 1, "true"]);
    }

    /**
     * @param string $email
     * @return string
     */
    public function emailFilter($email): string
    {
        return (string) filter_var($email, FILTER_SANITIZE_EMAIL, array('options' => ['default' => ""]));
    }

    /**
     * @param array $data
     * @param callable $callback
     *
     * - the callback method to iterate the array of object
     */
    public function each(array $data, callable $callback ): void
    {
        if (!is_callable($callback)) return;

        foreach ($data as $key => $value)
        {
            $callback($value, $key);
        }
    }
}
