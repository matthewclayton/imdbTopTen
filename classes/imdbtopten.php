<?php

class ImdbTopTen
{
	
	CONST TOPTENURL = 'http://www.imdb.com/chart/top';
	
	protected $imdbDate;
	
	protected $dateId = FALSE;
	
	protected $movieData;
	
	protected $database;
	
	protected $cache;

	public function __construct(Database $database, cache $cache)
	{
		$this->imdbDate = $_POST['imdbDate'];
		$this->database = $database;
		$this->cache = $cache;
		$this->setMovieData();
	}
	
	private function isCached()
	{
		$this->cache->setCacheData($this->dateId);
		return $this->cache->getCacheData();
	}
	
	public function getMovieData()
	{
		return $this->movieData;
	}
	
	private function getCacheArray()
	{
		foreach ($this->movieData AS $movieData) {
			$movieDataArray[] = array(
				'movie_rank' => $movieData['movie_rank'],
				'movie_title' => $movieData['movie_title'],
				'movie_year' => $movieData['movie_year'],
				'movie_rating' => $movieData['movie_rating'],
				'movie_votes' => $movieData['movie_votes'],
				'fetch_date' => $movieData['fetch_date'],
			);
		}
		return $movieDataArray;
	}
	
	private function setMovieData()
	{
		$this->setDateId();
		if ($this->isDateValid() === TRUE) {
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
				$this->cache->saveCacheData($this->dateId, $this->getCacheArray());
			}
		}
		else {
			$this->movieData = FALSE;
		}
		
	}
	
	private function isDateValid()
	{
		return is_numeric($this->dateId);
	}
	
	private function setDateId()
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