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
 * Class ImmutableInstance
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
class ImmutableInstance
{
    protected $mutable_instance;

    /**
     * ImmutableInstance constructor.
     * @param object $instance
     * @param string $instance_ob_method
     * @throws \ErrorException
     */
    public function __construct($instance, string $instance_ob_method = 'instanceOf')
    {
        if (!is_object($instance)) {
            throw new \ErrorException('not mutable object');
        }

        ImmutableManager::setInstance($instance, $this);
        $this->mutable_instance = ImmutableManager::getInstance($this);
    }

    /**
     * @param array $an_array
     * @return object
     */
    public static function __set_state($an_array)
    {
        return new static($an_array['mutable_instance']);
    }

    /**
     * MagicMethod
     *
     * @param string $key
     * @return mixed
     * @throws \ErrorException
     */
    public function __get(string $key)
    {
        if (method_exists($this->mutable_instance, '__get')) {
            $instance2 = clone $this->mutable_instance;
            return $instance2->$key;
        } elseif (property_exists($this->mutable_instance, $key)) {
            return $this->mutable_instance->$key;
        }

        throw new \ErrorException('Undefined property: ' . $key . ' in ' . get_class($this->mutable_instance));
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
        if (method_exists($this->mutable_instance, '__set')) {
            // MagicMethodの場合setする動き自体は行う
            $instance2 = clone $this->mutable_instance;
            $instance2->$key = $value;
            return;
        } elseif (property_exists($this->mutable_instance, $key)) {
            // 存在する場合setする動き自体は行う
            $instance2 = clone $this->mutable_instance;
            $instance2->$key = $value;
            return;
        } elseif ($this->mutable_instance instanceof stdClass) {
            // stdClassの場合setする動き自体は行う
            $instance2 = clone $this->mutable_instance;
            $instance2->$key = $value;
            return;
        }

        throw new \ErrorException('Undefined property: ' . $key . ' in ' . get_class($this->mutable_instance));
    }

    /**
     * MagicMethod
     *
     * @param string $name
     * @return bool
     */
    public function __isset(string $name)
    {
        $instance = clone $this->mutable_instance;

        return isset($instance->$name);
    }

    /**
     * @param $name
     * @return void
     * @throws \ErrorException
     */
    public function __unset($name)
    {
        if (method_exists($this->mutable_instance, '__unset')) {
            $instance2 = clone $this->mutable_instance;
            unset($instance2->$name);
            return;
        } elseif (property_exists($this->mutable_instance, $name)) {
            return;
        }

        throw new \ErrorException('Undefined property: ' . $name . ' in ' . get_class($this->mutable_instance));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws \ErrorException
     */
    public function __call(string $name, array $arguments)
    {
        $instance = clone $this->mutable_instance;

        if (method_exists($instance, $name)) {
            // Methodがあれば実行する
            $res = call_user_func_array(array($instance, $name), $arguments);
        } elseif (method_exists($instance, '__call')) {
            // MagicMethodをコール
            $res = call_user_func_array(array($instance, $name), $arguments);
        } else {
            // ない場合はエラー
            throw new \ErrorException('Undefined method: ' . $name . ' in ' . get_class($instance));
        }

        if ($instance === $res) {
            // メソッドチェーンの場合は、$thisに差し替える
            return new static($instance);
        }

        return $res;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $instance = clone $this->mutable_instance;

        return (string)$instance;
    }

    /**
     * @throws \ErrorException
     */
    public function __sleep()
    {
        throw new \ErrorException('Can not Sleep...');
    }

    /**
     * デストラクタ
     */
    public function __destruct()
    {
        ImmutableManager::removeInstance($this);
    }


    /**
     * @param array ...$arguments
     * @return mixed|static
     */
    public function __invoke(... $arguments)
    {
        /** @var object $instance */
        $instance = clone ImmutableManager::getInstance($this);

        /** @var mixed $res */
        $res = call_user_func_array(array($instance, '__invoke'), $arguments);

        if ($res === $instance) {
            // メソッドチェーンの場合は、$thisに差し替える
            return new static($instance);
        }

        return $res;
    }

}