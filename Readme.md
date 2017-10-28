# Immutable object for PHP
## はじめに
Immutable object(不変オブジェクト)は、一度作成されると変更することができないオブジェクトです。

Immutable objectを使用すれば、意図しないオブジェクトの変更を避けるため、念のためにオブジェクトをcloneしておく等と言った処理は不要となり、コードがシンプルになります。

通常であれば、初めからImmutableになるようにクラス設計を行う必要性がありますが、Envi\Immutableを使用すれば、手軽に既存オブジェクトをImmutable化する事ができます。


## Immutable化(不変化)

Immutable objectは、既存のオブジェクトもしくは、配列から作成します。

配列を使用した場合、内部的には\stdClassに変換されます。

Immutable objectに変えても、すべてのpublicなmethodや、propertyを利用可能です。

また、publicなmethod内で、private(あるいはprotected)なmethodや、propertyを利用している場合もすべて動作します。



### シンプルな例
Immutable化はとても簡単です。
以下の例は、DateTime オブジェクトをImmutable化しています。

`````` .php
<?php

require 'vendor/autoload.php';

use Envi\Immutable\Immutable;

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

###  メソッドチェーン

元のオブジェクトがメソッドチェーンを利用している場合は、Method内での変更が加わった新たなImmutableオブジェクトを生成します。


`````` .php
require 'vendor/autoload.php';

use Envi\Immutable\Immutable;

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

## Mutable化

Immutable化されたオブジェクトを、mutable化する(変更可能なオブジェクトにもどす)ことも簡単です。

### シンプルな例
Mutable化もとても簡単です。
以下の例は、Immutable化したDateTimeオブジェクトを元に戻しています。

`````` .php
<?php

require 'vendor/autoload.php';

use Envi\Immutable\Immutable;

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

### `Envi\Immutable\Immutable::instanceOf()`を使用する例

以下に、`Envi\Immutable\Immutable::instanceOf()`Methodを使用して、`instanceof`の判定を行う例を用意しました。

`````` .php
<?php
require 'vendor/autoload.php';

use Envi\Immutable\Immutable;

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

mutableなクラスと、`Envi\Immutable\ImmutableInstance`を継承した、Immutableクラスで共通のInterfaceを実装することで、
ネイティブのタイプヒンティングや`instanceof`を使用することができるようになります。

``` .php
<?php
require 'vendor/autoload.php';

use Envi\Immutable\Immutable;
use Envi\Immutable\ImmutableInstance;

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

