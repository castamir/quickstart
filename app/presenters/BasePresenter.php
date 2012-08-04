<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/** @var Todo\ListRepository */
	private $listRepository;



	public function injectBase(Todo\ListRepository $listRepository)
	{
		$this->listRepository = $listRepository;
	}



	public function beforeRender()
	{
		$this->template->lists = $this->listRepository->findAll()->order('title ASC');
	}

}
