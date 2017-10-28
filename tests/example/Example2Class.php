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
 * Class Example2Class
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
class Example2Class implements Example1Interface
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
        $this->public_property = __METHOD__ . '+public';
        $this->protected_property = __METHOD__ . '+protected';
        $this->private_property = __METHOD__ . '+private';
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

    protected function runProtected()
    {
        return true;
    }

    private function runPrivate()
    {
        return true;
    }


}