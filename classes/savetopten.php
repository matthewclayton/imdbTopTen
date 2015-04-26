<?php 

class SaveTopTen extends ParseImdbHtml
{
	
	protected $dateId;
	
	protected $database;
	
	public function __construct(GetImdbHtml $imdbHtml, Database $database)
	{
		parent::__construct($imdbHtml);
		//$this->topTenMovies = $this->setTopTen();
		$this->database = $database;
	}
	
	public function saveTopTen()
	{
		$this->saveDate();
		$this->topTenMovies = $this->setTopTen();
		$this->database->setTableName('movie_data');
		$this->database->setQueryData($this->topTenMovies);
		$this->database->insertMultiple();		
	}
	
	public function saveDate()
	{
		$date = date('Y-n-j');
		$mdata = array(
				'fetch_date' => $date,
			);
		$this->database->setTableName('movie_dates');
		$this->database->setQueryData($mdata);
		$this->dateId = $this->database->insert();
	}

	
}

?>