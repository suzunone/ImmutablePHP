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
     * @param ImmutableInstance $immutable
     */
    public static function setInstance($instance, ImmutableInstance $immutable)
    {
        self::$instances[spl_object_hash($immutable)] = clone $instance;
    }


    /**
     * @param ImmutableInstance $immutable
     * @return object
     */
    public static function getInstance(ImmutableInstance $immutable)
    {
        return self::$instances[spl_object_hash($immutable)];
    }


    /**
     * @param ImmutableInstance $immutable
     * @return object
     */
    public static function instanceName(ImmutableInstance $immutable)
    {
        return get_class(self::$instances[spl_object_hash($immutable)]);
    }

    /**
     * @param ImmutableInstance $immutable
     */
    public static function removeInstance(ImmutableInstance $immutable)
    {
        unset(self::$instances[spl_object_hash($immutable)]);
    }
}
