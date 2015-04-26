<?php

namespace App\Presenters;

use \Nette\Application\UI\Form;

/**
 * Description of UserPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class UserPresenter extends BasePresenter
{
	/** @var \App\Model\UserManager @inject */
	public $userManager;
        
	/**
	 * 
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentPasswordForm()
	{
		$form = new Form();
                $form->setRenderer(new \App\Forms\Bootstrap3FormRenderer());
		$form->addPassword('oldPassword', 'Staré heslo:', 30)
			->addRule(Form::FILLED, 'Je nutné zadat staré heslo.');
		$form->addPassword('newPassword', 'Nové heslo:', 30)
                        ->addRule(Form::FILLED, 'Je nutné zadat nové heslo.');
		$form->addPassword('confirmPassword', 'Potvrzení hesla:', 30)
			->addRule(Form::FILLED, 'Je nutné zadat potvrzení hesla.')
			->addRule(Form::EQUAL, 'Zadná hesla se musejí shodovat.', $form['newPassword']);
		$form->addProtection();
                $form->addSubmit('set', 'Změnit heslo');
		$form->onSuccess[] = array($this, 'passwordFormSubmitted');
		return $form;
	}
        
	/**
	 * Authenticates user and changes password
	 * @param Nette\Application\UI\Form $form
	 */
	public function passwordFormSubmitted(Form $form)
	{
            $values = $form->getValues();
            $user = $this->getUser();
            try {
                    $this->userManager->authenticate(array($user->getIdentity()->username, $values->oldPassword));
                    $this->userManager->changePassword($user->getIdentity()->username, $values->newPassword);
                    $this->flashMessage('Heslo bylo změněno.', 'success');
                    $this->redirect('Homepage:');
            } catch (\Nette\Security\AuthenticationException $e) {
                    $form->addError('Zadané heslo není správné.');
            }
	}
}