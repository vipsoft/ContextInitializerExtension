===========================
ContextInitializerExtension
===========================

The Context Initializer extension will initialize the main feature context to use a
configured set of subcontexts at runtime.

Installation
============
This extension requires:

* Behat 2.4+
* Mink 1.4+

Through Composer
----------------
1. Set dependencies in your **composer.json**:

.. code-block:: js

    {
        "require": {
            ...
            "vipsoft/context-initializer-extension": "*"
        }
    }

2. Install/update your vendors:

.. code-block:: bash

    $ curl http://getcomposer.org/installer | php
    $ php composer.phar install

Through PHAR
------------
Download the .phar archive:

* `context_initializer_extension.phar <http://behat.org/downloads/context_initializer_extension.phar>`_

Configuration
=============
Activate extension in your **behat.yml** and specify your subcontext classes:

.. code-block:: yaml

    # behat-client.yml
    default:
      # ...
      extensions:
        VIPSoft\ContextInitializerExtension\Extension:
          classes: ~

Example 1
---------
The following constructor couples the main context to a subcontext:

.. code-block:: php

    class FeatureContext extends BehatContext
    {
        public function __construct(array $parameters)
        {
            $this->useContext('MySubContextAlias', new \Acme\UserBundle\Context\MySubContext($parameters));
        }
    }

We can decouple the main context from the subcontext by replacing the above constructor with this configuration:

.. code-block:: yaml

    # behat.yml
    default:
      # ...
      extensions:
        VIPSoft\ContextInitializerExtension\Extension:
          classes:
            MySubContextAlias: Acme\UserBundle\Context\MySubContext

This is especially desirable when the main context and subcontext are in different bundles.

Example 2
---------
By default, *behat.context.parameters* is passed to the subcontext.

To inject custom parameters to the subcontext, use the array format:

.. code-block:: yaml

    # behat.yml
    default:
      # ...
      extensions:
        VIPSoft\ContextInitializerExtension\Extension:
          classes:
            MySubContextAlias:
              - Acme\UserBundle\Context\MySubContext
              - %behat.context.parameters%

Copyright
=========
Copyright (c) 2012 Anthon Pang.  See **LICENSE** for details.

Contributors
============
* Anthon Pang `(robocoder) <http://github.com/robocoder>`_
