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
    private $parameters;

    /**
     * Constructor
     *
     * @param ContainerInterface $container  service container
     * @param array              $parameters config parameters for this extension
     */
    public function __construct($container, $parameters)
    {
        $this->container = $container;
        $this->parameters = $parameters;
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
        foreach ($this->parameters['classes'] as $name => $class) {
            if (substr($class, 0, 1) !== '\\') {
                $class = '\\' . $class;
            }

            $context->useContext($name, new $class($context));
        }
    }
}
