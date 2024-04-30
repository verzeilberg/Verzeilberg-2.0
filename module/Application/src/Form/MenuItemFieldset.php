<?php
namespace Application\Form;

use Application\Entity\MenuItem;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Laminas\Form\Element\Date;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use User\Entity\Permission;

class MenuItemFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('menu-item');

        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new MenuItem());

        $this->add([
            'type'  => Text::class,
            'name' => 'label',
            'options' => [
                'label' => 'Label',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'  => Text::class,
            'name' => 'link',
            'options' => [
                'label' => 'Link',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'  => Text::class,
            'name' => 'icon',
            'options' => [
                'label' => 'Icon',
            ],
            'attributes' => [
                'class' => 'form-control iconpicker',
            ],
        ]);

        $this->add([
            'type'  => Text::class,
            'name' => 'menuId',
            'options' => [
                'label' => 'Menu id',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type' => ObjectSelect::class,
            'name' => 'parent',
            'options' => [
                'display_empty_item' => true,
                'empty_item_label'   => '---Maak uw keuze---',
                'object_manager' => $objectManager,
                'target_class'   => MenuItem::class,
                'property'       => 'property',
                'label' => 'Parent menu item',
                'label_generator' => function ($targetEntity) {
                    return $targetEntity->getId() . ' - ' . $targetEntity->getLabel();
                },
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type' => ObjectSelect::class,
            'name' => 'authorizedFor',
            'options' => [
                'object_manager' => $objectManager,
                'target_class'   => Permission::class,
                'property'       => 'property',
                'label' => 'Geautoriseerd voor',
                'label_generator' => function ($targetEntity) {
                    return $targetEntity->getId() . ' - ' . $targetEntity->getName();
                },
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'label' => [
                'required' => true
            ],
            'parent' => [
                'required' => false
            ],
        ];
    }
}