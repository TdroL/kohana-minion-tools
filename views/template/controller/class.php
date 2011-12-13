<?php echo $file_security ?>


class Controller_<?php echo $class_name ?> extends Controller_Base {

<?php if ( ! empty($methods)) foreach ($methods as $v): ?>
	public function action_<?php echo $v ?>()
	{

	}

<?php endforeach; ?>
}
