<?php

namespace Todo;

use Nette;



class ListRepository extends Repository
{

	/**
	 * Vrac� �koly spadaj�c� pod dann� list.
	 * @return Nette\Database\Table\Selection
	 */
	public function tasksOf(Nette\Database\Table\ActiveRow $list)
	{
		return $list->related('task')->order('created');
	}

}
