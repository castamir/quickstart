<?php

class TaskPresenter extends BasePresenter
{

	/** @var \Nette\Database\Table\ActiveRow */
	private $list;

	public function actionDefault($id)
	{
		$this->list = $this->listRepository->find($id);
		if ($this->list === FALSE) {
			$this->setView('notFound');
		}
	}

	public function renderDefault()
	{
		$this->template->list = $this->list;
		$this->template->tasks = $this->listRepository->tasksOf($this->list);
	}
}
