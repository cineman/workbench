<?php
/**
 * Array helper tests
 **
 * @package             	Cineman/Workbench
 * @author               	Mario Döring
 * @copyright             	2016 Cinergy AG
 *
 * @group Workbench
 * @group Workbench_Arr
 */

namespace Workbench\Tests;

use Workbench\Arr;

class ArrTest extends \PHPUnit_Framework_TestCase
{
    /*
     * an testing array
     */
    public $test_array = array(
        'string' => 'bar',
        'true' => true,
        'false' => true,
        'array' => array(
            'number' => 13,
            'zero' => 0,
            'null' => null,
        ),
    );

    /**
     * CCAr::first
     */
    public function test_first()
    {
        $original_array = $this->test_array;

        $this->assertEquals('bar', Arr::first($this->test_array));

        $this->assertEquals($original_array, $this->test_array);
    }

    /**
     * test array last
     */
    public function testArrayLast()
    {
        $original_array = $this->test_array;

        $this->assertEquals(array(
            'number' => 13,
            'zero' => 0,
            'null' => null,
        ), Arr::last($this->test_array));

        $this->assertEquals($original_array, $this->test_array);
    }

    /**
     * test array push
     */
    public function testArrayPush()
    {
        $array = array('Foo', 'Bar');

        // push
        Arr::push('Batz', $array);

        // test
        $this->assertEquals($array[2], 'Batz');

        // push
        Arr::push(array('Test1', 'Test2'), $array, true);

        // test
        $this->assertEquals(5, count($array));
    }

    /**
     * test array add
     */
    public function testArrayAdd()
    {
        $array = array('foo' => array('bar' => array('test' => 'woo')));

        $array = Arr::add('foo.bar.test', 'jep', $array);

        $this->assertEquals(array('jep'), Arr::get('foo.bar.test', $array));

        $array = Arr::add('foo.bar.test', 'jepp', $array);

        $this->assertEquals(array('jep', 'jepp'), Arr::get('foo.bar.test', $array));
    }

    /**
     * test array push
     *
     * @expectedException        InvalidArgumentException
     */
    public function testArrayPushException()
    {
        $not_an_array = null;

        // push
        Arr::push('Batz', $not_an_array);
    }

    /**
     * test values by key
     */
    public function testArrayPick()
    {
        $array = array(
            array(
                'item' => 'Foo',
                'another' => 'value',
                'data' => array(
                    'age' => 15,
                ),
            ),
            array(
                'item' => 'Bar',
                'nope' => 'test',
                'data' => array(
                    'age' => 32,
                ),
            ),
        );

        // test
        $this->assertEquals(
            Arr::pick('item', $array),
            array(
                0 => 'Foo',
                1 => 'Bar',
            )
        );

        // test multi
        $this->assertEquals(
            Arr::pick('data.age', $array),
            array(
                0 => 15,
                1 => 32,
            )
        );
    }

    /**
     * test values by key
     *
     * @expectedException        InvalidArgumentException
     */
    public function testArrayPickException()
    {
        Arr::pick('test', 'thisIsAnArray');
    }

    /**
     * test if array has multiple dimensions
     */
    public function testArrayIsMulti()
    {
        // test
        $this->assertTrue(Arr::is_multi(array(
            array(
                'name' => 'johnson',
                'age' => 20,
            ),
        )));

        $this->assertTrue(Arr::is_multi(array(
            array(
                'name' => 'johnson',
                'age' => 20,
            ),
            array(
                'name' => 'Jack',
                'age' => 25,
            ),
        )));

        $this->assertTrue(Arr::is_multi(array(
            array(
                'name' => 'johnson',
                'age' => 20,
            ),
            array(
                'name' => 'Jack',
                'age' => 25,
            ),
            'no array valie',
            32,
        )));

        $this->assertFalse(Arr::is_multi(array(
            'jack',
            'john',
            'johnson',
        )));

        $this->assertFalse(Arr::is_multi(array(
            'jack' => 12,
            'john' => 24,
            'johnson' => 32,
        )));
    }

    /**
     * test if array contains other arrays
     */
    public function testArrayIsCollection()
    {
        $this->assertTrue(Arr::is_collection(array(
            array(
                'name' => 'johnson',
                'age' => 20,
            ),
        )));

        $this->assertTrue(Arr::is_collection(array(
            array(
                'name' => 'johnson',
                'age' => 20,
            ),
            array(
                'name' => 'Jack',
                'age' => 25,
            ),
        )));

        $this->assertFalse(Arr::is_collection(array(
            'no array valie',
            array(
                'name' => 'johnson',
                'age' => 20,
            ),
            array(
                'name' => 'Jack',
                'age' => 25,
            ),
        )));

        $this->assertFalse(Arr::is_collection(array(
            'jack',
            'john',
            'johnson',
        )));

        $this->assertFalse(Arr::is_collection(array(
            'jack' => 12,
            'john' => 24,
            'johnson' => 32,
        )));
    }

    /**
     * test sum array values
     */
    public function testArraySum()
    {
        $array = array(
            array(
                'item' => 'Foo',
                'another' => 'value',
                'data' => array(
                    'age' => 15,
                ),
            ),
            array(
                'item' => 'Bar',
                'nope' => 'test',
                'data' => array(
                    'age' => 32,
                ),
            ),
        );

        // test
        $this->assertEquals(
            Arr::sum(array(5, 4, 9)),
            18
        );

        // test
        $this->assertEquals(
            Arr::sum(array(5, '4', 9.0)),
            18
        );

        // test
        $this->assertEquals(
            Arr::sum($array, 'data.age'),
            47
        );
    }

    /**
     * test values by key
     *
     * @expectedException        InvalidArgumentException
     */
    public function testArraySumException()
    {
        Arr::sum('test');
    }

    /**
     * test get average of array values
     */
    public function testArrayAverage()
    {
        $array = array(
            array(
                'item' => 'Foo',
                'another' => 'value',
                'data' => array(
                    'age' => 15,
                ),
            ),
            array(
                'item' => 'Bar',
                'nope' => 'test',
                'data' => array(
                    'age' => 32,
                ),
            ),
        );

        // test
        $this->assertEquals(
            Arr::average(array(5, 4, 9)),
            6
        );

        // test
        $this->assertEquals(
            Arr::average(array(5, '4', 9.0)),
            6
        );

        // test
        $this->assertEquals(
            Arr::average($array, 'data.age'),
            23.5
        );
    }

    /**
     * test values by key
     *
     * @expectedException        InvalidArgumentException
     */
    public function testArrayAverageException()
    {
        Arr::average('test');
    }

    /**
     * create an object of an array
     */
    public function testArrayToObject()
    {
        $object = Arr::object($this->test_array);

        // test if objet
        $this->assertTrue(is_object($object));

        // test objcet
        $this->assertEquals($object->string, 'bar');

        // test recursion objcet
        $this->assertEquals($object->array->number, 13);
    }

    /**
     * test values by key
     *
     * @expectedException        InvalidArgumentException
     */
    public function testArrayObjectException()
    {
        Arr::object('test');
    }

    /**
     * test array merge
     */
    public function testArrayMerge()
    {
        $array1 = array(
            'foo' => 'Foo',
            'bar' => 'Bar',
            'data' => array(
                'item1' => array(
                    'key1' => 'value1',
                    'key2' => 'value2',
                ),
                'key1' => 'value1',
                'key2' => 'value2',
            ),
        );

        $array2 = array(
            'foo' => 'new foo',
            'test',
        );

        $array3 = array(
            'data' => array(
                'item1' => array(
                    'key2' => 'new value2',
                ),
                'key1' => 'new value1',
            ),
        );

        $array4 = array(
            'bar' => null,
        );

        // the needed result
        $expected_result = array(
            'foo' => 'new foo',
            'bar' => null,
            'data' => array(
                'item1' => array(
                    'key1' => 'value1',
                    'key2' => 'new value2',
                ),
                'key1' => 'new value1',
                'key2' => 'value2',
            ),
            0 => 'test',
        );

        // test
        $this->assertEquals(Arr::merge($array1, $array2, $array3, $array4), $expected_result);

        $languages = array(
            'languages' => array(
                'testign' => 'value',
                'aviable' => array(
                    'DE' => array(
                        'DE',
                        'de',
                    ),
                    'EN' => array(
                        'EN',
                        'en',
                    ),
                ),
            ),
        );

        $languages_only_de = array(
            'languages' => array(
                'aviable' => array(
                    'SP' => array(
                        'SP',
                        'sp',
                    ),
                ),
            ),
        );

        $this->assertEquals(
            Arr::merge($languages, $languages_only_de),
            array(
                'languages' => array(
                    'testign' => 'value',
                    'aviable' => array(
                        'DE' => array(
                            'DE',
                            'de',
                        ),
                        'SP' => array(
                            'SP',
                            'sp',
                        ),
                        'EN' => array(
                            'EN',
                            'en',
                        ),
                    ),
                ),
            )
        );
    }

    /**
     * test values by key
     *
     * @expectedException        InvalidArgumentException
     */
    public function testArrayMergeException()
    {
        Arr::merge('test');
    }

    /**
     * test the Arr getter
     */
    public function testArrayGetItem()
    {

        /*
         * get string
         */
        $this->assertEquals(
            Arr::get('string', $this->test_array),
            'bar'
        );

        /*
         * get number
         */
        $this->assertEquals(
            Arr::get('array.number', $this->test_array),
            13
        );

        /*
         * get null
         */
        $this->assertEquals(
            Arr::get('array.null', $this->test_array),
            null
        );

        /*
         * get default
         */
        $this->assertEquals(
            Arr::get('not.existing', $this->test_array, 'default_value'),
            'default_value'
        );
    }

    /**
     * test the Arr setter
     */
    public function testArraySetItem()
    {

        $test_array = $this->test_array;

        /*
         * set string
         */
        Arr::set('string', 'batz', $test_array);
        $this->assertEquals(
            Arr::get('string', $test_array),
            'batz'
        );

        /*
         * set number
         */
        Arr::set('array.number', 0, $test_array);
        $this->assertEquals(
            Arr::get('array.number', $test_array),
            0
        );

        /*
         * set new value
         */
        Arr::set('not.existing.item', 'new value', $test_array);
        $this->assertEquals(
            Arr::get('not.existing.item', $test_array),
            'new value'
        );

        /*
         * set value in deep field
         */
        Arr::set('not.existing.item.in.deep.deep.field', 'deep', $test_array);
        $this->assertEquals(
            Arr::get('not.existing.item.in.deep.deep.field', $test_array),
            'deep'
        );
    }

    /**
     * test the Arr isset
     */
    public function testArrayHasItem()
    {

        /*
         * get string
         */
        $this->assertTrue(Arr::has('string', $this->test_array));

        /*
         * get not existing
         */
        $this->assertFalse(Arr::has('not.existing', $this->test_array));
    }
}
