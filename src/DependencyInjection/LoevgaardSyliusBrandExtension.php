<?php

declare(strict_types=1);

namespace Loevgaard\SyliusBrandPlugin\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class LoevgaardSyliusBrandExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /** @var array{resources: array<string, mixed>} $config */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../../config'));

        $this->registerResources('loevgaard_sylius_brand', SyliusResourceBundle::DRIVER_DOCTRINE_ORM, $config['resources'], $container);

        $loader->load('services.php');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependSyliusGrid($container);
        $this->prependSyliusTwigHooks($container);
    }

    private function prependSyliusGrid(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('sylius_grid', [
            'grids' => [
                'loevgaard_sylius_brand_admin_brand' => [
                    'driver' => [
                        'name' => 'doctrine/orm',
                        'options' => [
                            'class' => '%loevgaard_sylius_brand.model.brand.class%',
                        ],
                    ],
                    'sorting' => [
                        'name' => 'asc',
                    ],
                    'fields' => [
                        'image' => [
                            'type' => 'twig',
                            'label' => 'loevgaard_sylius_brand.ui.image',
                            'path' => '.',
                            'options' => [
                                'template' => '@LoevgaardSyliusBrandPlugin/grid/field/image.html.twig',
                            ],
                        ],
                        'name' => [
                            'type' => 'string',
                            'label' => 'loevgaard_sylius_brand.ui.name',
                            'sortable' => null,
                        ],
                        'code' => [
                            'type' => 'string',
                            'label' => 'loevgaard_sylius_brand.ui.code',
                            'sortable' => null,
                        ],
                    ],
                    'filters' => [
                        'search' => [
                            'type' => 'string',
                            'options' => [
                                'fields' => ['code', 'name'],
                            ],
                        ],
                    ],
                    'actions' => [
                        'main' => [
                            'create' => [
                                'type' => 'create',
                            ],
                        ],
                        'item' => [
                            'update' => [
                                'type' => 'update',
                            ],
                            'delete' => [
                                'type' => 'delete',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function prependSyliusTwigHooks(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('sylius_twig_hooks', [
            'hooks' => [
                // Product form brand field
                'sylius_admin.product.create.content.form.sections.general' => [
                    'brand' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/product/form/_brand.html.twig',
                        'priority' => 250,
                    ],
                ],
                'sylius_admin.product.update.content.form.sections.general' => [
                    'brand' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/product/form/_brand.html.twig',
                        'priority' => 250,
                    ],
                ],

                // Brand update form
                'loevgaard_sylius_brand.brand.update.content' => [
                    'form' => [
                        'component' => 'loevgaard_sylius_brand:brand:form',
                        'props' => [
                            'form' => '@=_context.form',
                            'resource' => '@=_context.resource',
                            'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form.html.twig',
                        ],
                        'configuration' => [
                            'method' => 'PUT',
                        ],
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.update.content.form' => [
                    'sections' => [
                        'enabled' => false,
                    ],
                    'side_navigation' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/side_navigation.html.twig',
                        'priority' => 100,
                    ],
                    'form_sections' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.update.content.form.side_navigation' => [
                    'general' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/side_navigation/general.html.twig',
                        'configuration' => [
                            'active' => true,
                        ],
                        'priority' => 100,
                    ],
                    'media' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/side_navigation/media.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.update.content.form.form_sections' => [
                    'general' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/general.html.twig',
                        'configuration' => [
                            'active' => true,
                        ],
                        'priority' => 100,
                    ],
                    'media' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/media.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.update.content.form.form_sections.general' => [
                    'code' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/general/code.html.twig',
                        'priority' => 100,
                    ],
                    'name' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/general/name.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.update.content.form.form_sections.media' => [
                    'images' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/media/images.html.twig',
                        'priority' => 100,
                    ],
                    'add_image' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/media/add_image.html.twig',
                        'priority' => 0,
                    ],
                ],

                // Brand create form
                'loevgaard_sylius_brand.brand.create.content' => [
                    'form' => [
                        'component' => 'loevgaard_sylius_brand:brand:form',
                        'props' => [
                            'form' => '@=_context.form',
                            'resource' => '@=_context.resource',
                            'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form.html.twig',
                        ],
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.create.content.form' => [
                    'sections' => [
                        'enabled' => false,
                    ],
                    'side_navigation' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/side_navigation.html.twig',
                        'priority' => 100,
                    ],
                    'form_sections' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.create.content.form.side_navigation' => [
                    'general' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/side_navigation/general.html.twig',
                        'configuration' => [
                            'active' => true,
                        ],
                        'priority' => 100,
                    ],
                    'media' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/side_navigation/media.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.create.content.form.form_sections' => [
                    'general' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/general.html.twig',
                        'configuration' => [
                            'active' => true,
                        ],
                        'priority' => 100,
                    ],
                    'media' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/media.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.create.content.form.form_sections.general' => [
                    'code' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/general/code.html.twig',
                        'priority' => 100,
                    ],
                    'name' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/general/name.html.twig',
                        'priority' => 0,
                    ],
                ],
                'loevgaard_sylius_brand.brand.create.content.form.form_sections.media' => [
                    'images' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/media/images.html.twig',
                        'priority' => 100,
                    ],
                    'add_image' => [
                        'template' => '@LoevgaardSyliusBrandPlugin/admin/brand/form/sections/media/add_image.html.twig',
                        'priority' => 0,
                    ],
                ],
            ],
        ]);
    }
}
