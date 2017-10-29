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

/**
 * Class Immutable
 *
 * @package    Envi
 * @subpackage Immutable
 * @author     Suzunone <suzunone.eleven@gmail.com>
 * @copyright  Suzunone 2017
 * @license    BSD 2-Clause License
 * @link       https://github.com/suzunone/ImmutablePHP
 * @see        https://github.com/suzunone/ImmutablePHP
 * @sinse Class available since Release 1.0.0
 */
class Immutable
{
    /**
     * Immutable化する
     *
     * @param object|array $mutable Immutable化するオブジェクトもしくは配列
     * @param string ?$immutable_instance_name Immutable化するオブジェクト(OPTIONAL)
     * @return ImmutableInterface Immutableオブジェクト
     */
    public static function freeze($mutable, $immutable_instance_name = null)
    {
        if (is_array($mutable) && !$immutable_instance_name) {
            return new ImmutableElement($mutable);
        } elseif ($mutable instanceof \stdClass && !$immutable_instance_name) {
            return new ImmutableElement($mutable);
        } elseif (!$immutable_instance_name) {
            return new ImmutableInstance($mutable);
        }

        return new $immutable_instance_name($mutable);
    }


    /**
     * 再帰的に、Immutable化する
     *
     * @param $mutable
     * @param array $immutable_instance_name
     * @param int $limit Recursive limit
     * @return ImmutableInterface
     */
    public static function freezeRecursive($mutable, $immutable_instance_name = [], $limit = 100)
    {
        return ImmutableElement::freezeRecursive($mutable, $immutable_instance_name, $limit);
    }



    /**
     * ImmutableオブジェクトからMutableオブジェクトを取得する
     *
     * @param ImmutableInterface $instance
     * @return mixed|array Mutableオブジェクトか配列
     */
    public static function thaw(ImmutableInterface $instance)
    {
        $obj =  ImmutableManager::getInstance($instance);
        if ($instance instanceof ImmutableInstance) {
            return $obj;
        }
        /**
         * @var ImmutableElement $instance
         */
        if (!$instance->isArray()) {
            $res = new \stdClass();
            foreach ($obj as $name => $item) {
                $res->$name = $item;
            }

            return $res;
        }

        $res = [];
        foreach ($obj as $name => $item) {
            $res[$name] = $item;
        }

        return $res;
    }

    /**
     * Immutable化したinstanceがclass_nameと一致しているかどうか調べる
     *
     * @param object $instance instance
     * @param string $class_name class_name
     * @return bool 一致していればtrue
     */
    public static function instanceOf ($instance, string $class_name)
    {
        if (static::isImmutable($instance)) {
            /** @var ImmutableInterface $instance */
            return ImmutableManager::getInstance($instance) instanceof $class_name;
        }

        return $instance instanceof $class_name;
    }

    /**
     * immutableオブジェクトかどうかを返す
     *
     * @param object $instance
     * @return bool immutableオブジェクトならtrue
     */
    public static function isImmutable($instance): bool
    {
        return $instance instanceof ImmutableInterface;
    }

    /**
     * Immutable化したinstanceのクラス名を取得する
     *
     * @param object $instance instance
     * @param string $class_name class_name
     * @return string クラス名
     */
    public static function instanceName($instance)
    {
        if (static::isImmutable($instance)) {
            /** @var ImmutableInterface $instance */
            return ImmutableManager::instanceName($instance);
        }

        return get_class($instance);
    }
}