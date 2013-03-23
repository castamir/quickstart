<?php
namespace Todo;

use Nette;

class ListRepository extends Repository
{

	/**
	 * Vrací úkoly spadající pod danný list.
	 *
	 * @param \Nette\Database\Table\ActiveRow $list
	 * @return Nette\Database\Table\Selection
	 */
	public function tasksOf(Nette\Database\Table\ActiveRow $list)
	{
		return $list->related('task')->order('created');
	}

	/**
	 * @param $title
	 * @return Nette\Database\Table\ActiveRow
	 */
	public function createList($title)
	{
		return $this->getTable()->insert(array(
			'title' => $title,
		));
	}

}
