<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 1/26/2018
 * Time: 11:28 AM
 */

namespace KianBomba;

use KianBomba\Exception\InvokerException;
use PHPUnit\Framework\TestCase;

class InvokerTest extends TestCase
{
	/**
	 * @test
	 */
	public function testCheckEmailPassCase(): void
	{
		$this->assertTrue(Invoker::getInstance()->isEmail("kianbomba@gmail.com"));
	}

	public function testCheckEmailPassCase2(): void
	{
		$this->assertTrue(Invoker::getInstance()->isEmail("bomba+hello@hotmail.fr"));
	}

	public function testCheckEmailPassCase3(): void
	{
		$this->assertTrue(Invoker::getInstance()->isEmail("bomba@hotmail.co.uk"));
	}

	public function testCheckEmailFailCase(): void
	{
		$this->assertTrue(Invoker::getInstance()->isEmail("bomba&6@gmail.com"));
	}

	public function testCheckEmailFailCase2(): void
	{
		$this->assertFalse(Invoker::getInstance()->isEmail("bomba@yahoo.com.vn.a.ab"));
	}

	public function testStringFilter(): void
	{
		$this->assertEquals("Abcudehuea", Invoker::getInstance()->stringFilter("\"Abcudehuea'"));
	}

	public function testStringFilter1(): void
	{
		$this->assertEquals("abcde", Invoker::getInstance()->stringFilter("&abcde"));
	}

	public function testStringFilter2(): void
	{
		$this->assertEquals("&quot;Abcudehuea&apos;", Invoker::getInstance()->stringFilter("\"Abcudehuea'", true));
	}

	/**
	 * @throws InvokerException
	 */
	public function testEncodingSpecialChar(): void
	{
		$this->assertEquals('&copy;ufjau&amp;91!*@*#', Invoker::getInstance()->encodeSpecialChars("©ufjau&91!*@*#"));
	}

	/**
	 * @throws InvokerException
	 */
	public function testEncodingSpecialChar2(): void
	{
		$this->assertEquals("@&#38;&#62;1jicace", Invoker::getInstance()->encodeSpecialChars("@&>1jicace", Invoker::ENTITY_NUMBER));
	}


    public function testIsValueTrue(): void
    {
        $this->assertTrue(Invoker::getInstance()->isTrue("y"));
    }
}
