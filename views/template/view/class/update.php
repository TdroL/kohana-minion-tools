<?php echo $file_security ?>


<?php if ( ! $standalone): ?>
class View_<?php echo $class_name ?> extends View_<?php echo str_replace('_Update', '_Create', $class_name) ?> {}
<?php else: ?>
class View_<?php echo $class_name ?> extends View_<?php echo $layout ?> {

	protected $_partials = array(
		'form' => '<?php echo $controller_path ?>/_form'
	);

	public function form()
	{
		$fomg = new Fomg($this->model);

		$url_cancel = Route::url('default', array(
			'controller' => '<?php echo $controller_name ?>'
		));

		$fields = array();

		$fomg->set('url.cancel', $url_cancel);
		$fomg->set('errors', $this->error);
		$fomg->set('allowed', $fields);

		$fomg->set('class.form', 'form-horizontal');
		$fomg->set('class.input:all', 'input-xlarge');

		return $fomg;
	}

}
<?php endif ?>