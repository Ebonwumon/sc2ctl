<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RecalculateGroups extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'groups:recalculate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Recalculates the groups of every SC2CTL User';

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
    $this->info("Recalculating groups...");
	  foreach (Sentry::findAllUsers() as $user) {
      $user->recalculateGroups();
    }

    $this->info("Done!");
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
