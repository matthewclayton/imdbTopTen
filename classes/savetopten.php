<?php 

class SaveTopTen extends ParseImdbHtml
{

	protected $database;
	
	protected $dateQueryData;
	
	public function __construct(DomXPath $domXPath, Database $database)
	{
		parent::__construct($domXPath);
		$this->database = $database;
		$this->setDateQueryData();
		$this->saveDate();
		$this->setTopTen();
		$this->saveTopTen();
	}
	
	protected function getDateId()
	{
		return $this->database->getLastInsertId();
	}
	
	private function saveTopTen()
	{
		$this->database->setTableName('movie_data');
		$this->database->setQueryData($this->topTenMovies);
		$this->database->insertMultiple();		
	}
	
	private function setDateQueryData()
	{
		$date = date('Y-n-j');
		$this->dateQueryData = array(
				'fetch_date' => $date,
			);
	}
	
	private function saveDate()
	{
		$this->database->setTableName('movie_dates');
		$this->database->setQueryData($this->dateQueryData);
		$this->database->insert();
	}

	
}

?>