<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_Controller extends Minion_Task {

	public function execute(array $config)
	{
		while (ob_get_level())
			ob_end_clean();

		echo 'Controller name: ';
		$name = trim(fgets(STDIN));

		if (empty($name))
		{
			die('Invalid name.');
		}

		$name = trim(strtolower($name), '/');

		echo 'Methods: ';
		$methods = explode(' ', trim(strtolower(fgets(STDIN))));

		$controller_class = View::factory('template/controller/class');

		if ( ! $controller_class)
		{
			die('Template missing.');
		}

		$class_name = implode('_', array_map('ucfirst', explode('/', $name)));

		$controller_class->set(array(
			'class_name' => $class_name,
			'file_security' => Kohana::FILE_SECURITY,
			'methods' => $methods,
		));

		if (strpos($name, '/') !== FALSE)
		{
			$class_path = preg_replace('/\/[^\/]+$/i', '', $name);

			if ( ! is_dir(APPPATH.'templates/'.$class_path))
			{
				mkdir(APPPATH.'templates/'.$class_path, 0644, TRUE);
			}
		}

		file_put_contents(APPPATH.'classes/controller/'.$name.'.php', $controller_class);

		echo 'Done.';
	}

}
