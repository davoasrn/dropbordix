<?php

class PageTree extends CWidget {

	public function run()
	{
		$pages = Page::model()->findAll();
		$level = 0;

		echo CHtml::tag('h3', array(), 'Список страниц');

		foreach ($pages as $n => $page)
		{
			if ($page->level == $level)
				echo CHtml::closeTag('li') . "\n";
			else if ($page->level>$level)
				echo CHtml::openTag('ul') . "\n";
			else
			{
				echo CHtml::closeTag('li') . "\n";

				for ($i = $level - $page->level; $i; $i--)
				{
					echo CHtml::closeTag('ul') . "\n";
					echo CHtml::closeTag('li') . "\n";
				}
			}

			echo CHtml::openTag('li');
			echo CHtml::link($page->page_title, array('/pages/default/view', 'id' => $page->id));
			$level = $page->level;
		}

		for ($i = $level; $i; $i--)
		{
			echo CHtml::closeTag('li') . "\n";
			echo CHtml::closeTag('ul') . "\n";
		}
	}

}