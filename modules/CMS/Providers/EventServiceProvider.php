<?php namespace KodiCMS\CMS\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'backend.settings.validate' => [
			'\KodiCMS\CMS\Handlers\Events\SettingsValidate'
		],
		'backend.settings.save' => [
			'\KodiCMS\CMS\Handlers\Events\SettingsSave'
		]
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		$events->listen('view.settings.bottom', function() {
			WYSIWYG::loadAll();
			echo view('cms::ace.settings')->with('availableACEThemes', config('cms.wysiwyg.ace_themes'));
		});

		$events->listen('view.menu', function($navigation) {
			echo view('cms::navigation.list')->with('navigation', $navigation);
		});
	}
}
