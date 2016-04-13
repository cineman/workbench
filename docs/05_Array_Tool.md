# Array Tool

The following examples expect that you loaded the `Workbench\Arr` namespace.

```php
use Workbench\Arr;
```

## Functions

### Get first

[~ PHPDoc](/src/Arr.php#first)

```php
Arr::first(['foo', 'bar']); // returns foo
```

### Get last

[~ PHPDoc](/src/Arr.php#last)

```php
Arr::last(['foo', 'bar']); // returns bar
```

### Push item

[~ PHPDoc](/src/Arr.php#push)

The array is passed by reference another example:

```php
$array = ['Orange', 'Banana', 'Apple'];
Arr::push('Cherry', $array);

// result of $array: ['Orange', 'Banana', 'Apple', 'Cherry']
```

### Add item

[~ PHPDoc](/src/Arr.php#add)

### Forward key

[~ PHPDoc](/src/Arr.php#forwardKey)

### Pick items

[~ PHPDoc](/src/Arr.php#pick)

[~ PHPDoc](/src/Arr.php#pickObject)

### Is multidimensional?

[~ PHPDoc](/src/Arr.php#isMulti)

### Is collection?

[~ PHPDoc](/src/Arr.php#is_collection)

### Sum values

[~ PHPDoc](/src/Arr.php#sum)

### Average of values

[~ PHPDoc](/src/Arr.php#average)

### Make object

[~ PHPDoc](/src/Arr.php#object)

### Merge 

[~ PHPDoc](/src/Arr.php#merge)

You can merge to arrays together:

```php
$array = ['Orange', 'Apple'];
Arr::push(['Strawberry', 'Banana'], $array, true);

// results in one array: ['Orange', 'Apple', 'Strawberry', 'Banana']
```

### Get value

[~ PHPDoc](/src/Arr.php#get)

### Set value

[~ PHPDoc](/src/Arr.php#set)

### Has value

[~ PHPDoc](/src/Arr.php#has)

### Delete value

[~ PHPDoc](/src/Arr.php#delete)