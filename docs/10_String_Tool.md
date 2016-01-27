# String Tool

The following examples expect that you loaded the `Workbench\Str` namespace.

```php
use Workbench\Str;
```

## Functions

### random

```php
Str::random(); // generates a random string
```

### charset

```php
Str::charset(); // return default charset
Str::charset('hex'); // returns hex charset etc.. 
```

### htmlentities

```php
Str::htmlentities(array(
	'message' => 'This is <b>Important!</b>',
	'comments' => array(
		'<im a happy tag>',
		'this should be <span>Foo</span>'
	),
), true);
```

**Returns:**

```json
{
	"message": "This is &lt;b&gt;Important!&lt;/b&gt;",
	"comments": [
		"&lt;im a happy tag&gt;",
		"this should be &lt;span&gt;Foo&lt;/span&gt;"
	]
}
```

### clean

```php
Str::clean('Hallöle!!!!!! is^^ n(i)c\'h so =le<s>e<r>l"$ich od<<<>er\"\"'); // Halloele is nich so leserlich oder
```

Allowing other special characters

```php
Str::clean('H(a)s"t       du hunger?', '\?'); // Hast du hunger?
```

### clean url

```php
Str::clean_url('Mr. Jonny *Köppl*'); // mr-jonny-koeppl
```

```php
Str::clean_url('Team & Address+Contact'); // team-address-contact
```

### replace

```php
Str::replace('Hello (name).', array( '(name)' => 'Jaffy' )); // Hello Jaffy.
```

### upper

```php
Str::upper('äccènts cän be änöying'); // ÄCCÈNTS CÄN BE ÄNÖYING
```

### lower

```php
Str::upper('ÄCCÈNTS CÄN BE ÄNÖYING'); // äccènts cän be änöying
```

### replace accents

```php
Str::replace_accents('äccènts cän be änöying'); // aeccents caen be aenoeying
```