<?php

namespace Workbench;

/**
 * Array tool
 **
 * @package             Cineman/Workbench
 * @author              Mario Döring
 * @copyright           2016 Cinergy AG
 */
class Arr
{
    /**
     * Get the first element of an array
     * 
     *     $first = Arr::first(['sam', 'rockwell'])
     *
     * @param array         $array
     * @return mixed
     */
    public static function first($array)
    {
        return array_shift($array);
    }

    /**
     * Get the last element of an array
     *
     * @param array         $array
     * @return mixed
     */
    public static function last($array)
    {
        return array_pop($array);
    }

    /**
     * Adds a single item or array of items at the end of the referenced array
     * If you want to combine multiple arrays recursivly or use key => value pairs, please use Arr::merge()
     *
     * Example:
     *     $bar = array( 'bar' );
     *     Arr::push( 'foo', $bar ); // $bar = array( 'bar', 'foo' )
     *     Arr::push( array( 'foo', 'baz' ), $bar ); // $bar = array( 'bar', array( 'foo', 'baz' ) )
     *     Arr::push( array( 'foo', 'baz' ), $bar, true ); // $bar = array( 'bar', 'foo', 'baz' )
     *
     * @param mixed         $item      The item you would like to add to the array
     * @param array         $array   The input array by reference
     * @param bool          $merge     If $merge is set to true, push will merge each element of $item into $array
     * 
     * @return array
     */
    public static function push($item, &$array, $merge = false)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Arr::push - second argument has to be an array.');
        }

        if ($merge && is_array($item)) {
            foreach ($item as $value) {
                $array[] = $value;
            }
            return $array;
        }

        $array[] = $item;

        return $array;
    }

    /**
     * Adds an item to an element in the array
     *
     * Example:
     *     Arr::add('foo.bar', 'test');
     *
     * Results:
     *     array('foo' => array('bar' => array('test')))
     *
     * @param string            $key
     * @param mixed             $item
     * @param array             $array
     * 
     * @return array
     */
    public static function add($key, $item, &$array)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Arr::add - second argument has to be an array.');
        }

        if (!is_array(static::get($key, $array))) {
            return static::set($key, array($item), $array);
        }

        $valueArr = static::get($key, $array);

        return static::set($key, static::push($item, $valueArr), $array);
    }

    /**
     * Forwards an array value as key
     * 
     *     $arr = Arr::forwardKey('id', [
     *         ['id' => 5, 'name' => 'Mario'], 
     *         ['id' => 10, 'name' => 'Ray']
     *     ])
     *
     * @param string                $key
     * @param array                 $array
     * @return array
     */
    public static function forwardKey($key, $array)
    {
        $result = array();

        foreach ($array as $arraykey => $value) {
            $result[static::get($key, $value)] = $value;
        }

        return $result;
    }

    /**
     * Get a special value from every array item
     * 
     *     $names = Arr::pick('name', [
     *         ['id' => 5, 'name' => 'Mario'], 
     *         ['id' => 10, 'name' => 'Ray']
     *     ])
     *
     * @param mixed                 $key
     * @param array[array]          $array
     * @return array
     */
    public static function pick($key, $array)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Arr::pick - second argument has to be an array.');
        }

        $return = array();

        foreach ($array as $array) {
            $return[] = Arr::get($key, $array);
        }

        return $return;
    }

    /**
     * Same as normal pick but can deal with objects
     *
     * @param mixed             $key
     * @param array[obj]        $array
     * @return array
     */
    public static function pickObject($key, $array)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Arr::pickObject - second argument has to be an array.');
        }

        $return = array();

        foreach ($array as $object) {
            $return[] = $object->{$key};
        }

        return $return;
    }

    /**
     * Check if an array is multidimensional
     * Elements with empty arrays doesn't count!
     *
     * Example:
     *     Arr::isMulti( array( 'foo', array( 'bar', 'baz' ) ) ) === true
     *     Arr::isMulti( array( array() ) ) === false
     *     Arr::isMulti( false ) === false
     *
     * @param array         $array
     * @return bool
     */
    public static function isMulti($array)
    {
        // if $array isn't an array both count() will return useless values 0 (count(null)) or 1 (count(false)) and so the function will return false
        if (count($array) == count($array, COUNT_RECURSIVE)) {
            return false;
        }
        return true;
    }

    /**
     * Check if first element of an array is an array
     *
     * Example:
     *     Arr::is_collection( array( 'foo', array( 'bar', 'baz' ) ) ) === false
     *     Arr::is_collection( array( array() ) ) === true
     *     Arr::is_collection( false ) // Exception
     *
     * @param array         $array
     * @return bool
     */
    public static function is_collection($array)
    {
        return is_array(reset($array));
    }

    /**
     * sum items in an array or use special item in the array
     *
     * @param array[array]      $array
     * @param string            $key
     */
    public static function sum($array, $key = null)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Arr::sum - first argument has to be an array.');
        }

        $sum = 0;

        if (is_string($key) && Arr::isMulti($array)) {
            $array = Arr::pick($key, $array);
        }

        foreach ($array as $item) {
            if (is_numeric($item)) {
                $sum += $item;
            }
        }

        return $sum;
    }

    /**
     * get the average of the items
     *
     * @param array[array]      $array
     * @param string            $key
     */
    public static function average($array, $key = null)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Arr::average - first argunent has to be an array.');
        }

        if (is_string($key) && Arr::isMulti($array)) {
            $array = Arr::pick($key, $array);
        }

        return (static::sum($array) / count($array));
    }

    /**
     * create an object from an array
     *
     * @param array             $array
     * @return object
     */
    public static function object($array)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException("Arr::object - only arrays can be passed.");
        }

        $object = new \stdClass();

        if (!empty($array)) {
            foreach ($array as $name => $value) {
                if (is_array($value)) {
                    $value = static::object($value);
                }
                $object->$name = $value;
            }
        }

        return $object;
    }

    /**
     * merge arrays recursivly together
     *
     * @param array         $array ...
     * @return array
     */
    public static function merge()
    {
        // get all arguments
        $arrays = func_get_args();
        $return = array();

        foreach ($arrays as $array) {
            if (!is_array($array)) {
                throw new \InvalidArgumentException('Arr::merge - all arguments have to be arrays.');
            }

            foreach ($array as $key => $value) {
                if (array_key_exists($key, $return)) {
                    if (is_array($value) && is_array($return[$key])) {
                        $value = static::merge($return[$key], $value);
                    }
                }
                $return[$key] = $value;
            }
        }

        return $return;
    }

    /**
     * return an item from an array with dottet dimensions
     *
     * @param string        $key
     * @param array         $array
     * @param mixed         $default
     * @return mixed
     */
    public static function get($key, $array, $default = null)
    {
        if (isset($array[$key])) {
            return $array[$key];
        }

        if (strpos($key, '.') !== false) {
            $kp = explode('.', $key);

            switch (count($kp)) {
                case 2:
                    if (isset($array[$kp[0]][$kp[1]])) {
                        return $array[$kp[0]][$kp[1]];
                    }
                    break;
                case 3:
                    if (isset($array[$kp[0]][$kp[1]][$kp[2]])) {
                        return $array[$kp[0]][$kp[1]][$kp[2]];
                    }
                    break;
                case 4:
                    if (isset($array[$kp[0]][$kp[1]][$kp[2]][$kp[3]])) {
                        return $array[$kp[0]][$kp[1]][$kp[2]][$kp[3]];
                    }
                    break;

                // if there are more then 4 parts loop trough them
                default:
                    $curr = $array;
                    foreach ($kp as $k) {
                        if (isset($curr[$k])) {
                            $curr = $curr[$k];
                        } else {
                            return $default;
                        }
                    }
                    return $curr;
                    break;
            }
        }

        return $default;
    }

    /**
     * checks if the array has an item with dottet dimensions
     *
     * @param string        $key
     * @param array     $array
     * @return bool
     */
    public static function has($key, $array)
    {
        if (isset($array[$key])) {
            return true;
        }

        if (strpos($key, '.') !== false) {
            $kp = explode('.', $key);

            switch (count($kp)) {
                case 2:
                    return isset($array[$kp[0]][$kp[1]]);
                    break;
                case 3:
                    return isset($array[$kp[0]][$kp[1]][$kp[2]]);
                    break;
                case 4:
                    return isset($array[$kp[0]][$kp[1]][$kp[2]][$kp[3]]);
                    break;

                // if there are more then 4 parts loop trough them
                default:
                    $curr = $array;
                    foreach ($kp as $k) {
                        if (isset($curr[$k])) {
                            $curr = $curr[$k];
                        } else {
                            return false;
                        }
                    }
                    return true;
                    break;
            }
        }
        return false;
    }

    /**
     * sets an item from an array with dottet dimensions
     *
     * @param string    $key
     * @param mixed     $value
     * @param array     $array
     * @return array
     */
    public static function set($key, $value, &$array)
    {
        if (strpos($key, '.') === false) {
            $array[$key] = $value;

        } else {
            $kp = explode('.', $key);

            switch (count($kp)) {
                case 2:
                    $array[$kp[0]][$kp[1]] = $value;
                    break;
                case 3:
                    $array[$kp[0]][$kp[1]][$kp[2]] = $value;
                    break;
                case 4:
                    $array[$kp[0]][$kp[1]][$kp[2]][$kp[3]] = $value;
                    break;

                // if there are more then 4 parts loop trough them
                default:
                    $kp = array_reverse($kp);
                    $curr = $value;

                    foreach ($kp as $k) {
                        $curr = array($k => $curr);
                    }

                    $array = static::merge($array, $curr);
                    break;
            }
        }
        return $array;
    }

    /**
     * deletes an item from an array with dottet dimensions
     *
     * @param string        $key
     * @param array     $array
     * @return void
     */
    public static function delete($key, &$array)
    {
        if (isset($array[$key])) {
            unset($array[$key]);return;
        }

        if (strpos($key, '.') !== false) {
            $kp = explode('.', $key);

            switch (count($kp)) {
                case 2:
                    unset($array[$kp[0]][$kp[1]]);return;
                    break;
                case 3:
                    unset($array[$kp[0]][$kp[1]][$kp[2]]);return;
                    break;
                case 4:
                    unset($array[$kp[0]][$kp[1]][$kp[2]][$kp[3]]);return;
                    break;
            }
        }
    }
}
