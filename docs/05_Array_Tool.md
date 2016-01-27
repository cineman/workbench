# Array Tool

The following examples expect that you loaded the `Workbench\Arr` namespace.

```php
use Workbench\Arr;
```

## Functions

### First

```php
Arr::first(['foo', 'bar']); // returns foo
```

### Last

```php
Arr::last(['foo', 'bar']); // returns bar
```

#### pass by reference

The array is passed by reference another example:

```php
$array = ['Orange', 'Banana', 'Apple'];
Arr::push('Cherry', $array);

// result of $array: ['Orange', 'Banana', 'Apple', 'Cherry']
```

#### merge 

You can merge to arrays together:

```php
$array = ['Orange', 'Apple'];
Arr::push(['Strawberry', 'Banana'], $array, true);

// results in one array: ['Orange', 'Apple', 'Strawberry', 'Banana']
```