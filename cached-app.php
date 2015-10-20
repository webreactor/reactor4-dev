<?php
return Mod\Application\Application::__set_state(array(
   'dir' => NULL,
   'name' => 'application',
   'full_name' => 'application',
   'data' => 
  array (
    'application' => 
    Reactor\ServiceContainer\Reference::__set_state(array(
       'path' => 
      array (
      ),
       'loading' => false,
    )),
    'test' => 'test_value',
    'test2' => 'D:\\famp\\htdocs\\reactor4/',
    'db' => 
    Reactor\ServiceContainer\Configurator\DynamicParametersProvider::__set_state(array(
       'data' => 
      Reactor\ServiceContainer\Reference::__set_state(array(
         'path' => 'db.connections/local',
         'loading' => false,
      )),
    )),
    'db.connections' => 
    Reactor\Database\Module::__set_state(array(
       'dir' => NULL,
       'name' => 'db.connections',
       'full_name' => 'application/db.connections',
       'data' => 
      array (
        'local' => 
        Reactor\ServiceContainer\ServiceProvider::__set_state(array(
           'scenario' => 
          array (
            0 => 
            array (
              'type' => 'create',
              'igniter' => '\\Reactor\\Database\\PDO\\Connection',
              'arguments' => 
              array (
                0 => 'mysql:dbname=catalog-service;host=localhost',
                1 => 'root',
                2 => 'anabios',
              ),
            ),
          ),
           'shared' => false,
           'instance' => NULL,
        )),
      ),
       'parent' => NULL,
    )),
    'dispatcher' => 
    Reactor\Events\Module\Dispatcher::__set_state(array(
       'dispatcher' => 
      Reactor\Events\ContainerAwareDispatcher::__set_state(array(
         'container' => NULL,
         'wildcard' => '#',
         'wordcard' => '\\*',
         'divider' => '\\.',
         'listeners' => 
        array (
          '/^user\\.deleted$/' => 
          array (
            0 => 
            array (
              0 => 
              Reactor\ServiceContainer\Reference::__set_state(array(
                 'path' => 'application/news/printer',
                 'loading' => false,
              )),
              1 => 'display',
            ),
          ),
        ),
         'cache' => 
        array (
        ),
      )),
       'dir' => NULL,
       'name' => 'dispatcher',
       'full_name' => 'application/dispatcher',
       'data' => 
      array (
      ),
       'parent' => NULL,
    )),
    'folders.base_dir' => 
    Reactor\ServiceContainer\Configurator\DynamicParametersProvider::__set_state(array(
       'data' => 
      Reactor\ServiceContainer\ConstantReference::__set_state(array(
         'name' => 'BASE_DIR',
      )),
    )),
    'folders.gekkon.tpl_bin' => 
    Reactor\ServiceContainer\ServiceProvider::__set_state(array(
       'scenario' => 
      array (
        0 => 
        array (
          'type' => 'create',
          'igniter' => NULL,
          'arguments' => 
          array (
          ),
        ),
        1 => 
        array (
          'type' => 'factory',
          'igniter' => 'implode',
          'arguments' => 
          array (
            0 => '',
            1 => 
            array (
              0 => 
              Reactor\ServiceContainer\Reference::__set_state(array(
                 'path' => 'folders.base_dir',
                 'loading' => false,
              )),
              1 => 'tpl_bin/',
            ),
          ),
        ),
      ),
       'shared' => true,
       'instance' => NULL,
    )),
    'view' => 
    Reactor\Gekkon\Module\Gekkon::__set_state(array(
       'dir' => NULL,
       'name' => 'view',
       'full_name' => 'application/view',
       'data' => 
      array (
        'base_dir' => 
        Reactor\ServiceContainer\Configurator\DynamicParametersProvider::__set_state(array(
           'data' => 
          Reactor\ServiceContainer\Reference::__set_state(array(
             'path' => 'folders.base_dir',
             'loading' => false,
          )),
        )),
        'tpl_bin' => 
        Reactor\ServiceContainer\Configurator\DynamicParametersProvider::__set_state(array(
           'data' => 
          Reactor\ServiceContainer\Reference::__set_state(array(
             'path' => 'folders.gekkon.tpl_bin',
             'loading' => false,
          )),
        )),
        'gekkon' => 
        Reactor\ServiceContainer\ServiceProvider::__set_state(array(
           'scenario' => 
          array (
            0 => 
            array (
              'type' => 'create',
              'igniter' => 
              Reactor\ServiceContainer\Reference::__set_state(array(
                 'path' => 'gekkon.raw',
                 'loading' => false,
              )),
              'arguments' => 
              array (
              ),
            ),
            1 => 
            array (
              'type' => 'call',
              'igniter' => 'set_property',
              'arguments' => 
              array (
                0 => 'tpl_module_manager',
                1 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'tpl_module_manager',
                   'loading' => false,
                )),
              ),
            ),
            2 => 
            array (
              'type' => 'call',
              'igniter' => 'set_property',
              'arguments' => 
              array (
                0 => 'tpl_provider',
                1 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'tpl_provider',
                   'loading' => false,
                )),
              ),
            ),
            3 => 
            array (
              'type' => 'call',
              'igniter' => 'register',
              'arguments' => 
              array (
                0 => '_application',
                1 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'application',
                   'loading' => false,
                )),
              ),
            ),
          ),
           'shared' => true,
           'instance' => NULL,
        )),
        'gekkon.raw' => 
        Reactor\ServiceContainer\ServiceProvider::__set_state(array(
           'scenario' => 
          array (
            0 => 
            array (
              'type' => 'create',
              'igniter' => '\\Reactor\\Gekkon\\Gekkon',
              'arguments' => 
              array (
                0 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'base_dir',
                   'loading' => false,
                )),
                1 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'tpl_bin',
                   'loading' => false,
                )),
              ),
            ),
          ),
           'shared' => true,
           'instance' => NULL,
        )),
        'tpl_module_manager' => 
        Reactor\ServiceContainer\ServiceProvider::__set_state(array(
           'scenario' => 
          array (
            0 => 
            array (
              'type' => 'create',
              'igniter' => '\\Reactor\\Gekkon\\Module\\TplModuleManager',
              'arguments' => 
              array (
                0 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'gekkon.raw',
                   'loading' => false,
                )),
              ),
            ),
            1 => 
            array (
              'type' => 'call',
              'igniter' => 'push',
              'arguments' => 
              array (
                0 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'application',
                   'loading' => false,
                )),
              ),
            ),
          ),
           'shared' => false,
           'instance' => NULL,
        )),
        'tpl_provider' => 
        Reactor\ServiceContainer\ServiceProvider::__set_state(array(
           'scenario' => 
          array (
            0 => 
            array (
              'type' => 'create',
              'igniter' => '\\Reactor\\Gekkon\\Module\\TplProviderReactorMod',
              'arguments' => 
              array (
                0 => 
                Reactor\ServiceContainer\Reference::__set_state(array(
                   'path' => 'application',
                   'loading' => false,
                )),
              ),
            ),
          ),
           'shared' => false,
           'instance' => NULL,
        )),
      ),
       'parent' => NULL,
    )),
    'news' => 
    Mod\News\Module::__set_state(array(
       'dir' => NULL,
       'name' => 'news',
       'full_name' => 'application/news',
       'data' => 
      array (
        'events' => 
        Reactor\Events\Module\SubscribersLoaderHelper::__set_state(array(
           'dir' => NULL,
           'name' => 'events',
           'full_name' => 'application/news/events',
           'data' => 
          array (
            'listeners' => 
            array (
              'user.deleted' => 
              array (
                'printer' => 'display',
              ),
            ),
          ),
           'parent' => NULL,
        )),
        'printer' => 
        Reactor\ServiceContainer\ServiceProvider::__set_state(array(
           'scenario' => 
          array (
            0 => 
            array (
              'type' => 'create',
              'igniter' => '\\Mod\\News\\Printer',
              'arguments' => 
              array (
              ),
            ),
          ),
           'shared' => false,
           'instance' => NULL,
        )),
      ),
       'parent' => NULL,
    )),
  ),
   'parent' => NULL,
));