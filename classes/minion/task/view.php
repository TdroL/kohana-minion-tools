<?php defined('SYSPATH') or die('No direct script access.');

class Minion_Task_View extends Minion_Task {

	public function execute(array $config)
	{
		while (ob_get_level())
			ob_end_clean();

		echo 'View name: ';
		$name = trim(fgets(STDIN));

		if (empty($name))
		{
			die('Invalid name.');
		}

		$name = trim(strtolower($name), '/');

		$view_class = View::factory('template/view/class');

		$view_mustache = View::factory('template/view/mustache');

		if ( ! $view_class OR ! $view_mustache)
		{
			die('Templates missing.');
		}

		$class_name = implode('_', array_map('ucfirst', explode('/', $name)));

		$view_class->set(array(
			'class_name' => $class_name,
			'file_security' => Kohana::FILE_SECURITY,
		));

		if (strpos($name, '/') !== FALSE)
		{
			$class_path = preg_replace('/\/[^\/]+$/i', '', $name);

			if ( ! is_dir(APPPATH.'classes/view/'.$class_path))
			{
				mkdir(APPPATH.'classes/view/'.$class_path, 0644, TRUE);
			}

			if ( ! is_dir(APPPATH.'templates/'.$class_path))
			{
				mkdir(APPPATH.'templates/'.$class_path, 0644, TRUE);
			}
		}

		file_put_contents(APPPATH.'classes/view/'.$name.'.php', $view_class);
		file_put_contents(APPPATH.'templates/'.$name.'.mustache', $view_mustache);

		echo 'Done.';
	}

}
