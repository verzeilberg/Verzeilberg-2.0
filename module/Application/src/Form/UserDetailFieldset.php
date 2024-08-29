<?php
namespace Application\Form;

use Application\Entity\MenuItem;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Laminas\Form\Element\Date;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use User\Entity\Permission;

class UserDetailFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('menu-item');

        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new MenuItem());

        $this->add([
            'type'  => Text::class,
            'name' => 'firstName',
            'options' => [
                'label' => 'Firstname',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'  => Text::class,
            'name' => 'lastName',
            'options' => [
                'label' => 'Lastname',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'  => Date::class,
            'name' => 'birthDate',
            'options' => [
                'label' => 'Birthdate',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'  => Textarea::class,
            'name' => 'bio',
            'options' => [
                'label' => 'Biografie',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'  => Text::class,
            'name' => 'catchLine',
            'options' => [
                'label' => 'Catch line',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

    }

    public function getInputFilterSpecification()
    {
        return [

        ];
    }
}
