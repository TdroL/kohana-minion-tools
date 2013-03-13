<?php echo $file_security ?>


class View_<?php echo $class_name ?> {

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

}
