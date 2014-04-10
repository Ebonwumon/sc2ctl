<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SyncGroupPermissionsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'groups:sync_permissions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sync group permissions to those currently in the application configuration';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        // TODO verify that the configuration data is good.
		foreach (Config::get("groups.permissions") as $name => $permissions) {
            try {
                $group = Sentry::findGroupByName($name);
            } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                $this->error("Could not find group with name: " . $name);
            }

            if ($permissions == null || count($permissions) == 0) {
                $this->error("Error processing permissions for " . $name);
            }
            $oldPermissions = $group->getPermissions();
            // We get the difference in the keys, which are the permission names
            $diff = array_diff(array_keys($oldPermissions), array_keys($permissions));
            $disabledPermissions = array();
            foreach ($diff as $difference) {
                $disabledPermissions[$difference] = 0;
            }
            $group->permissions = array_merge($disabledPermissions, $permissions);

            $group->save();
        }

        $this->info("Completed!");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
		);
	}

}
