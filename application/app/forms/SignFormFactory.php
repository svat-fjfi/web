<?php

namespace App\Forms;

use Nette,
    Nette\Application\UI\Form,
    Nette\Security\User;

class SignFormFactory extends Nette\Object {

    /** @var User */
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @return Form
     */
    public function create() {
        $form = new Form;
        $form->setRenderer(new \App\Forms\Bootstrap3FormRenderer());
        $form->addText('username', 'Uživatelské jméno:')
                ->setRequired('Zadejte prosím uživatelské jméno.');

        $form->addPassword('password', 'Heslo:')
                ->setRequired('Zadejte prosím heslo.');

        $form->addCheckbox('remember', 'Pamatovat si mě');

        $form->addSubmit('send', 'Přihlásit se');

        $form->onSuccess[] = array($this, 'formSucceeded');
        return $form;
    }

    public function formSucceeded($form, $values) {
        if ($values->remember) {
            $this->user->setExpiration('14 days', FALSE);
        } else {
            $this->user->setExpiration('20 minutes', TRUE);
        }

        try {
            $this->user->login($values->username, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

}
