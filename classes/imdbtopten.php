<?php

class ImdbTopTen
{
	
	CONST TOPTENURL = 'http://www.imdb.com/chart/top';
	
	//CONST TODAYSDATE = date('Y-n-j');
	
	protected $imdbDate;
	protected $dateId = FALSE;
	protected $movieData;
	
	protected $database, $cache;

	public function __construct(Database $database, cache $cache)
	{
		$this->imdbDate = $_POST['imdbDate'];
		$this->database = $database;
		$this->cache = $cache;
		$this->setMovieData();
	}
	
	public function isCached()
	{
		$this->cache->setCacheData($this->dateId);
		return $this->cache->getCacheData();
	}
	
	public function getMovieData()
	{
		return $this->movieData;
	}
	
	public function setMovieData()
	{
		$this->setDateId();
		if ($this->checkDateExists() === TRUE) {
			if ($this->isCached() !== FALSE) {
				$this->movieData = $this->cache->cacheData;
			}
			else {
				$queryArray = array(
					'movie_data.date_id' => $this->dateId,
				);
				$this->database->setTableName('movie_data');
				$this->database->setQueryData($queryArray);
				$this->movieData = $this->database->joinSelect('movie_dates', 'date_id');
			}
		}
		else {
			$this->movieData = FALSE;
		}
		
	}
	
	public function checkDateExists()
	{
		return is_numeric($this->dateId);
	}
	
	public function setDateId()
	{
		$queryArray = array(
			'fetch_date' => $this->imdbDate,
		);
		$this->database->setTableName('movie_dates');
		$this->database->setQueryData($queryArray);
		$result = $this->database->select();
		if ($row = $result->fetch_object()) {
			$this->dateId = $row->date_id;
		}
	}
	
}

?>