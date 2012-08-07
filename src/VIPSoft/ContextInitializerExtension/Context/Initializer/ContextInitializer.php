<?php
/**
 * @copyright 2012 Anthon Pang
 * @license MIT
 */

namespace VIPSoft\ContextInitializerExtension\Context\Initializer;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Behat\Behat\Context\Initializer\InitializerInterface,
    Behat\Behat\Context\ContextInterface;

/**
 * A Context Initializer extension for Behat.
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class ContextInitializer implements InitializerInterface
{
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container service container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ContextInterface $context)
    {
        return get_class($context) === $this->container->getParameter('behat.context.class');
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ContextInterface $context)
    {
        $classes = $this->container->getParameter('behat.contextinitializer.classes');

        foreach ($classes as $name => $class) {
            $instance = $this->newInstance($class);

            $context->useContext($name, $instance);
        }
    }

    /**
     * Prefix root namespace
     *
     * @param string $className
     *
     * @return string
     */
    private function prefixRootNamespace($className)
    {
        if (substr($className, 0, 1) !== '\\') {
            $className = '\\' . $className;
        }

        return $className;
    }

    /**
     * Instantiate subcontext
     *
     * @param string|array $classInfo
     *
     * @return object|null
     */
    private function newInstance($classInfo)
    {
        $className = is_array($classInfo) ? array_shift($classInfo) : (is_string($classInfo) ? $classInfo : '');
        $parameters = is_array($classInfo) ? $classInfo : array($this->container->getParameter('behat.context.parameters'));

        $reflection = new \ReflectionClass($this->prefixRootNamespace($className));

        if (!$reflection->hasMethod('__construct')) {
            $parameters = array();
        }

        return $reflection->newInstanceArgs($parameters);
    }
}
