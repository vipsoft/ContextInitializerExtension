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

Settings
--------
Instead of:

.. code-block:: php

    $this->useContext('MySubContext', new \Acme\UserBundle\Context\MySubContext($this));

You would use:

.. code-block:: yaml

    # behat-client.yml
    default:
      # ...
      extensions:
        VIPSoft\ContextInitializerExtension\Extension:
          classes:
            MySubContext: Acme\UserBundle\Context\MySubContext

Copyright
=========
Copyright (c) 2012 Anthon Pang.  See **LICENSE** for details.

Contributors
============
* Anthon Pang `(robocoder) <http://github.com/robocoder>`_
