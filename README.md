# Workbench

The cineman Workbench provides helpful utils and tools for the daily developer life.

[![Build Status](https://travis-ci.org/cineman/workbench.svg?branch=master&style=flat-square)](https://travis-ci.org/cineman/workbench)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](license.md)
[![Packagist Version](https://img.shields.io/packagist/v/cineman/workbench.svg?style=flat-square)](https://packagist.org/packages/cineman/workbench)
[![Total Downloads](https://img.shields.io/packagist/dt/cineman/workbench.svg?style=flat-square)](https://packagist.org/packages/cineman/workbench)

Check out the [Documentation](http://labs.cinergy.ch/project/workbench/master/docs/).

## Installtion 

The workbench is available on packagegist.

```
$ composer require cineman/workbench
```

## Usage 

To easier and faster access the workbench tools you can alias the classes to the global namespace:

```php
foreach(['Str', 'Arr'] as $tool)
{
	class_alias("\\Workbench\\" . $tool, "\\" . $tool);
}
```

> Warning: If you are using a framework like laravel theses class names might already been reserved!
