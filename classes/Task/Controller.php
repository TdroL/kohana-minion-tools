<?php defined('SYSPATH') or die('No direct script access.');

class Task_Controller extends Minion_Task {

	protected $_defaults = [
		'name' => NULL,
		'methods' => NULL
	];

	protected function _execute(array $params)
	{
		while (ob_get_level()) ob_end_clean();

		$opts = CLI::options();

		$name = Arr::get($opts, 'name');

		if (empty($name))
		{
			echo 'Controller name: ';
			$name = trim(fgets(STDIN));

			if (empty($name))
			{
				die('Invalid name.');
			}
		}

		$name = trim(strtolower($name), '/');

		$methods = Arr::get($opts, 'methods');

		if (empty($methods))
		{
			echo 'Methods: ';
			$methods = explode(' ', trim(strtolower(fgets(STDIN))));
		}
		else
		{
			$methods = explode(',', trim(strtolower($methods)));
		}

		$controller_class = View::factory('template/controller/class');

		if ( ! $controller_class)
		{
			die('Template missing.');
		}

		$class_name = implode('_', array_map('ucfirst', explode('/', $name)));

		$short_class_name = strtolower(preg_replace('/.*_([^_]+)$/i', '$1', '_'.$class_name));

		$model_name = ucfirst($short_class_name);

		$controller_class->set([
			'class_name' => $class_name,
			'short_class_name' => $short_class_name,
			'model_name' => $model_name,
			'file_security' => Kohana::FILE_SECURITY,
			'methods' => $methods,
		]);

		if (strpos($name, '/') !== FALSE)
		{
			$class_path = preg_replace('/\/[^\/]+$/i', '', $name);

			if ( ! is_dir(APPPATH.'templates/'.$class_path))
			{
				mkdir(APPPATH.'templates/'.$class_path, 0644, TRUE);
			}
		}

		$name_uc = str_replace(' ','_', ucwords(str_replace('_',' ',$name)));
		file_put_contents(APPPATH.'classes/Controller/'.$name_uc.'.php', $controller_class);

		echo 'Done.';
	}

}
