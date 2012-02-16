<?php

$index  = array_search('index',  $methods);
$create = array_search('create', $methods);
$update = array_search('update', $methods);
$delete = array_search('delete', $methods);

unset($methods[$index], $methods[$create], $methods[$update], $methods[$delete]);

echo $file_security;
?>


class Controller_<?php echo $class_name ?> extends Controller_Base {

<?php if ($index !== FALSE): ?>
	public function action_index() {}

<?php endif; ?>
<?php if ($create !== FALSE): ?>
	public function action_create()
	{
		$this->view->model = new Model_<?php echo $model_name ?>;
		$model = $this->view->model;

		$location = Route::get('default')->uri(array(
			'controller' => '<?php echo $short_class_name ?>'
		));

		if ($this->valid_post())
		{
			try
			{
				$model->set_safe($this->request->post());
				$model->save();

				$message = __(Kohana::message('common', 'resource_created'));

				if ($this->request->is_initial())
				{
					$this->session->set('flash', array(
						'type' => 'success',
						'message' => $message
					));
					HTTP::redirect(302, $location);
				}

				$this->view->message($message);
			}
			catch (Jelly_Validation_Exception $e)
			{
				$this->view->errors($e->errors('validation'));
			}
		}
	}

<?php endif; ?>
<?php if ($update !== FALSE): ?>
	public function action_update()
	{
		$this->view->model = new Model_<?php echo $model_name ?>($this->request->param('id'));
		$model = $this->view->model;

		$location = Route::get('default')->uri(array(
			'controller' => '<?php echo $short_class_name ?>'
		));

		if ( ! $model->loaded())
		{
			$message = __(Kohana::message('common', 'not_found'));

			if ($this->request->is_initial())
			{
				$this->session->set('flash', array(
					'type' => 'error',
					'message' => $message
				));
				HTTP::redirect(302, $location);
			}
			else
			{
				$this->response->status(404);
				$this->view->errors(array(
					'id' => $message
				));
				return;
			}
		}

		if ($this->valid_post())
		{
			try
			{
				$model->set_safe($this->request->post());
				$model->save();

				$message = __(Kohana::message('common', 'resource_updated'));

				if ($this->request->is_initial())
				{
					$this->session->set('flash', array(
						'type' => 'success',
						'message' => $message
					));
					HTTP::redirect(302, $location);
				}

				$this->view->message($message);
			}
			catch (Jelly_Validation_Exception $e)
			{
				$this->view->errors($e->errors('validation'));
			}
		}
	}

<?php endif; ?>
<?php if ($delete !== FALSE): ?>
	public function action_delete()
	{
		$this->view->model = new Model_<?php echo $model_name ?>($this->request->param('id'));
		$model = $this->view->model;

		$location = Route::get('default')->uri(array(
			'controller' => '<?php echo $short_class_name ?>'
		));

		if ( ! $model->loaded())
		{
			$message = __(Kohana::message('common', 'not_found'));

			if ($this->request->is_initial())
			{
				$this->session->set('flash', array(
					'type' => 'error',
					'message' => $message
				));
				HTTP::redirect(302, $location);
			}
			else
			{
				$this->response->status(404);
				$this->view->errors(array(
					'id' => $message
				));
				return;
			}
		}

		if ($this->valid_post())
		{
			try
			{
				$model->delete();

				$message = __(Kohana::message('common', 'resource_deleted'));

				if ($this->request->is_initial())
				{
					$this->session->set('flash', array(
						'type' => 'success',
						'message' => $message
					));
					HTTP::redirect(302, $location);
				}

				$this->view->message($message);
			}
			catch (Jelly_Validation_Exception $e)
			{
				$this->view->errors($e->errors('validation'));
			}
		}
	}

<?php endif; ?>
<?php if ( ! empty($methods)) foreach ($methods as $v): ?>
	public function action_<?php echo $v ?>() {}

<?php endforeach; ?>
}
