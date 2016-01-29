# Array Tool

The following examples expect that you loaded the `Workbench\Arr` namespace.

```php
use Workbench\Arr;
```

## Functions

### First

[~ PHPDoc](/src/Arr.php#first)

```php
Arr::first(['foo', 'bar']); // returns foo
```

### Last

[~ PHPDoc](/src/Arr.php#last)

```php
Arr::last(['foo', 'bar']); // returns bar
```

### Push

[~ PHPDoc](/src/Arr.php#push)

The array is passed by reference another example:

```php
$array = ['Orange', 'Banana', 'Apple'];
Arr::push('Cherry', $array);

// result of $array: ['Orange', 'Banana', 'Apple', 'Cherry']
```

### Merge 

[~ PHPDoc](/src/Arr.php#merge)

You can merge to arrays together:

```php
$array = ['Orange', 'Apple'];
Arr::push(['Strawberry', 'Banana'], $array, true);

// results in one array: ['Orange', 'Apple', 'Strawberry', 'Banana']
```