<?php

use Nette\Application\UI\Form;

class TaskPresenter extends BasePresenter
{

	/** @var Nette\Database\Table\ActiveRow */
	private $list;

	/** @var Todo\UserRepository */
	private $userRepository;

	/** @var Todo\TaskRepository */
	private $taskRepository;

	/**
	 * @param Todo\UserRepository $userRepository
	 */
	public final function injectUserRepository(Todo\UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param Todo\TaskRepository $taskRepository
	 */
	public final function injectTaskRepository(Todo\TaskRepository $taskRepository)
	{
		$this->taskRepository = $taskRepository;
	}

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

	/**
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentTaskForm()
	{
		$userPairs = $this->userRepository->findAll()->fetchPairs('id', 'name');

		$form = new Form();
		$form->addText('text', 'Úkol:', 40, 100)->addRule(Form::FILLED, 'Je nutné zadat text úkolu.');
		$form->addSelect('userId', 'Pro:', $userPairs)->setPrompt('- Vyberte -')
			->addRule(Form::FILLED, 'Je nutné vybrat, komu je úkol přiřazen.');
		$form->addSubmit('create', 'Vytvořit');

		$form->onSuccess[] = $this->taskFormSubmitted;

		return $form;
	}

	/**
	 * @param  Nette\Application\UI\Form $form
	 */
	public function taskFormSubmitted(Form $form)
	{
		$this->taskRepository->createTask($this->list->id, $form->values->text, $form->values->userId);
		$this->flashMessage('Úkol přidán.', 'success');
		$this->redirect('this');
	}
}
