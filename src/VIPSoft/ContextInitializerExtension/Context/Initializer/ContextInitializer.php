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
     * @param ContainerInterface $container  service container
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
            if (substr($class, 0, 1) !== '\\') {
                $class = '\\' . $class;
            }

            $context->useContext($name, new $class($context));
        }
    }
}
