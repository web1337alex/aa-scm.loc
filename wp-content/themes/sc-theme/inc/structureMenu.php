<?php

class StructureMenu {
	// название зарегистрированного меню
	private $menu_name = '';

	/** @var WP_Post[] - не сортированные пункты меню */
	private $menu_items = [];

	/** @var WP_Post[] - сортированные пункты меню */
	private $menu_struct_items = [];

	public function __construct(string $menu_name) {
		$this->menu_name = $menu_name;

	}

	public function getItemsStructureMenu(): array {
		if (empty($this->menu_name)) {
			return [];
		}

		$locations = get_nav_menu_locations();

		if ($locations && isset($locations[$this->menu_name])) {
			// получаем элементы меню
			$this->menu_items = wp_get_nav_menu_items($locations[$this->menu_name]);

			$this->menu_struct_items = $this->_sortStructureMenu();
		}

		return $this->menu_struct_items;
	}

	private function _sortStructureMenu(): array {
		if (empty($this->menu_name)) {
			return [];
		}

		$result = [];

		// текущий левел, меню всегда начинает с первого уровня
		$current_level = 1;

		// сюда складываем  ссылки на последние айтемы в каждом уровне
		$last_level_item_menu = [];

		foreach ($this->menu_items as &$menu_item) {
			// Определяем уровень
			if ($menu_item->menu_item_parent == 0) {
				// у первого уровня этот параметр всегда 0
				$current_level = 1;
			} else {
				// $current_level все еще от предыдущего айтема
				if ($last_level_item_menu[$current_level]->ID == $menu_item->menu_item_parent) {
					// значит предыдущий был нашим предком - повысим текущий уровень
					$current_level++;
				} else if (isset($last_level_item_menu[$current_level - 1]) 
							&& $last_level_item_menu[$current_level - 1]->ID == $menu_item->menu_item_parent) {
					// у нас один и тот же предок с предыдущим
					// мы на том же уровне
				} else {
					// уровень снизился ищем предка по всему массиву,
					// по сути две предыдущие проверки нужны чтоб поменьше бегать по этому массиву
					foreach ($last_level_item_menu as $level => $item_menu) {
						/*  @var  WP_Post $item_menu */
						if ($item_menu->ID == $menu_item->menu_item_parent) { // вот он наш предок
							// накидываем к его левелу
							$current_level = $level + 1;
							break;
						}
					}

				}
			}

			// для наследников складываем ссылку на текущий левел
			$last_level_item_menu[$current_level] = &$menu_item;

			// по вкусу добавляем левел, и не ноем больше, что его нет #тыж_программист :)
			$last_level_item_menu[$current_level]->level_menu = $current_level;

			if ($current_level === 1) { // первый уровень складываем в наш структурный массив
				$result[] = $menu_item;
			} else {
				// если это первый чилдрен
				if (!isset($last_level_item_menu[$current_level - 1]->sub_item_menu)) {
					$last_level_item_menu[$current_level - 1]->sub_item_menu = [];
				}

				// наш предок на уровень выше
				$last_level_item_menu[$current_level - 1]->sub_item_menu[] = $last_level_item_menu[$current_level];
			}
		}

		return $result;
	}
}

?>