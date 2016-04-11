<?php

namespace App\Forms;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Kdyby\Doctrine\EntityManager;
use App\Model\Entities\Admin;
use App\Model\Entities\Pracovnik;
use Nette\Security\Passwords;


class RegisterForm extends Control
{

	private $database;

	public function __construct(\Nette\Database\Context $db)
	{
		$this->database = $db;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . '/@registerForm.latte');
		$this->template->render();
	}

	public function createComponentForm()
	{
		$form = new Form;

		$form->addText('name', 'Jmeno:')
				->addRule(Form::FILLED, 'vyplnte sve jmeno')
				// na prvni pozici musi byt a-Z bez cisla, dalsi uz muze byt kterekoli pismeno nebo cislice plus "_". ^ a $ oznacuje zacatek a konec vyhledavaciho retezce - musi tam byt. 
				;//->addRule(Form::PATTERN, 'Jméno musi obsahovat znaky "a-Z" a "_". Jméno musí začínat písmenem', '^[a-zA-Z]*$');
		$form->addText('surname')
				->addRule(Form::FILLED, 'vyplnte sve prijmeni')
				;//->addRule(Form::PATTERN, 'Jméno musi obsahovat znaky "a-Z" a "_". Jméno musí začínat písmenem', '^[a-zA-Z]*$');
		$form->addPassword('password', 'Heslo *', 20)
				->setOption('description', 'alespoň 6 znaků')
				->addRule(Form::FILLED, 'Prosím vyplňte své heslo')
		; //->addRule(Form::MIN_LENGTH, 'Vaše heslo musí obsahovat alespoň %d znaků.', 6);
		$form->addPassword('password2', 'heslo znova: *', 20)
				->addConditionOn($form['password'], Form::VALID)
				->addRule(Form::FILLED, 'Zadejte heslo znovu')
				->addRule(Form::EQUAL, 'Hesla se neshodují.', $form['password']);
		$form->addHidden('osCislo');
		$form->addSubmit('submit', 'Registrovat');

		$form->onSuccess[] = $this->handleSuccessForm;

		return $form;
	}

	/**
	 * 
	 * @param Form $form
	 * @param $values
	 */
	public function handleSuccessForm(Form $form, $values)
	{
		$prijmeni = substr($values->surname, 3);
		$min = pow(10, 3 - 1);
		$max = pow(10, 3) - 1;
		$cislo = rand($min, $max);
		$osCislo = substr($values->surname, 0, 3).$cislo;
		$this->presenter->osCislo = $osCislo;
		$this->database->query('INSERT INTO pracovnik', [
				'os_cislo' => $osCislo,
				'jmeno' => $values->name,
				'prijmeni' => $values->surname,
				'heslo' => Passwords::hash($values->password)
		]);
		return $osCislo;
	}

}

interface IRegisterFormFactory
{

	/**
	 * @return RegisterForm
	 */
	function create();
}
