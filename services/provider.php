<?php

defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Adarsh\Plugin\Content\Autotitle\Extension\Autotitle;

return new class implements ServiceProviderInterface
{
    public function register(Container $container): void
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $dispatcher = $container->get(DispatcherInterface::class);

                $plugin = PluginHelper::getPlugin('content', 'autotitle');

                return new Autotitle(
                    $dispatcher,
                    (array) $plugin
                );
            }
        );
    }
};
