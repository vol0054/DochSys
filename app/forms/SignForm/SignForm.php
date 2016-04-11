<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Control;
use Nette\Security\User;

class SignForm extends Control
{

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;

	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}

	public function render()
	{
		$this->template->setFile(__DIR__.'/@signForm.latte');
		$this->template->render();
	}
	/**
	 * @return Form
	 */
	public function createComponent()
	{
		$form = new Form;
		$form = $this->factory->create();
		$form->addText('username', 'Username:')
				->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
				->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

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
