<?php

namespace App\Presenters;

use Nette;
use App\Model;

class HomepagePresenter extends SecuredPresenter
{

	public $database;

	public function __construct(\Nette\Database\Context $db)
	{
		parent::__construct();
		$this->database = $db;
	}

	public function renderDefault()
	{
		$datum = date('Y-m-d');
		$this->template->date = date('Y.m.d, H:i:s');
		$select = $this->database->table('dochazka')
				->where('id_pracovnik', $this->user->identity->id)
				->where('datum', $datum);
		$row = $select->fetch();
		$row->prichod;
		//dump($row);exit;
		$this->template->prichod = $row;
	}

	public function handleLaunchStart()
	{
		$row = $this->database->query("UPDATE dochazka SET obed_start= NOW() WHERE id_pracovnik= '" . $this->user->id . "' AND datum = '" . date('Y-m-d') . "'");
		$this->flashMessage('Pauza na obed byla zahajena v ' . date('H:i:s'), 'success');
		$this->redirect('this');
	}

	public function handleLaunchStop()
	{
		$row = $this->database->query("UPDATE dochazka SET obed_end= NOW() WHERE id_pracovnik= '" . $this->user->id . "' AND datum = '" . date('Y-m-d') . "'");
		$this->flashMessage('Pauza na obed byla ukoncena v ' . date('H:i:s'), 'success');
		$this->redirect('this');
	}

}
