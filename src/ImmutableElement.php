<?php
/**
 * @package    Envi
 * @subpackage Immutable
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  Suzunone 2017
 * @license    BSD 2-Clause License
 * @link       https://github.com/suzunone/ImmutablePHP
 * @see        https://github.com/suzunone/ImmutablePHP
 * @sinse Class available since Release 1.0.0
 */
namespace Immutable;

use stdClass;

/**
 * @package    Envi
 * @subpackage Immutable
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  Suzunone 2017
 * @license    BSD 2-Clause License
 * @link       https://github.com/suzunone/ImmutablePHP
 * @see        https://github.com/suzunone/ImmutablePHP
 * @sinse Class available since Release 1.0.0
 */
class ImmutableElement implements ImmutableInterface
{
    protected $mutable_items;

    protected $is_array = false;

    /**
     * ImmutableElement constructor.
     * @param array|stdClass $items
     */
    public function __construct($items = null)
    {
        if ($items === null) {
            $this->mutable_items = new stdClass();
            return;
        }

        if ($items instanceof stdClass) {
            ImmutableManager::setInstance($items, $this);
            $this->mutable_items = ImmutableManager::getInstance($this);

            return;
        }

        $this->mutable_items = new stdClass();
        foreach ($items as $name => $item) {
            $name = (string)$name;
            $this->mutable_items->$name = $item;
        }
        $this->is_array = true;
        ImmutableManager::setInstance($this->mutable_items, $this, false);
    }

    /**
     * MagicMethod
     *
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->mutable_items->$name);
    }

    /**
     * MagicMethod
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->mutable_items->$name;
    }

    /**
     * 値の取得
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->mutable_items->$name;
    }

    /**
     *
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws \ErrorException
     */
    public function __set(string $key, $value)
    {
        // do nothing...
    }

    /**
     * putへのエイリアス
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function set(string $key, $value)
    {
        return $this->put($key, $value);
    }

    /**
     * 値を定義する
     * @param string $key
     * @param $value
     * @return static
     */
    public function put(string $key, $value)
    {
        // create new ImmutableElement
        $res = new static();
        $res->is_array = $this->is_array;

        foreach ($this->mutable_items as $name => &$item) {
            if ($name === $key) {
                $res->mutable_items->$name = $value;
                continue;
            }

            $res->mutable_items->$name = $item;
        }

        // 新規変数
        if (!isset($res->mutable_items->$key)) {
            $res->mutable_items->$key = $value;
        }

        ImmutableManager::setInstance($res->mutable_items, $res, false);

        return $res;
    }

    /**
     * @return bool
     */
    public function isArray() : bool
    {
        return $this->is_array;
    }

    /**
     * デストラクタ
     */
    public function __destruct()
    {
        ImmutableManager::removeInstance($this);
    }


    /**
     * 再帰的に、Immutable化する
     *
     * @param $mutable
     * @param array $immutable_instance_name
     * @param int $limit Recursive limit
     * @param array $circle
     * @return ImmutableInterface
     * @throws \ErrorException
     */
    public static function freezeRecursive($mutable, $immutable_instance_name = [], $limit = 100, $circle = [])
    {
        if ($limit <= 0) {
            // 制限に引っかかった場合
            throw new \ErrorException('Recursive error than limit');
        } elseif (!is_object($mutable) && !is_array($mutable)) {
            // 配列でも、オブジェジュとでもなければ元々、immutable
            return $mutable;
        } elseif ($mutable instanceof ImmutableInterface) {
            // すでにImmutableInterfaceならそのまま返す
            return $mutable;
        } elseif (!is_array($mutable) && !$mutable instanceof \stdClass) {
            // 普通のオブジェクト
            return Immutable ::freeze($mutable, $immutable_instance_name[get_class($mutable)] ?? null);
        } elseif (is_object($mutable) && isset($circle[spl_object_hash($mutable)])) {
            // 循環参照の場合は、参照先のmutableオブジェクトを返す
            return $circle[spl_object_hash($mutable)];
        }

        if ($mutable instanceof \stdClass) {
            // 元クラスのハッシュをcheckして、循環参照対応
            $hash = spl_object_hash($mutable);
            $circle[$hash] = new static($mutable);

            foreach ($circle[$hash]->mutable_items as $name => $item) {
                $circle[$hash]->mutable_items->$name = static::freezeRecursive($item, $immutable_instance_name, $limit -1, $circle);
            }

            return $circle[$hash];
        }

        // 配列の場合
        $instance = [];
        foreach ($mutable as $name => $item) {
            $instance[$name] = static::freezeRecursive($item, $immutable_instance_name, $limit -1, $circle);
        }

        return Immutable ::freeze($instance, $immutable_instance_name['Array'] ?? null);
    }
}