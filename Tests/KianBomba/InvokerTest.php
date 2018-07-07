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
    public function provideEmailData(): array
    {
        return array(
            array("kianbomba@gmail.com", true),
            array("kian.bomba@abcs.co.nz", true),
            array("bomba+hello@hotmail.fr", true),
            array("bomba@hotmail.co.uk", true),
            array("bomba&6@gmail.com", true),
            array("bomba@yahoo.com.vn.a.ab", true),
            array("kianbomba@@gmail.com", false),
        );
    }

    /**
     * @dataProvider provideEmailData
     * @param string $email
     * @param bool $result
     */
    public function testIsEmail(string $email, bool $result): void
    {
        $invoker = Invoker::getInstance();
        $this->assertEquals($result, $invoker->isEmail($email));
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


    public function testIsValueTrue(): void
    {
        $this->assertTrue(Invoker::getInstance()->isTrue("y"));
    }

    public function testEmailFilter(): void
    {
        $expeceted = "kianbomba@gmail.com";
        $this->assertEquals($expeceted, Invoker::getInstance()->emailFilter($expeceted));
    }
}
