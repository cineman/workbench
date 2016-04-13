# String Tool

The following examples expect that you loaded the `Workbench\Str` namespace.

```php
use Workbench\Str;
```

## Functions

### Generate random

[~ PHPDoc](/src/Str.php#random)

```php
Str::random(); // generates a random string
```

### Get charset

[~ PHPDoc](/src/Str.php#charset)

```php
Str::charset(); // return default charset
Str::charset('hex'); // returns hex charset etc.. 
```

### Capture text

[~ PHPDoc](/src/Str.php#capture)

### Escape entities

[~ PHPDoc](/src/Str.php#htmlentities)

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

### Get the suffix

[~ PHPDoc](/src/Str.php#suffix)

### Get the prefix

[~ PHPDoc](/src/Str.php#prefix)

### Get the file extension

[~ PHPDoc](/src/Str.php#extension)

### Clean a string

[~ PHPDoc](/src/Str.php#clean)

```php
Str::clean('Hallöle!!!!!! is^^ n(i)c\'h so =le<s>e<r>l"$ich od<<<>er\"\"'); // Halloele is nich so leserlich oder
```

Allowing other special characters

```php
Str::clean('H(a)s"t       du hunger?', '\?'); // Hast du hunger?
```

### Clean url

[~ PHPDoc](/src/Str.php#clean_url)

```php
Str::clean_url('Mr. Jonny *Köppl*'); // mr-jonny-koeppl
```

```php
Str::clean_url('Team & Address+Contact'); // team-address-contact
```

### Replace

[~ PHPDoc](/src/Str.php#replace)

```php
Str::replace('Hello (name).', array( '(name)' => 'Jaffy' )); // Hello Jaffy.
```
### Replace regex

[~ PHPDoc](/src/Str.php#preg_replace)

### upper

[~ PHPDoc](/src/Str.php#lower)

```php
Str::upper('äccènts cän be änöying'); // ÄCCÈNTS CÄN BE ÄNÖYING
```

### lower

[~ PHPDoc](/src/Str.php#upper)

```php
Str::upper('ÄCCÈNTS CÄN BE ÄNÖYING'); // äccènts cän be änöying
```

### Replace accents

[~ PHPDoc](/src/Str.php#replaceAccents)

```php
Str::replaceAccents('äccènts cän be änöying'); // aeccents caen be aenoeying
```

### Cut string

[~ PHPDoc](/src/Str.php#cut)

### Strip string

[~ PHPDoc](/src/Str.php#strip)

### Convert large numbers

[~ PHPDoc](/src/Str.php#kfloor)

### Convert bytes

[~ PHPDoc](/src/Str.php#bytes)

### Convert microtime

[~ PHPDoc](/src/Str.php#microtime)