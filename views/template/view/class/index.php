<?php echo $file_security ?>


class View_<?php echo $class_name ?> {

	public function items()
	{
		$items = Model_<?php echo $model_name ?>::get_all();

		foreach ($items as & $item)
		{
			$item['urls'] = array(
				'update' => Route::url('default', [
					'controller' => '<?php echo $controller_name ?>',
					'action'     => 'update',
					'id'         => $item['id']
				]),
				'delete' => Route::url('default', [
					'controller' => '<?php echo $controller_name ?>',
					'action'     => 'delete',
					'id'         => $item['id']
				])
			);
		}

		return $items;
	}

	public function url()
	{
		return parent::url() + array(
			'create' => Route::url('default', [
				'controller' => '<?php echo $controller_name ?>',
				'action' => 'create'
			])
		);
	}

}
