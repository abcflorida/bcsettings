reads installed and enabled extensions and provides a user interface to update and maintain extension configurations.

---

### Blade Calls

`@setting('slug')`

returns the configuration value.

---

### When should I use it?

Each extension created for platform has an extension.php file with a section devoted to the creation of settings. Settings will read this section and automatically generate the necessary fields to collect the information. This information is then stored to the database config table.

---

### How can I use it?

You can add settings to your extensions by updating the extensions `extension.php` file.

	'settings' => function(Settings $settings, Application $app)
	{
		$settings->find('platform')->section('my-tab', function($s)
		{
			$s->fieldset('general', function($f)
			{
				$f->name = 'My Tab';

				$f->field('label', function($f)
				{
					$f->name   = 'field-name';
					$f->info   = 'field description';
					$f->type   = 'input|radio|select|checkbox|textarea';
					$f->config = 'vendor/extension::config';

					$f->option('enabled', function($o)
					{
						$o->value = true;
						$o->label = 'option label';
					});

					$f->option('disabled', function($o)
					{
						$o->value = false;
						$o->label = 'option label';
					});
				});

			});
		});
	},
