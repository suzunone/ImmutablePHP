<?php
/**
 * @package    Envi
 * @subpackage Immutable
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  Suzunone 2017
 * @license    BSD 2-Clause License
 * @link       https://github.com/suzunone/ImmutablePHP
 * @see        https://github.com/suzunone/ImmutablePHP
 * @sinse Class available since Release 1.0.0
 */

namespace Envi\Immutable\Test;

use Carbon\Carbon;
use Envi\Immutable\Immutable;
use PHPUnit\Framework\TestCase;

/**
 * Class ImmutableInstanceTest
 *
 * @package    Envi
 * @subpackage Immutable
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  Suzunone 2017
 * @license    BSD 2-Clause License
 * @link       https://github.com/suzunone/ImmutablePHP
 * @see        https://github.com/suzunone/ImmutablePHP
 * @sinse Class available since Release 1.0.0
 */
class ImmutableInstanceTest extends TestCase
{
    /**
     * @covers \Envi\Immutable\ImmutableInstance::__construct()
     * @covers \Envi\Immutable\ImmutableInstance::__invoke()
     */
    public function test_InvokeClass()
    {
        $ExampleInvokeClass = new \Examples\ExampleInvokeClass();

        /**
         * @var \Examples\ExampleInvokeClass $ExampleInvokeClass2
         */
        $ExampleInvokeClass2 = Immutable::freeze($ExampleInvokeClass);

        $res = $ExampleInvokeClass2();
        $this->assertEquals([], $ExampleInvokeClass->param);
        $this->assertEquals([], $ExampleInvokeClass2->param);
        $this->assertEquals(0, $res);


        $res = $ExampleInvokeClass2(10, false);
        $this->assertEquals([], $ExampleInvokeClass->param);
        $this->assertEquals([], $ExampleInvokeClass2->param);
        $this->assertEquals(10 * 10 * 10, $res);

        /**
         * @var \Examples\ExampleInvokeClass $res2
         */
        $res2 = $ExampleInvokeClass2(10, true);
        $this->assertEquals([], $ExampleInvokeClass->param);
        $this->assertEquals([], $ExampleInvokeClass2->param);
        $this->assertEquals([10, true], $res2->param);
    }


    /**
     * @covers \Envi\Immutable\ImmutableInstance::__isset
     */
    public function test_Example1Class_isset()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        // isset emptyのテスト
        $this->assertTrue(isset($ExampleClass2->public_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertTrue(empty($ExampleClass2->protected_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertTrue(empty($ExampleClass2->private_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertTrue(empty($ExampleClass2->undefined_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);


        $this->assertFalse(empty($ExampleClass2->public_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertFalse(isset($ExampleClass2->protected_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertFalse(isset($ExampleClass2->private_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertFalse(isset($ExampleClass2->undefined_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);
    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__isset
     */
    public function test_Example2Class_isset()
    {
        $ExampleClass = new \Examples\Example2Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        // isset emptyのテスト
        $this->assertTrue(isset($ExampleClass2->public_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertTrue(empty($ExampleClass2->protected_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertTrue(empty($ExampleClass2->private_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertTrue(empty($ExampleClass2->undefined_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);


        $this->assertFalse(empty($ExampleClass2->public_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertFalse(isset($ExampleClass2->protected_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertFalse(isset($ExampleClass2->private_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

        $this->assertFalse(isset($ExampleClass2->undefined_property));
        $this->assertEmpty($ExampleClass2->isset_property);
        $this->assertEmpty($ExampleClass->isset_property);

    }


    /**
     * @covers \Envi\Immutable\ImmutableInstance::__unset
     */
    public function test_Example1Class_unset()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        unset($ExampleClass2->public_property);
        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass->get_property);
        $this->assertNull($ExampleClass->set_property);
        $this->assertNull($ExampleClass->call_property);
        $this->assertNull($ExampleClass->unset_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

        unset($ExampleClass2->protected_property);
        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass->get_property);
        $this->assertNull($ExampleClass->set_property);
        $this->assertNull($ExampleClass->call_property);
        $this->assertNull($ExampleClass->unset_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

        unset($ExampleClass2->undefined_property);
        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass->get_property);
        $this->assertNull($ExampleClass->set_property);
        $this->assertNull($ExampleClass->call_property);
        $this->assertNull($ExampleClass->unset_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__unset
     * @expectedException \ErrorException
     */
    public function test_Example1Class_unset_error()
    {
        $ExampleClass = new \Examples\Example2Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        unset($ExampleClass2->public_property);
        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass->get_property);
        $this->assertNull($ExampleClass->set_property);
        $this->assertNull($ExampleClass->call_property);
        $this->assertNull($ExampleClass->unset_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);


        unset($ExampleClass2->undefined_property);

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__call
     */
    public function test_Example1Class__call()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        $this->assertTrue($ExampleClass2->runPublic());

        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass->get_property);
        $this->assertNull($ExampleClass->set_property);
        $this->assertNull($ExampleClass->call_property);
        $this->assertNull($ExampleClass->unset_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);


        $this->assertSame($ExampleClass->runPublic(), $ExampleClass2->runPublic());
        $this->assertSame($ExampleClass->runPrivate(), $ExampleClass2->runPrivate());
        $this->assertSame($ExampleClass->runProtected(), $ExampleClass2->runProtected());
        $this->assertSame($ExampleClass->runUndefined(), $ExampleClass2->runUndefined());


    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__call
     * @expectedException \ErrorException
     */
    public function test_Example1Class__call_error()
    {
        $ExampleClass = new \Examples\Example2Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        $this->assertTrue($ExampleClass2->runPublic());

        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass->get_property);
        $this->assertNull($ExampleClass->set_property);
        $this->assertNull($ExampleClass->call_property);
        $this->assertNull($ExampleClass->unset_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);


        $ExampleClass2->runUndefined();

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__get()
     */
    public function test_Example1Class_get()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

        $this->assertEquals($ExampleClass->protected_property, $ExampleClass2->protected_property);
        $this->assertEquals(['protected_property' => 'protected_property'], $ExampleClass->protected_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

        $this->assertEquals($ExampleClass->undefined_property, $ExampleClass2->undefined_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);
    }


    /**
     * @covers \Envi\Immutable\ImmutableInstance::__get()
     * @expectedException \ErrorException
     */
    public function test_Example2Class_get()
    {
        $ExampleClass = new \Examples\Example2Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

        $res = $ExampleClass2->undefined_property;
    }


    /**
     * @covers \Envi\Immutable\ImmutableInstance::__set()
     */
    public function test_Example1Class_set()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        $ExampleClass2->public_property = 123456789;

        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

        $ExampleClass2->protected_property = 1234567;
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);

        $ExampleClass2->undefined_property = 1234567;
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);
    }


    /**
     * @covers \Envi\Immutable\ImmutableInstance::__set()
     */
    public function test_Example2Class_set()
    {
        $ExampleClass = new \Examples\Example2Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);
        $ExampleClass2->public_property = 123456789;

        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);


    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__set()
     * @expectedException \ErrorException
     */
    public function test_Example2Class_set_error()
    {
        $ExampleClass = new \Examples\Example2Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);
        $ExampleClass2->undefined_property = 123456789;

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance
     */
    public function test_Example1Class__debugInfo()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        ob_start();
        var_dump($ExampleClass2);
        $contents = ob_get_contents();
        ob_end_clean();

        $this->assertRegExp('/mutable_instance/', $contents);
        $this->assertRegExp('/protected/', $contents);
        $this->assertRegExp('/Example1Class/', $contents);
    }
    
    /**
     * @covers \Envi\Immutable\ImmutableInstance::__set_state()
     */
    public function test_Example1Class__set_state()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        //ob_start();
        $export1 = var_export($ExampleClass, true);
        $export2 = var_export($ExampleClass2, true);

        /**
         * @var \Examples\Example1Class $ExampleClass_1
         */
        eval('$ExampleClass_1 = ' . $export1 . ';');

        /**
         * @var \Examples\Example1Class $ExampleClass2_1
         */
        eval('$ExampleClass2_1 = ' . $export2 . ';');


        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertEquals($ExampleClass->public_property, $ExampleClass_1->public_property);
        $this->assertEquals($ExampleClass->public_property, $ExampleClass2_1->public_property);

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__toString()
     */
    public function test_Example1Class_toString()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        $this->assertEquals((string)$ExampleClass, (string)$ExampleClass2);

        $this->assertEquals($ExampleClass->public_property, $ExampleClass2->public_property);
        $this->assertNull($ExampleClass2->get_property);
        $this->assertNull($ExampleClass2->set_property);
        $this->assertNull($ExampleClass2->call_property);
        $this->assertNull($ExampleClass2->unset_property);
    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__sleep()
     * @expectedException \ErrorException
     */
    public function test_Example1Class_sleep()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass);

        serialize($ExampleClass2);

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance
     */
    public function test_Carbon()
    {
        $Carbon = new Carbon();

        /**
         * @var Carbon $Carbon2
         */
        $Carbon2 = Immutable::freeze($Carbon);


        // 生成されたオブジェクトは基本的に同じ
        $this->assertEquals($Carbon->format('Y-m-d H:i:s'), $Carbon2->format('Y-m-d H:i:s'));


        // Immutable化すると、元のオブジェクトとは関係なくなる
        $Carbon->nextWeekday();
        $this->assertNotEquals($Carbon2->format('Y-m-d H:i:s'), $Carbon->format('Y-m-d H:i:s'));

        /**
         * @var Carbon $Carbon3
         */
        $Carbon3 = $Carbon2->nextWeekday();

        // メソッドチェーンできるMethodの場合は、新しいオブジェクトが生成される
        $this->assertNotEquals($Carbon2->format('Y-m-d H:i:s'), $Carbon3->format('Y-m-d H:i:s'));
        $this->assertEquals($Carbon->format('Y-m-d H:i:s'), $Carbon3->format('Y-m-d H:i:s'));
        $Carbon->nextWeekday();
        $this->assertNotEquals($Carbon->format('Y-m-d H:i:s'), $Carbon3->format('Y-m-d H:i:s'));


    }


    /**
     * @covers \Envi\Immutable\ImmutableInstance
     */
    public function test_stdClass()
    {
        $std = new \stdClass();
        $faker = \Faker\Factory::create('ja');

        // ダミーの値を入れる
        $std->name = $faker->name;

        // スナップショットを作成するため、オブジェクトのアドレスは違うアドレスになる
        $this->assertNotSame($std, Immutable::thaw(Immutable::freeze($std)));
        $this->assertEquals($std, Immutable::thaw(Immutable::freeze($std)));

        $std2 = Immutable::freeze($std);

        $this->assertEquals($std->name, $std2->name);

        $std2->name = $faker->name;
        $this->assertEquals($std->name, $std2->name);

        $std2->name = $faker->name;
        $this->assertEquals($std->name, $std2->name);

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance
     * @expectedException \ErrorException
     */
    public function test_stdClass_getError()
    {
        $std = new \stdClass();

        $std2 = Immutable::freeze($std);

        $this->assertEmpty($std2->undefined_property);

    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance
     * @expectedException \ErrorException
     */
    public function test_stdClass_setError()
    {
        $std = new \stdClass();

        $std2 = Immutable::freeze($std);
        $faker = \Faker\Factory::create('ja');
        $std2->undefined_property = $faker->name;

        $this->assertEmpty($std2->undefined_property);

    }
}
