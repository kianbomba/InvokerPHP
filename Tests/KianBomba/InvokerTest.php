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

    public function provideStringData(): array
    {
        return array(
            array("Abcudehuea", "\"Abcudehuea", false),
            array("\\\"Abcudehuea\'", "\"Abcudehuea'", true),
            array("hello\nworld\t !! @kian nguyen `name this is it`", "hello\nworld\t !! @kian nguyen `name this is it`", true),
            array("hello world < 5", "hello world < 5", true)
        );
    }

    /**
     * @dataProvider  provideStringData
     * @param string $result
     * @param string $input
     * @param bool $noStrict
     */
    public function testStringFilter(string $result, string $input, bool $noStrict): void
    {
        $invoker = Invoker::getInstance();
        $this->assertEquals($result, $invoker->stringFilter($input, $noStrict));
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
