<?php declare(strict_types=1);

namespace Mrself\ClassHelper;

class ClassHelper
{
    /**
     * @var *
     */
    protected $class;

    /**
     * @var string
     */
    protected $type;

    public static function make($class, string $type = null)
    {
        $self = new static();
        $self->class = $class;
        $self->type = $self->defineType($type);
        return $self;
    }

    protected function defineType($source): string
    {
        if ($source) {
            return $source;
        }
        $class = get_class($this->class);
        $parts = explode('\\', $class);
        return lcfirst($parts[1]);
    }

    public function getName()
    {
        $class = get_class($this->class);
        if (method_exists($class, 'getClassHelperOptions')) {
            $options = call_user_func([$class, 'getClassHelperOptions']);
            $type = isset($options['type']) ? $options['type'] : $this->type;
        } else {
            $type = $this->type;
        }
        $reflection = new \ReflectionClass($this->class);
        $name = $reflection->getShortName();
        return str_replace(ucfirst($type), '', $name);
    }
}