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
     * @return ImmutableInstance Immutableオブジェクト
     */
    public static function freeze($mutable, $immutable_instance_name = null)
    {
        if (is_array($mutable)) {
            $instance = new \stdClass();
            foreach ($mutable as $key => $item) {
                $instance->$key = $item;
            }
        } else {
            $instance = $mutable;
        }

        if ($immutable_instance_name) {
            return new $immutable_instance_name($instance);
        }

        return new ImmutableInstance($instance);
    }

    /**
     * ImmutableオブジェクトからMutableオブジェクトを取得する
     *
     * @param ImmutableInstance $instance
     * @return mixed Mutableオブジェクト
     */
    public static function thaw(ImmutableInstance $instance)
    {
        return ImmutableManager::getInstance($instance);
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
            /** @var ImmutableInstance $instance */
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
        return $instance instanceof ImmutableInstance;
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
            /** @var ImmutableInstance $instance */
            return ImmutableManager::instanceName($instance);
        }

        return get_class($instance);
    }
}