<?php

$index = array_search('index', $methods);
if ($index !== FALSE)
{
	unset($methods[$index]);
}

$create = array_search('create', $methods);
if ($create !== FALSE)
{
	unset($methods[$create]);
}

$update = array_search('update', $methods);
if ($update !== FALSE)
{
	unset($methods[$update]);
}

$delete = array_search('delete', $methods);
if ($delete !== FALSE)
{
	unset($methods[$delete]);
}

echo $file_security;
?>


class Controller_<?php echo $class_name ?> extends Controller_Base {

<?php if ($index !== FALSE): ?>
	public function action_index()
	{
		$this->view->model = new Model_<?php echo $class_name ?>;
	}

<?php endif; ?>
<?php if ($create !== FALSE): ?>
	public function action_create()
	{
		$model = new Model_<?php echo $class_name ?>;
		$this->view->model = $model;

		if ($this->valid_post())
		{
			try
			{
				$model->set($this->request->post());
				$model->save();
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors();
			}
		}
	}

<?php endif; ?>
<?php if ($update !== FALSE): ?>
	public function action_update()
	{
		$model = new Model_<?php echo $class_name ?>($this->request->post('id'));
		$this->view->model = $model;

		if ($model->loaded())
		{
			if ($this->valid_post())
			{
				try
				{
					$model->set($this->request->post());
					$model->save();
				}
				catch (ORM_Validation_Exception $e)
				{
					$errors = $e->errors();
				}
			}
		}
	}

<?php endif; ?>
<?php if ($delete !== FALSE): ?>
	public function action_delete()
	{
		$model = new Model_<?php echo $class_name ?>($this->request->post('id'));
		$this->view->model = $model;

		if ($model->loaded())
		{
			if ($this->valid_post())
			{
				try
				{
					$model->delete();
				}
				catch (ORM_Validation_Exception $e)
				{
					$errors = $e->errors();
				}
			}
		}
	}

<?php endif; ?>
<?php if ( ! empty($methods)) foreach ($methods as $v): ?>
	public function action_<?php echo $v ?>()
	{

	}

<?php endforeach; ?>
}
