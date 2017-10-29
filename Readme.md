# Immutable object for PHP
[![CircleCI](https://circleci.com/gh/suzunone/ImmutablePHP.svg?style=svg)](https://circleci.com/gh/suzunone/ImmutablePHP)
## Introduction
An Immutable object is an object that can not be changed once it is created.

Using Immutable object makes it unnecessary to clone an object for precaution in order to avoid unintentional object changes, so the code is simple.

Normally, there is a need to design a class so that it becomes Immutable from the beginning, but if you use Immutable, you can easily make an existing object Immutable.

## Easy to use
Using composer, it can be implemented very easily.

```
composer require immutable/immutable
```

## Immutable
Immutable objects are created from existing objects or arrays.

If an array is used, it is internally converted to \ stdClass.

Even if you change to Immutable object, you can use all public methods and properties.

In addition, even when using a private (or protected) method or property in a public method, it also works.



### A simple example
With Immutable, Immutable objectization is very easy.

The following example imtutables a DateTime object.

`````` .php
<?php

require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

// Immutable objectization 
$DT = Immutable::freeze($DT);

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30

$DT->modify('+10 day');

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30

``````

###  Method Chain

If the original object is using a method chain, create a new Immutable object with changes in Method added.


`````` .php
require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

// Immutable objectization 
$DT = Immutable::freeze($DT);

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30

// A new Immutable object that is + 10 days is substituted for $DT2.
$DT2 = $DT->modify('+10 day');
echo $DT2->format('Y-m-d H:i:s');
// 2017-10-19 12:20:30

// With a method chain.
echo $DT->modify('+10 day')->format('Y-m-d H:i:s');
// 2017-10-19 12:20:30

// Immutable object does not change
echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30
``````

## Mutable

It is also easy to return an immutable object to a mutable object.

### A simple example
Mutable is also very simple.
The following example restores the Imutableized DateTime object.

`````` .php
<?php

require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

// Immutable objectization 
$DT = Immutable::freeze($DT);

// Some processing


// Mutable objectization 
$DT = Immutable::thaw($DT);

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30

$DT->modify('+10 day');

echo $DT->format('Y-m-d H:i:s');
// 2017-10-19 12:20:30

``````

## instanceOf

Immutable objects are naturally objects different from mutable objects, so you can not examine them with the native `instanceof` operator.

It shows an alternative means for that.

### Example using `Immutable\Immutable::instanceOf()`

Here is an example of using `Immutable\Immutable::instanceOf()` Method to make an `instanceof` judgment.

`````` .php
<?php
require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

var_export(Immutable::instanceOf($DT, DateTime::class));
// true

var_export($DT instanceof DateTime);
// true

// Immutable objectization 
$DT = Immutable::freeze($DT);

//  class name obviously true
var_export(Immutable::instanceOf($DT, DateTime::class));
// true

// As with instanceof, even if you specify an impleted interface, it is true
var_export(Immutable::instanceOf($DT, DateTimeInterface ::class));
// true

// It is false for standard instanceof
var_export($DT instanceof DateTime);
// false


// Mutable objectization 
$DT = Immutable::thaw($DT);
var_export(Immutable::instanceOf($DT, DateTime::class));
// true

var_export($DT instanceof DateTime);
// true

``````


### How to create Immutable Instance class

By implementing a mutable class and a common interface in the Immutable class, which inherits from `Immutable \ ImmutableInstance`,
You will be able to use native type hinting and `instanceof`.

``` .php
<?php
require 'vendor/autoload.php';

use Immutable\Immutable;
use Immutable\ImmutableInstance;

interface DateTimeClassInterface
{
    public function subDay(int $int): DateTimeClassInterface;
}

class DateTimeInstance extends DateTime implements DateTimeClassInterface
{
    public function subDay(int $int) : DateTimeClassInterface
    {
        return $this->modify('+'.$int.' day');
    }
}

class DateTimeImmutableInstance extends ImmutableInstance implements DateTimeClassInterface
{
    public function subDay(int $int) : DateTimeClassInterface
    {
        // When implementing the contents of interface please describe all contents below
        return call_user_func_array([$this, '__call'], [__FUNCTION__, func_get_args()]);
    }
}



$DT = new DateTimeInstance('2017-10-09 12:20:30');

// Immutable (specify the class name with the second argument)
$DT = Immutable::freeze($DT, DateTimeImmutableInstance::class);

// Class name obviously true
var_export(Immutable::instanceOf($DT, DateTimeInstance::class));
// true

// As with instanceof, even if you specify an impleted interface, it is true
var_export(Immutable::instanceOf($DT, DateTimeClassInterface ::class));
// true

// Since Interface is common, it is true
var_export($DT instanceof DateTimeImmutableInstance);
// true

// Functions and methods with type hintings can also be used

function example(DateTimeClassInterface $instance)
{
    return 'ok';
}

echo example($DT);
// ok


// Implemented methods
var_export($DT->subDay(10)->format('Y-m-d H:i:s'));
// '2017-10-19 12:20:30'



```

