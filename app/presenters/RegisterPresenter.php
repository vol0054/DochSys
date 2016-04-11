<?php

namespace App\Presenters;

use Latte\Runtime\Html;
class RegisterPresenter extends BasePresenter
{

	public $database;
	
	public $osCislo;
	
	private $registerFormFactory;

	public function __construct(\App\Forms\IRegisterFormFactory $rf, \Nette\Database\Context $db)
	{
		parent::__construct();
		$this->registerFormFactory = $rf;
		$this->database = $db;
	}

	public function renderDefault()
	{
		
	}

	public function createComponentRegisterForm($name)
	{
		$form = $this->registerFormFactory->create();
		$form['form']->onSuccess[] = function($form, $values)
		{
			$this->flashMessage('Byl jste úspěšně zaregistrován. Vaše uživatelské jméno je: '.$this->osCislo,'success');
//			$this->flashMessage(
//			Html::el()
//					->add('Byl jste úspěšně zaregistrován. Vaše uživatelské jméno je: ')
//					->add(Html::el('strong'))->setText($this->osCislo)
//			);
			$this->redirect('Homepage:');
		};
		return $form;
	}

}
