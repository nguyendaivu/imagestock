<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class ImageActionCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'image:action';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Image action.';

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
		$this->keyword = $this->option('keyword');
		$this->image_id = $this->option('image_id');
		$this->type 	= $this->option('type');
		$this->user_id 	= $this->option('user_id');
		$this->query 	= $this->option('query');
		$this->actionSearch();
	}

	private function actionSearch()
	{		
		$arrData = ['keyword'=>$this->keyword,
					'image_id'=>$this->image_id,
					'user_id'=>$this->user_id,
					'query'=>$this->query
				];

		switch ($this->type) {
			case 'popular-search':
				App::make('TypeImagesController')->addToPopularSearchImages($arrData);
				break;
			case 'recently-search':
				App::make('AccountController')->addToRecentlySearchImages($arrData);
				break;
			case 'recently-view':
				App::make('AccountController')->addToRecentlyViewImages($arrData);
				break;

		}
	}

/*	public function recentlySearch()
	{
		$arrData = ['keyword'=>$this->keyword,
					'image_id'=>$this->image_id,
					'user_id'=>$this->user_id,
					'query'=>$this->query
				];

		App::make('AccountController')->addToRecentlySearchImages($arrData);
	}
*/
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
			array('type', null, InputOption::VALUE_REQUIRED, 'Type of action.', null),
			array('image_id', null, InputOption::VALUE_REQUIRED, 'Image Id.', null),			
			array('keyword', null, InputOption::VALUE_OPTIONAL, 'Keyword.', null),
			array('user_id', null, InputOption::VALUE_OPTIONAL, 'User Id.', null),
			array('query', null, InputOption::VALUE_OPTIONAL, 'Query Uri.', null)
		);
	}

}
