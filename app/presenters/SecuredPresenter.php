<?php

namespace App\Presenters;

use Nette\Security\User;

/**
 * Description of SecuredPresenter
 *
 * @author KytaVeprova
 */
class SecuredPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		$user = $this->getUser();

		if(!$user->isLoggedIn()){
			if($this->user->getLogoutReason() === User::INACTIVITY)
			{
				$this->flashMessage('Byl jsi odhlášen kvůli neaktivitě.', 'info');
			}
			$this->redirect('Sign:in');
		}
	}
	
	/**
	 * Logout user
	 */
	public function handleLogout()
	{
		$datum = date('Y-m-d');
		$this->database->query("UPDATE dochazka SET odchod = NOW() WHERE id_pracovnik= '". $this->user->id."' AND datum = '".$datum."' AND odchod is null");		
		$this->user->logout();		
		$this->flashMessage('Byl jsi úspěšně odhlášen.','success');
		$this->redirect('Homepage:');
	}
}
