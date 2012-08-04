<?php



/**
 * Presenter, který zajišťuje výpis seznamů úkolů.
 */
class TaskPresenter extends BasePresenter
{

	/** @var Todo\ListRepository */
	private $listRepository;

	/** @var \Nette\Database\Table\ActiveRow */
	private $list;



	public function inject(Todo\ListRepository $listRepository)
	{
		$this->listRepository = $listRepository;
	}



	public function actionDefault($id)
	{
		$this->list = $this->listRepository->findBy(array('id' => $id))->fetch();
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
