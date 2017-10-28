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
use DateTime;
use Envi\Immutable\Immutable;
use Envi\Immutable\ImmutableInstance;
use PHPUnit\Framework\TestCase;

/**
 * Class ImmutableTest
 *
 * @package    Envi
 * @subpackage Immutable
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  Suzunone 2017
 * @license    BSD 2-Clause License
 * @link       https://github.com/suzunone/ImmutablePHP
 * @see        https://github.com/suzunone/ImmutablePHP
 * @sinse Class available since Release 1.0.0
 * @covers \Envi\Immutable\ImmutableManager
 */
class ImmutableTest extends TestCase
{
    /**
     * @covers \Envi\Immutable\Immutable::freeze()
     * @expectedException \ErrorException
     */
    public function test_freeze_error()
    {
        Immutable::freeze('aaaaa');
    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__construct
     * @expectedException \ErrorException
     */
    public function test_ImmutableInstance_error()
    {
        new ImmutableInstance('aaaaa');
    }

    /**
     * @covers \Envi\Immutable\ImmutableInstance::__construct
     * @covers \Envi\Immutable\Immutable::freeze
     */
    public function test_ImmutableInstance_array()
    {
        $instance = Immutable::freeze(['aaa' => 'aaa']);
        $this->assertInstanceOf(ImmutableInstance::class, $instance);
        $this->assertEquals('aaa', $instance->aaa);
    }


    /**
     * @covers \Envi\Immutable\ImmutableInstance::__isset
     * @covers \Envi\Immutable\Immutable::freeze
     */
    public function test_Example1Class()
    {
        $ExampleClass = new \Examples\Example1Class();

        /**
         * @var \Examples\Example1Class $ExampleClass2
         */
        $ExampleClass2 = Immutable::freeze($ExampleClass, \Examples\ImmutableInstance::class);

        $this->assertInstanceOf(\Examples\ImmutableInstance::class, $ExampleClass2);
        $this->assertInstanceOf(ImmutableInstance::class, $ExampleClass2);
    }


    /**
     * @covers \Envi\Immutable\Immutable::freeze()
     * @covers \Envi\Immutable\Immutable::thaw()
     */
    public function test_Carbon_freeze_thaw()
    {
        $Carbon = new Carbon();

        // スナップショットを作成するため、オブジェクトのアドレスは違うアドレスになる
        $this->assertNotSame($Carbon, Immutable::thaw(Immutable::freeze($Carbon)));
        $this->assertEquals($Carbon, Immutable::thaw(Immutable::freeze($Carbon)));

    }

    /**
     * @covers \Envi\Immutable\Immutable::isImmutable()
     */
    public function test_Carbon_freeze_isImmutable()
    {
        $Carbon = new Carbon();


        // isImmutableのテスト
        $this->assertTrue(Immutable::isImmutable(Immutable::freeze($Carbon)));
        $this->assertFalse(Immutable::isImmutable($Carbon));
        $this->assertFalse(Immutable::isImmutable(Immutable::thaw(Immutable::freeze($Carbon))));
    }

    /**
     * @covers \Envi\Immutable\Immutable::instanceOf()
     */
    public function test_Carbon_instanceOf()
    {
        $Carbon = new Carbon();

        $this->assertTrue(Immutable:: instanceOf (Immutable::freeze($Carbon), Carbon::class));
        $this->assertTrue(Immutable:: instanceOf ($Carbon, Carbon::class));
        $this->assertTrue(Immutable:: instanceOf (Immutable::thaw(Immutable::freeze($Carbon)), Carbon::class));

        $this->assertTrue(Immutable:: instanceOf ($Carbon, DateTime::class));
        $this->assertTrue(Immutable:: instanceOf (Immutable::freeze($Carbon), DateTime::class));
        $this->assertTrue(Immutable:: instanceOf (Immutable::thaw(Immutable::freeze($Carbon)), DateTime::class));

    }

    /**
     * @covers \Envi\Immutable\Immutable::instanceName()
     */
    public function test_Carbon_instanceName()
    {
        $Carbon = new Carbon();
        $Carbon2 = Immutable::freeze($Carbon);
        $Carbon3 = Immutable::thaw($Carbon2);


        $this->assertEquals(Carbon::class, Immutable::instanceName($Carbon));
        $this->assertEquals(Carbon::class, Immutable::instanceName($Carbon2));
        $this->assertEquals(Carbon::class, Immutable::instanceName($Carbon3));

    }

}
