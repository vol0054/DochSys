<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use Nette\Security\User;

class SignForm extends Control
{

	/** @var User */
	private $user;

	public function __construct(User $user)
	{
		$this->user = $user;

	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/@signForm.latte');
		$this->template->render();
	}

	
	public function createComponentForm()
	{
		$form = new Form;
		
		$form->addText('username', 'Username:')
				->setRequired('Prosím, vyplňte své osobní číslo');

		$form->addPassword('password', 'Password:')
				->setRequired('prosím vyplňte heslo');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Přihlásit')
				->setAttribute('class','btn btn-default');

		$form->onSuccess[] = $this->formSucceeded;
		return $form;
	}

	public function formSucceeded(Form $form, $values)
	{
		if($values->remember){
			$this->user->setExpiration('14 days', FALSE);
		}else{
			$this->user->setExpiration('20 minutes', TRUE);
		}

		try{
			$this->user->login($values->username, $values->password);
		}catch(Nette\Security\AuthenticationException $e){
			$form->addError('The username or password you entered is incorrect.');
		}
	}

}

interface ISignFormFactory
{

	/**
	 * @return SignForm
	 */
	function create();
}

