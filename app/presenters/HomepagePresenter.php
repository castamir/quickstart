<?php

/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	/** @var Todo\TaskRepository */
	private $taskRepository;

	/**
	 * @param Todo\TaskRepository $taskRepository
	 */
	public final function injectTaskRepository(Todo\TaskRepository $taskRepository)
	{
		$this->taskRepository = $taskRepository;
	}

	public function renderDefault()
	{
		$this->template->tasks = $this->taskRepository->findIncomplete();
	}

	public function createComponentIncompleteTasks()
	{
		return new Todo\TaskListControl($this->taskRepository->findIncomplete(), $this->taskRepository);
	}

}
