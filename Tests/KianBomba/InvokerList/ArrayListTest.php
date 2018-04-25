<?php
/**
 * Created by PhpStorm.
 * User: Kianbomba
 * Date: 2/1/2018
 * Time: 11:54 AM
 */

namespace KianBomba\InvokerList;


use KianBomba\Exception\InstanceNotMatchException;
use KianBomba\{TestObject, Test2};
use PHPUnit\Framework\TestCase;

class ArrayListTest extends TestCase
{
	public function __construct(?string $name = null, array $data = [], string $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}


	public function testArrayList(): void
	{
		$container = new ArrayList(TestObject::class);
		try {
			$container->push(new TestObject("Hello World"));
			$container->push(new TestObject("Kian Super Mid"));
			$container->push(new TestObject("Bomba Dude"));
		}
		catch (InstanceNotMatchException $ie)
		{
			echo $ie->getMessage();
		}

		$this->assertEquals("Kian Super Mid", $container->setIterator(1)->getCurrent()->getName());

		$this->assertEquals("Bomba Dude", $container->getLastItem()->getName());

		$this->assertEquals("Hello World", $container->getFirstItem()->getName());

		$this->assertInstanceOf(TestObject::class, $container->getLastItem());

		$this->assertEquals(3, $container->getSize());

		$this->assertFalse($container->isEmpty());
	}

	/**
	 * @throws InstanceNotMatchException
	 */
	public function testCatchException(): void
	{

		$arr = new ArrayList(TestObject::class);
		$this->expectException(InstanceNotMatchException::class);
		$arr->push(new Test2());
	}

	public function testInstance(): void
	{
		$container = new ArrayList("string");

		try {
			$container->push("abde");
			$this->assertTrue(true);
		}
		catch (InstanceNotMatchException $ie)
		{
			echo $ie->getMessage();
			$this->assertFalse(true);
		}
	}

	public function testNumberInstance(): void
	{
		$container = new ArrayList("double");
		try
        {
			$container->push(1.1);
			$this->assertTrue(true);
		}
		catch (InstanceNotMatchException $ie)
		{
			echo $ie->getMessage();
			$this->assertTrue(false);
		}
	}

	public function testInterating(): void
    {
        $testObject1 = new TestObject("kianbomba");
        $testObject2 = new TestObject("kiannguyen");

        $container = new ArrayList(TestObject::class);
        $container->push($testObject1);
        $container->push($testObject2);

        $test = $this;

        $container->each(function(TestObject $item, int $key) use ($test, $testObject1) {
            if ($key == 0) $this->assertEquals($testObject1, $item);
        });
    }

}

