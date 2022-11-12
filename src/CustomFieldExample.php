<?php declare(strict_types=1);

namespace NINJA\CustomFieldExample;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\System\CustomField\CustomFieldTypes;

class CustomFieldExample extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');
        $check=$customFieldSetRepository->search( (new Criteria())->addFilter(new EqualsFilter('name', 'custom_field_example')),$installContext->getContext());
        if($check->getTotal()==0) {
            $customFieldSetRepository->create([
                [
                    'name' => 'cusom_field_example',
                    'config' => [
                        'label' => [
                            'de-DE' => 'Custom Field Tab Label',
                            'en-GB' => 'Custom Field Tab Label'
                        ]
                    ],
                    'relations' => [[
                        'entityName' => 'product'
                    ]],
                    'customFields' => [
                        [
                            'name' => 'custom_field_example',
                            'type' => CustomFieldTypes::BOOL,
                            'config' => [
                                'label' => [
                                    'de-DE' => 'Deutsches Custom Field Label',
                                    'en-GB' => 'English Custom Field Label'
                                ]
                            
                            ]
                        ]
                    ]
                ]
            ], $installContext->getContext());
        }
    }
}
