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
 * Class ImmutableManager
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
class ImmutableManager
{
    static $instances = array();

    /**
     * @param object $instance
     * @param ImmutableInstance|ImmutableInterface $immutable
     * @param bool $is_clone
     */
    public static function setInstance($instance, ImmutableInterface $immutable, bool $is_clone = true)
    {
        if ($is_clone) {
            self::$instances[spl_object_hash($immutable)] = clone $instance;
        } else {
            self::$instances[spl_object_hash($immutable)] = $instance;
        }

    }


    /**
     * @param ImmutableInterface $immutable
     * @return object
     */
    public static function getInstance(ImmutableInterface $immutable)
    {
        return self::$instances[spl_object_hash($immutable)];
    }


    /**
     * @param ImmutableInterface $immutable
     * @return object
     */
    public static function instanceName(ImmutableInterface $immutable)
    {
        return get_class(self::$instances[spl_object_hash($immutable)]);
    }

    /**
     * @param ImmutableInterface $immutable
     */
    public static function removeInstance(ImmutableInterface $immutable)
    {
        unset(self::$instances[spl_object_hash($immutable)]);
    }
}
