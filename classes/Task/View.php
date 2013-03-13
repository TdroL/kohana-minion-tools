<?php defined('SYSPATH') or die('No direct script access.');

class Task_View extends Minion_Task {

	protected $_defaults = [
		'views' => NULL,
		'standalone' => NULL,
		'layout' => 'layout',
	];

	protected function _execute(array $config)
	{
		while (ob_get_level()) ob_end_clean();

		$opts = CLI::options();

		// get views
		$views = Arr::get($opts, 'views');

		if (empty($views))
		{
			echo 'Views: ';
			$views = trim(fgets(STDIN));

			if (empty($views))
			{
				die('Invalid name.');
			}

			$views = explode(' ', strtolower($views));
		}
		else
		{
			$views = explode(',', strtolower($views));
		}

		// get standalone
		$standalone = Arr::get($opts, 'standalone');

		if (empty($standalone))
		{

			echo 'Standalone views: ';
			$standalone = trim(fgets(STDIN));

			if ( ! empty($standalone))
			{
				$standalone = explode(' ', strtolower($standalone));
			}
		}
		else
		{
			$standalone = explode(',', strtolower($standalone));
		}

		if ( ! empty($standalone) AND is_array($standalone))
		{
			$standalone = array_flip($standalone);
		}
		else
		{
			$standalone = [];
		}

		// get layout
		$layout = Arr::get($opts, 'layout');

		if (empty($layout))
		{
			echo 'Layout (default: "layout"): ';
			$layout = strtolower(trim(fgets(STDIN)));
		}

		// generate views
		foreach ($views as $view)
		{
			$this->_create_view($view, (bool) isset($standalone[$view]), $layout);
		}

		echo 'Done.';
	}

	protected function _create_view($view, $standalone = FALSE, $layout = NULL)
	{
		$layout = empty($layout) ? 'layout' : $layout;

		// try special class
		$view_type = $view;
		if (($pos = strrpos($view_type, '/')) !== FALSE)
		{
			$view_type = substr($view_type, $pos+1);
		}

		try
		{
			$view_class = View::factory('template/view/class');
			$view_class = View::factory('template/view/class/'.$view_type);
		}
		catch(View_Exception $e) { /* ignore errors */}

		$view_form_partiall = FALSE;
		try
		{
			$view_mustache = View::factory('template/view/mustache');
			$view_mustache = View::factory('template/view/mustache/'.$view_type);
			$view_form_partial = View::factory('template/view/mustache/_form');
		}
		catch(View_Exception $e) { /* ignore errors */}

		if ( ! $view_class OR ! $view_mustache)
		{
			die('Templates missing.');
		}

		$class_name = implode('_', array_map('ucfirst', explode('/', $view)));
		$controller_name = preg_replace('/^(?:.+\/)?([^\/]+)\/.+$/i', '$1', $view);
		$controller_path = preg_replace('/\/[^\/]+$/i', '', $view);
		$model_name = ucfirst($controller_name);

		$view_class->set([
			'class_name' => $class_name,
			'controller_name' => $controller_name,
			'controller_path' => $controller_path,
			'model_name' => $model_name,
			'layout' => $layout,
			'standalone' => $standalone,
			'file_security' => Kohana::FILE_SECURITY,
		]);

		$view_mustache->set([
			'class_name' => $class_name,
			'controller_name' => $controller_name,
			'controller_path' => $controller_path,
			'model_name' => $model_name,
			'layout' => $layout,
			'standalone' => $standalone,
			'file_security' => Kohana::FILE_SECURITY,
		]);

		$view_form_partial->set([
			'class_name' => $class_name,
			'controller_name' => $controller_name,
			'controller_path' => $controller_path,
			'model_name' => $model_name,
			'layout' => $layout,
			'standalone' => $standalone,
			'file_security' => Kohana::FILE_SECURITY,
		]);

		$controller_path_uc = str_replace(' ','_', ucwords(str_replace('_',' ',$controller_path)));

		$view_uc = str_replace(' ','_', ucwords(str_replace('_',' ',$view)));

		if (strpos($view, '/') !== FALSE)
		{
			if ( ! is_dir(APPPATH.'classes/View/'.$controller_path_uc))
			{
				mkdir(APPPATH.'classes/View/'.$controller_path_uc, 0644, TRUE);
			}

			if ( ! is_dir(APPPATH.'templates/'.$controller_path))
			{
				mkdir(APPPATH.'templates/'.$controller_path, 0644, TRUE);
			}
		}

		file_put_contents(APPPATH.'classes/View/'.$view_uc.'.php', $view_class);
		file_put_contents(APPPATH.'templates/'.$view.'.mustache', $view_mustache);

		if ($view_form_partial)
		{
			file_put_contents(APPPATH.'templates/'.$controller_path.'/_form.mustache', $view_form_partial);
		}
	}

}
