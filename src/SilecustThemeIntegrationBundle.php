<?php

namespace Silecust\ThemeIntegrationBundle;

use Silecust\ThemeIntegrationBundle\Compiler\TwigCompilerPass;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SilecustThemeIntegrationBundle extends AbstractBundle
{
    public const string PLUGIN_NAME_STRING = 'silecust.theme_integration';

    public function getPath(): string
    {
        return __DIR__;

    }

    public function configure(DefinitionConfigurator $definition): void
    {
        // @formatter:off
        $definition
            ->rootNode()
                ->children()
                    ->scalarNode('theme_integration_active')
                        ->defaultFalse()
                    ->end()
                ->end()
                ->children()
                    ->arrayNode("theme_bundles")
                        ->arrayPrototype()
                            ->scalarPrototype('active')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ;

        // @formatter:on
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {


        $container->import(dirname(__DIR__) . '/src/config/services.php');
        // set parameters
        $builder->setParameter('silecust.theme_integration.theme_integration_active', $config['theme_integration_active']);

        foreach ($config['theme_bundles'] as $key => $value) {
            if (isset($value['active']) && $value['active']) {
                // theme bundle name
                $builder->setParameter('silecust.theme_integration.active_theme_bundle', $value['bundle_name']);

                $bundleList = $builder->getParameter('kernel.bundles');

                $bundleNameWithoutBundle = ltrim($value['bundle_name'], "@");
                $bundleFullName = $bundleList[$bundleNameWithoutBundle];

                $refClass = new \ReflectionClass($bundleFullName);
                $dirname = dirname($refClass->getFileName(), 2);

                $builder->setParameter('silecust.theme_integration.theme_template_path',
                    $dirname . '/templates');

            }
        }

       


    }

    public function build(ContainerBuilder $container): void
    {

        $container->addCompilerPass(new TwigCompilerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, -10);

    }

}