<?php
namespace Application\Form;

use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Persistence\ObjectManager;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;

class UserDetailsForm extends Form
{
    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('menu-item-form');

        // The form will hydrate an object of type "UserDetail"
        $this->setHydrator(new DoctrineHydrator($objectManager));

        // Add the UserDetail fieldset, and set it as the base fieldset
        $userDetailFieldset = new UserDetailFieldset($objectManager);
        $userDetailFieldset->setUseAsBaseFieldset(true);
        $this->add($userDetailFieldset);


        // Add the Submit button
        $this->add([
            'type'  => Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Opslaan',
                'id' => 'submit',
                'class' => 'btn btn-primary',
            ],
        ]);

        // Add the CSRF field
        $this->add([
            'type' => Csrf::class,
            'name' => 'csrf',
            'options' => [
                'csrf_options' => [
                    'timeout' => 600
                ]
            ],
        ]);
    }
}
