<?php

namespace App\Presenters;

use Nette;
use App\Forms\SignFormFactory;

class SignPresenter extends BasePresenter
{

	public $signFormFactory;
	
	public $database;
	
	public function __construct(\Nette\Database\Context $db, \App\Forms\ISignFormFactory $sf)
	{
		parent::__construct();
		$this->database = $db;
		$this->signFormFactory = $sf;
	}


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm($name)
	{
		$form = $this->signFormFactory->create();
		$form['form']->onSuccess[] = function ($form, $values)
		{
			$this->database->query("INSERT dochazka", [
					'id_pracovnik' => $this->user->id,
					'datum' => date('Y-m-d'),
					'prichod' => date('Y-m-d H:i:s'),
					]);
			$form->getPresenter()->redirect('Homepage:');
		};
		return $form;
	}

	public function actionOut()
	{
		$this->getUser()->logout();
	}

}
