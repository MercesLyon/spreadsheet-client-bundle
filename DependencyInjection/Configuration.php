<?php

namespace MercesLab\Bundle\SpreadsheetClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package MercesLab\Bundle\GoogleFixturesBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('merces_lab_spreadsheet_client');

        $rootNode
            ->children()
            ->arrayNode('google')
                ->isRequired()
                ->canBeDisabled()
                ->children()
                    ->scalarNode('credentials')->isRequired()->end()
                    ->arrayNode('files')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('file')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('sheets')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('file')->isRequired()->end()
                                ->scalarNode('sheetName')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('tables')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('file')->isRequired()->end()
                            ->scalarNode('sheetName')->isRequired()->end()
                            ->scalarNode('tableRange')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
