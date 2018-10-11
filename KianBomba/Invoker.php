<?php

declare(strict_types=1);

namespace KianBomba;

use KianBomba\Exception\InvokerException;

/**
 * Just a small library which is quite handy for most of the stuff
 * @package KianBomba
 */
class Invoker
{
	public const ENTITY_NAME = 1;
	public const ENTITY_NUMBER = 2;

	private $translations = array(
		1 => array (
			'&' => "&amp;",
			'¢' => "&cent;",
			'£' => "&pound;",
			'¥' => "&yen;",
			'€' => "&euro;",
			'©' => "&copy;",
			'®' => "&reg;",
		),
		2 => array (
			'&' => "&#38;",
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

	/**
	 * An array of the special characters
	 * @var string[]
	 */
	private $defineItems = ["*", "[", "]", "(", ")", "^", "%", "#", "!", "-", "=", "&", "$", "`", "~", "\"", "{", "}", ",", "<", ">", "?", "/", "|", "@", ".", "_", "+"];

	/**
	 * @return Invoker
	 */
	public static function getInstance() {
		if (!isset(self::$invoker)) {
			self::$invoker = new Invoker();
		}

		return self::$invoker;
	}


	/**
	 * Return true which is email is valid and false otherwise. The method is only useful for the 
	 * common email only
	 * 
	 * @param string $email
	 * @return bool
	 */
	public function isEmail(string $email): bool {
		$checker = filter_var($email, FILTER_VALIDATE_EMAIL);

		if (!$checker) {
			return $checker;
		}

		$pattern = "/^[a-zA-Z0-9_.-]+@[a-zA-Z]+.[a-zA-Z]+$/";
		$checker = preg_match($pattern, $email);

		if (!is_int($checker)) {
			return false;
		}

		return true;
	}

	/**
	 * @param int $number
	 * @return int
	 */
	public function numberFilter($number): int {
		if (!is_numeric($number)) {
			return 0;
		}

		return (int) filter_var($number, FILTER_SANITIZE_NUMBER_INT, ['options' => array ('default' => 0)]);
	}

	/**
	 * @param float $number
	 * @return float
	 */
	public function floatFilter($number): float {
		if (!is_numeric($number)) {
			return 0;
		}

		return (float) filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT,
            array(
                'options' => array('default' => 0),
                'flags' => FILTER_FLAG_ALLOW_FRACTION
            )
        );
	}

	/**
	 * @param string $haystack
	 * @param bool $noStrict
	 * @return string
	 */
	public function stringFilter($haystack, bool $noStrict = false): string {
		if (!is_string($haystack) || is_null($haystack)) {
			return "";
		}

		if (!$noStrict) {
			$regex = "/[^a-zA-Z0-9._\-: ]/";

			$sanitized = preg_replace($regex, '', $haystack);
			return $sanitized;
		}

		$regex = "/[^\\a-zA-Z0-9._\-:&#@;~!`$%^*(){}\[\]<>?\/=\+| ]/";
		$haystack = strip_tags($haystack);

		// Replacing all the new line here to just a normal new line, and the tab to just
		// a normal tab here. Data from HTTP is so weird man
        $haystack = str_replace("\\n", "\n", $haystack);
        $haystack = str_replace("\\t", "\t", $haystack);
		return preg_replace($regex, '', $haystack);	
	}

	/**
	 * @param string $haystack
	 * @param int $entityType
	 * @return string
	 * @throws InvokerException
	 * @deprecated Since Invoker 0.1.9
	 */
	public function encodeSpecialChars(string $haystack, int $entityType = self::ENTITY_NAME): string {
		if (!isset($this->translations[$entityType])) {
			throw new InvokerException("No entity type found for key {$entityType}");
		}

		$translations = $this->translations[$entityType];

		foreach ($translations as $i => $key) {
			$haystack = str_replace($i, $key, $haystack);
		}

		return $haystack;
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function isValidName($name): bool {
		if (is_null($name) || !is_string($name)) {
			return false;
		}

		for ($i = 0; $i < count($this->defineItems);$i++) {
			if (stripos($name, $this-> gdefineItems[$i]) !== false) {
				return false;
			}
		}

		return true;
	}

    /**
     * @param $value
     * @return bool
     */
	public function isTrue($value): bool {
        if (is_null($value)) {
        	return false;
        }

        if (is_bool($value)) {
        	return $value;
		}
        return in_array(strtolower((string) $value), ["y", "yes", "1", "true"]);
    }

    /**
     * @param string $email
     * @return string
     */
    public function emailFilter($email): string {
        return (string) filter_var($email, FILTER_SANITIZE_EMAIL, array('options' => ['default' => ""]));
    }

    /**
     * The method that iterates the array of object and using callback to flexible the use of user
     * @param array $data
     * @param callable $callback
     */
    public function each(array $data, callable $callback): void {
        if (!is_callable($callback)) return;

        foreach ($data as $key => $value) {
            $callback($value, $key);
        }
    }
}