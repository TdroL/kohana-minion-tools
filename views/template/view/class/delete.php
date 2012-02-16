<?php echo $file_security ?>


class View_<?php echo $class_name ?> extends View_<?php echo $layout ?> {

	public function label()
	{
		$fields = $this->model->meta()->fields();
		foreach ($fields as & $field)
		{
			$field = $field->name;
		}
		return $fields;
	}

	public function value()
	{
		return $this->model->as_array();
	}

	public function form()
	{
		$fomg = new Fomg($this->model);

		$url_cancel = Route::url('default', array(
			'controller' => '<?php echo $controller_name ?>'
		));

		$fomg->set('url.cancel', $url_cancel);
		$fomg->set('errors', $this->error);

		$fomg->set('class.form', 'form-horizontal');

		return $fomg;
	}

}
