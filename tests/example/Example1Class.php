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

namespace Examples;

/**
 * Class Example1Class
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
class Example1Class implements Example1Interface
{
    public $public_property;
    public $set_property;
    public $get_property;
    public $isset_property;
    public $unset_property;
    public $call_property;
    protected $protected_property;
    private $private_property;

    /**
     * Example1Class constructor.
     */
    public function __construct()
    {
        $this->public_property = spl_object_hash($this) . '+public';
        $this->protected_property = spl_object_hash($this) . '+protected';
        $this->private_property = spl_object_hash($this) . '+private';
    }

    /**
     * @param array $an_array
     * @return object
     */
    public static function __set_state($an_array)
    {
        $instance = new static;

        foreach ($an_array as $k => $item) {
            $instance->$k = $item;
        }

        return $instance;
    }

    public function publicProperty()
    {
        return $this->public_property;
    }

    public function protectedProperty()
    {
        return $this->protected_property;
    }

    public function privateProperty()
    {
        return $this->private_property;
    }

    public function getPublicProperty()
    {
        $this->public_property = __METHOD__ . '+public';
        return $this->public_property;
    }

    public function setPublicProperty()
    {
        $this->public_property = __METHOD__ . '+public';
        return $this;
    }

    public function getProtectedProperty()
    {
        $this->protected_property = __METHOD__ . '+protected';
        return $this->protected_property;
    }

    public function setProtectedProperty()
    {
        $this->protected_property = __METHOD__ . '+protected';
        return $this;
    }

    public function getPrivateProperty()
    {
        $this->private_property = __METHOD__ . '+private';
        return $this->private_property;
    }

    public function setPrivateProperty()
    {
        $this->private_property = __METHOD__ . '+private';
        return $this;
    }

    public function runPublic()
    {
        return true;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $this->get_property = [];
        $this->get_property[$name] = $name;

        return $this->get_property;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->set_property = [];
        $this->set_property[$name] = $value;
    }

    /**
     * @param string $name
     */
    public function __isset($name)
    {
        $this->isset_property = [];
        $this->isset_property[$name] = $name;

    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        $this->unset_property = [];
        $this->unset_property[$name] = $name;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $this->call_property = [];
        $this->call_property[$name] = $arguments;
        return $this->call_property;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'This is to string';
    }

    protected function runProtected()
    {
        return true;
    }

    private function runPrivate()
    {
        return true;
    }
}