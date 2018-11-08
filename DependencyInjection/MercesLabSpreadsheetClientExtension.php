<?php

namespace MercesLab\Bundle\SpreadsheetClientBundle\DependencyInjection;

use MercesLab\Component\SpreadsheetClient\Google\GoogleFactory;
use MercesLab\Component\SpreadsheetClient\Google\GoogleFile;
use MercesLab\Component\SpreadsheetClient\Google\GoogleSheet;
use MercesLab\Component\SpreadsheetClient\Google\GoogleTable;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * Class MercesLabSpreadsheetClientExtension
 * @package MercesLab\Bundle\GoogleFixturesBundle\DependencyInjection
 */
class MercesLabSpreadsheetClientExtension extends Extension
{
    /**
     * @param array                                                   $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $googleConfig = $config['google'];

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');

        if ($googleConfig['enabled']) {
            $container->setParameter(
                'merces_lab.spreadsheet_client.google.credentials',
                $config['google']['credentials']
            );

            $googleSheetsServiceDefinition = $container->getDefinition('merces_lab.spreadsheet_client.google_sheets_service');

            foreach ($googleConfig['files'] ?? [] as $configName => $fileConfig) {
                $definition = new Definition(GoogleFile::class);
                $definition->setFactory([GoogleFactory::class, 'createFile']);
                $definition->setArguments(
                    [
                        $googleSheetsServiceDefinition,
                        $fileConfig['file'],
                    ]
                );
                $container->setDefinition('merces_lab.spreadsheet_client.google.file.'.$configName, $definition);
            }

            foreach ($googleConfig['sheets'] ?? [] as $configName => $sheetConfig) {
                $definition = new Definition(GoogleSheet::class);
                $definition->setFactory([GoogleFactory::class, 'createSheet']);
                $definition->setArguments(
                    [
                        $googleSheetsServiceDefinition,
                        $sheetConfig['file'],
                        $sheetConfig['sheetName'],
                    ]
                );
                $container->setDefinition('merces_lab.spreadsheet_client.google.sheet.'.$configName, $definition);
            }

            foreach ($googleConfig['tables'] ?? [] as $configName => $tableConfig) {
                $definition = new Definition(GoogleTable::class);
                $definition->setFactory([GoogleFactory::class, 'createTable']);
                $definition->setArguments(
                    [
                        $googleSheetsServiceDefinition,
                        $tableConfig['file'],
                        $tableConfig['sheetName'],
                        $tableConfig['tableRange'],
                    ]
                );
                $container->setDefinition('merces_lab.spreadsheet_client.google.table.'.$configName, $definition);
            }
        }
    }
}
