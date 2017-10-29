<?php
/**
 * @package    %%project_name%%
 * @subpackage %%subpackage_name%%
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @link       %%your_link%%
 * @see        %%your_see%%
 * @sinse Class available since Release 1.0.0
 */

namespace Immutable\Test;

use Immutable\Immutable;
use Immutable\ImmutableElement;
use PHPUnit\Framework\TestCase;

/**
 * Class ImmutableElementTest
 *
 * @package Immutable\Test
 * @subpackage %%subpackage_name%%
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @link       %%your_link%%
 * @see        %%your_see%%
 * @sinse Class available since Release 1.0.0
 * @covers \Immutable\ImmutableManager
 * @covers \Immutable\ImmutableInterface
 */
class ImmutableElementTest extends TestCase
{

    /**
     * @covers \Immutable\ImmutableElement
     * @covers \Immutable\Immutable::freeze
     */
    public function test_ImmutableInstance_array()
    {
        $instance = Immutable::freeze(['aaa' => 'aaa']);
        $this->assertInstanceOf(ImmutableElement::class, $instance);
        $this->assertEquals('aaa', $instance->aaa);

        $this->assertSame(['aaa' => 'aaa'], Immutable::thaw($instance));

        $instance2 = $instance->put('bbb', 'bbb')->put('aaa', 'aaa1')->put('aaa', 'aaa2');
        $this->assertSame(['aaa' => 'aaa'], Immutable::thaw($instance));
        $this->assertSame(['aaa' => 'aaa2', 'bbb' => 'bbb'], Immutable::thaw($instance2));

        $instance3 = $instance2->set('bbb', 'bbb2');
        $this->assertSame(['aaa' => 'aaa2', 'bbb' => 'bbb2'], Immutable::thaw($instance3));

        $this->assertFalse(isset($instance2->undefined));
    }

    /**
     * @covers \Immutable\ImmutableElement
     * @covers \Immutable\Immutable::freezeRecursive()
     * @covers \Immutable\Immutable::thaw()
     */
    public function test_ImmutableRecursive_simple()
    {
        $test_arr = [
            range(1, 10),
            range(11, 20),
            range(21, 30),
            range(31, 40),
        ];

        $res = Immutable::freezeRecursive($test_arr);

        $this->assertEquals(1, $res->get(0)->get(0));
        $this->assertEquals(2, $res->get(0)->get(1));
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $res->get(0));

    }

    /**
     * @covers \Immutable\ImmutableElement
     * @covers \Immutable\Immutable::freezeRecursive()
     * @covers \Immutable\Immutable::thaw()
     */
    public function test_ImmutableRecursive_stdClass()
    {
        $faker = \Faker\Factory::create('ja');

        $test_class = new \stdClass();
        $test_arr = [];
        for ($i = 0; $i < 50; $i++) {
            $user = new \stdClass();
            $user->name = $faker->name ;
            $user->address = $faker->address ;
            $user->userName = $faker->userName ;
            $user->password = $faker->password ;
            $user->email = $faker->email ;
            $user->phoneNumber = $faker->phoneNumber ;
            $user->date = $faker->date($format = 'Y-m-d', $max = 'now') ;
            $user->creditCardNumber = $faker->creditCardNumber ;
            $user->regexify = $faker->regexify('[1-9]{3}-[0-9]{4}');
            $item = new \stdClass;
            $item->user = $user;
            $item->array = range(mt_rand(0, 100), mt_rand(50, 200));
            $test_class->$i = $item;
            $test_arr[] = $item;
        }
        $test_arr_2 = Immutable::freezeRecursive($test_arr);
        $test_class_2 = Immutable::freezeRecursive($test_class);
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_arr_2);
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_class_2);
    }

    /**
     * @covers \Immutable\ImmutableElement
     * @covers \Immutable\Immutable::freezeRecursive()
     * @covers \Immutable\Immutable::thaw()
     * @small
     */
    public function test_ImmutableRecursive_CircularReference_class()
    {
        $faker = \Faker\Factory::create('ja');

        $test_class = new \stdClass();
        for ($i = 0; $i < 50; $i++) {
            $user = new \stdClass();
            $user->name = $faker->name ;
            $user->address = $faker->address ;
            $user->userName = $faker->userName ;
            $user->password = $faker->password ;
            $user->email = $faker->email ;
            $user->phoneNumber = $faker->phoneNumber ;
            $user->date = $faker->date($format = 'Y-m-d', $max = 'now') ;
            $user->creditCardNumber = $faker->creditCardNumber ;
            $user->regexify = $faker->regexify('[1-9]{3}-[0-9]{4}');
            $item = new \stdClass;
            $item->user = $user;
            $item->array = range(mt_rand(0, 100), mt_rand(50, 200));

            // 循環参照
            $item->test_class = $test_class;

            $test_class->$i = $item;
        }
        $test_class_2 = Immutable::freezeRecursive($test_class, []);
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_class_2);

        // 再帰的なinstance変更の確認
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_class_2->get(0));
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_class_2->get(0)->test_class);
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_class_2->get(0)->test_class->get(0));

        // 値が維持されているか確認
        $this->assertEquals($test_class_2->get(0)->test_class->get(0)->user->name, $test_class_2->get(0)->user->name);

        // 循環参照の場合、参照を維持する
        $this->assertSame($test_class_2, $test_class_2->get(0)->test_class);


        $test_class_thaw = Immutable::thaw($test_class_2);

        $i = 0;
        $this->assertEquals($test_class->$i->user->name, $test_class_2->get(0)->user->name);

        // すでにImmmutableの場合
        $this->assertSame($test_class_2, Immutable::freezeRecursive($test_class_2));

    }


    /**
     * @covers \Immutable\ImmutableElement
     * @covers \Immutable\Immutable::freezeRecursive()
     * @covers \Immutable\Immutable::thaw()
     * @small
     */
    public function test_ImmutableRecursive_CircularReference_array()
    {
        $faker = \Faker\Factory::create('ja');

        $test_arr = [];
        for ($i = 0; $i < 50; $i++) {
            $user = new \stdClass();
            $user->name = $faker->name ;
            $user->address = $faker->address ;
            $user->userName = $faker->userName ;
            $user->password = $faker->password ;
            $user->email = $faker->email ;
            $user->phoneNumber = $faker->phoneNumber ;
            $user->date = $faker->date($format = 'Y-m-d', $max = 'now') ;
            $user->creditCardNumber = $faker->creditCardNumber ;
            $user->regexify = $faker->regexify('[1-9]{3}-[0-9]{4}');
            $item = new \stdClass;
            $item->user = $user;
            $item->array = range(mt_rand(0, 100), mt_rand(50, 200));

            // 循環参照
            $item->item = $item;

            $test_arr[] = $item;
        }
        $i--;

        $test_arr_2 = Immutable::freezeRecursive($test_arr, []);
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_arr_2);

        // 再帰的なinstance変更の確認
        $this->assertInstanceOf(\Immutable\ImmutableElement::class, $test_arr_2->get($i)->item);

        // 値が維持されているか確認
        $this->assertEquals($user->name, $test_arr_2->get($i)->user->name);

        // 循環参照の場合、参照を維持する
        $this->assertSame($test_arr_2->get($i), $test_arr_2->get($i)->item);


        $test_arr_thaw = Immutable::thaw($test_arr_2);

        $this->assertEquals($test_arr_thaw[0]->user->name, $test_arr_2->get(0)->user->name);


    }


    /**
     * @covers \Immutable\ImmutableElement
     * @covers \Immutable\Immutable::freezeRecursive()
     * @covers \Immutable\Immutable::thaw()
     * @expectedException \ErrorException
     */
    public function test_ImmutableRecursive_CircularReference_error()
    {
        $faker = \Faker\Factory::create('ja');

        $test_class = new \stdClass();
        for ($i = 0; $i < 50; $i++) {
            $user = new \stdClass();
            $user->name = $faker->name ;
            $user->address = $faker->address ;
            $user->userName = $faker->userName ;
            $user->password = $faker->password ;
            $user->email = $faker->email ;
            $user->phoneNumber = $faker->phoneNumber ;
            $user->date = $faker->date($format = 'Y-m-d', $max = 'now') ;
            $user->creditCardNumber = $faker->creditCardNumber ;
            $user->regexify = $faker->regexify('[1-9]{3}-[0-9]{4}');
            $item = new \stdClass;
            $item->user = $user;
            $item->array = range(mt_rand(0, 100), mt_rand(50, 200));

            $test_class->$i = $item;
        }

        // 参照制限に引っかかった場合、エラーとなる
        Immutable::freezeRecursive($test_class, [], 1);
    }

    /**
     * @covers  \Immutable\ImmutableElement
     * @covers  \Immutable\Immutable::freeze
     */
    public function test_stdClass()
    {
        $std = new \stdClass();
        $faker = \Faker\Factory::create('ja');

        // ダミーの値を入れる
        $std->name = $faker->name;
        $dummy_name = $std->name;

        // スナップショットを作成するため、オブジェクトのアドレスは違うアドレスになる
        $this->assertNotSame($std, Immutable::thaw(Immutable::freeze($std)));
        $this->assertEquals($std, Immutable::thaw(Immutable::freeze($std)));

        $std2 = Immutable::freeze($std);
        $this->assertInstanceOf(ImmutableElement::class, $std2);

        $this->assertEquals($dummy_name, $std2->name);
        $this->assertEquals($std->name, $std2->name);

        $std2->name = $faker->name;
        $this->assertEquals($dummy_name, $std2->name);
        $this->assertEquals($std->name, $std2->name);

        $std2->name = $faker->name;
        $this->assertEquals($std->name, $std2->name);

    }
}
