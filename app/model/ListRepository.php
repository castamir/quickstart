<?php
namespace Todo;

use Nette;

/**
 * Tabulka user
 */
class ListRepository extends Repository
{

	public function tasksOf(Nette\Database\Table\ActiveRow $list)
	{
		return $list->related('task')->order('done, created');
	}

	public function createList($title)
	{
		return $this->getTable()->insert(array(
			'title' => $title
		));
	}
}
