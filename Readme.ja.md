# Immutable object for PHP
[![CircleCI](https://circleci.com/gh/suzunone/ImmutablePHP.svg?style=svg)](https://circleci.com/gh/suzunone/ImmutablePHP)
## はじめに
Immutable object(不変オブジェクト)は、一度作成されると変更することができないオブジェクトです。

Immutable objectを使用すれば、意図しないオブジェクトの変更を避けるため、念のためにオブジェクトをcloneしておく等と言った処理は不要となり、コードがシンプルになります。

通常であれば、初めからImmutableになるようにクラス設計を行う必要性がありますが、Immutableを使用すれば、手軽に既存オブジェクトをImmutable化する事ができます。

## 簡単に使用する
composerを使用して、非常に簡単に導入することができます。

```
composer require immutable/immutable
```

## Immutable化(不変化)

Immutable objectは、既存のオブジェクトもしくは、配列から作成します。

配列を使用した場合、内部的にstdClassに変換されます。

Immutable objectに変えても、すべてのpublicなmethodや、propertyを利用可能です。

また、publicなmethod内で、private(あるいはprotected)なmethodや、propertyを利用している場合もすべて動作します。



### シンプルな例
Immutable化はとても簡単です。
以下の例は、DateTime オブジェクトをImmutable化しています。

`````` .php
<?php

require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

// Immutable化
$DT = Immutable::freeze($DT);

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30

$DT->modify('+10 day');

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30
// Immutable化しない場合は⇒2017-10-19 12:20:30

``````


## ImmutableElement
stdClass（あるいは配列）をImmutable objectにした場合、最終的にはImmutableElementとして変換されます。

ImmutableElementは、簡単なAPIを提供します。


````.php
<?php
require 'vendor/autoload.php';

use Immutable\ImmutableElement;

$element1 = new ImmutableElement(['a' => 1, 'b' => 2, 'c' => 3, ]);
$element2 = $element1->set('b', 100);
echo $element1->get('b');
// 2

// あるいは...
echo $element1->b;
// 2

echo $element2->get('b');
// 100

// あるいは...
echo $element2->b;
// 100
````




###  メソッドチェーン

元のオブジェクトがメソッドチェーンを利用している場合は、Method内での変更が加わった新たなImmutableオブジェクトを生成します。


`````` .php
<?php
require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

// Immutable化
$DT = Immutable::freeze($DT);

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30

// $DT2には、+10dayされた新たなImmutableオブジェクトが代入される
$DT2 = $DT->modify('+10 day');
echo $DT2->format('Y-m-d H:i:s');
// 2017-10-19 12:20:30

// メソッドチェーンで書く場合
echo $DT->modify('+10 day')->format('Y-m-d H:i:s');
// 2017-10-19 12:20:30

// Immutable化されたオブジェクトは変わらない
echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30
``````

## 再帰的なImmutable化
配列やstdClassをImmutable化する場合、すべての子要素を再帰的に、Immutable化したいと考えることでしょう。

その為の仕組みも用意されています。

以下の例は多次元連想配列を、再帰的にImmutable化する例です。

`````` .php
require 'vendor/autoload.php';

use Immutable\Immutable;

$array_mutable = [['name' => 'Tanaka'], ['name' => 'Suzuki']];
$array_immutable = Immutable::freezeRecursive($array_mutable);
``````

## Mutable化

Immutable化されたオブジェクトを、mutable化する(変更可能なオブジェクトにもどす)ことも簡単です。

### シンプルな例
Mutable化もとても簡単です。
以下の例は、Immutable化したDateTimeオブジェクトを元に戻しています。

`````` .php
<?php

require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

// Immutable化
$DT = Immutable::freeze($DT);

// 何らかの処理


// mutable化
$DT = Immutable::thaw($DT);

echo $DT->format('Y-m-d H:i:s');
// 2017-10-09 12:20:30

$DT->modify('+10 day');

echo $DT->format('Y-m-d H:i:s');
// 2017-10-19 12:20:30

``````

## instanceOf

Immutable化されたオブジェクトをは、当然ながらmutableオブジェクトとは違うオブジェクトとなるため、ネイティブの`instanceof`演算子では、調べることができません。

その為の代替手段を示します。

### `Immutable\Immutable::instanceOf()`を使用する例

以下に、`Immutable\Immutable::instanceOf()`Methodを使用して、`instanceof`の判定を行う例を用意しました。

`````` .php
<?php
require 'vendor/autoload.php';

use Immutable\Immutable;

$DT = new DateTime('2017-10-09 12:20:30');

var_export(Immutable::instanceOf($DT, DateTime::class));
// true

var_export($DT instanceof DateTime);
// true

// Immutable化
$DT = Immutable::freeze($DT);

// クラス名は当然true
var_export(Immutable::instanceOf($DT, DateTime::class));
// true

// instanceofと同じく、implementsされたインターフェイスを指定してもtrue
var_export(Immutable::instanceOf($DT, DateTimeInterface ::class));
// true

// 標準のinstanceofではfalseとなります
var_export($DT instanceof DateTime);
// false


// mutable化
$DT = Immutable::thaw($DT);
var_export(Immutable::instanceOf($DT, DateTime::class));
// true

var_export($DT instanceof DateTime);
// true

``````


### Immutable Instanceクラスを作成する方法

mutableなクラスと、`Immutable\ImmutableInstance`を継承した、Immutableクラスで共通のInterfaceを実装することで、
ネイティブのタイプヒンティングや`instanceof`を使用することができるようになります。

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
        // interfaceの中身を実装する場合はすべて以下の内容を記述して下さい
        return call_user_func_array([$this, '__call'], [__FUNCTION__, func_get_args()]);
    }
}



$DT = new DateTimeInstance('2017-10-09 12:20:30');

// Immutable化(第二引数でクラス名を指定)
$DT = Immutable::freeze($DT, DateTimeImmutableInstance::class);

// クラス名は当然true
var_export(Immutable::instanceOf($DT, DateTimeInstance::class));
// true

// instanceofと同じく、implementsされたインターフェイスを指定してもtrue
var_export(Immutable::instanceOf($DT, DateTimeClassInterface ::class));
// true

// Interfaceは共通なのでtrueとなります
var_export($DT instanceof DateTimeImmutableInstance);
// true

// タイプヒントつきの関数・メソッドも使用できます

function example(DateTimeClassInterface $instance)
{
    return 'ok';
}

echo example($DT);
// ok


// 実装したメソッド
var_export($DT->subDay(10)->format('Y-m-d H:i:s'));
// '2017-10-19 12:20:30'



```

