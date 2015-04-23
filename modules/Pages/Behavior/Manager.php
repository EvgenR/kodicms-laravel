<?php namespace KodiCMS\Pages\Behavior;

use KodiCMS\Pages\Exceptions\BehaviorException;

class Manager
{
	/**
	 * @var array
	 */
	protected static $behaviors = [];

	public static function init()
	{
		foreach (config('behaviors', []) as $name => $params)
		{
			if (empty($params['class'])) continue;

			static::$behaviors[$name] = $params;
		}
	}

	public static function load($behavior)
	{
		$behaviorParams = static::getBehavior($behavior);

		$behaviorClass = $behaviorParams['class'];
		if (!class_exists($behaviorClass))
		{
			throw new BehaviorException("Behavior class \"{$behaviorClass}\" not found!");
		}

		unset($behaviorParams['class']);

		return new $behaviorClass($behaviorParams);
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	public static function getBehavior($name)
	{
		return array_get(static::$behaviors, $name);
	}

	/**
	 * @return array
	 */
	public static function getBehaviorsList()
	{
		return array_keys(static::$behaviors);
	}

	/**
	 * @return array
	 */
	public static function formChoices()
	{
		$options = ['' => trans('cms::core.label.not_set')];

		foreach(static::$behaviors as $name => $params)
		{

			if(isset($params['title']))
			{
				$title = $params['title'];
			}
			else
			{
				$title = ucfirst($name);
			}

			$options[$name] = $title;
		}

		return $options;
	}
}