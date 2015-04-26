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
	}
	
	public function isCached()
	{
		$this->cache->setCacheData($this->dateId);
		return $this->cache->getCacheData();
	}
	
	public function setDateData()
	{
		$this->setDateId();
		if ($this->checkDateExists() === FALSE)
		{
			$this->movieData = FALSE;
		}
		
		if ($this->isCached() !== FALSE)
		{
			$this->movieData = $this->cache->cacheData;
		}
		else
		{
			$queryArray = array(
				'movie_data.date_id' => $this->dateId,
			);
			$this->database->setTableName('movie_data');
			$this->database->setQueryData($queryArray);
			$this->movieData = $this->database->joinSelect('movie_dates', 'date_id');
		}
		
	}
	
	public function t()
	{
		echo '<table style="width:50%">';
		echo '<tr> <td> Rank </td> <td> Title </td> <td> Year </td> <td> 
		Rating </td> <td> Votes </td> <td> Date Added </td> </tr>';
		foreach ($this->movieData as $key => $movie) {
			echo '<tr>';
			echo ' <td> ' . $movie['movie_rank'] . 
			' </td><td> ' . $movie['movie_title'] . 
			' </td><td> ' . $movie['movie_year'] . 
			' </td><td> ' . $movie['movie_rating'] . 
			' </td><td> ' . $movie['movie_votes'] .
			' </td><td> ' . $movie['fetch_date'] .
			'</td>';
			echo '</tr>';
		}
		echo '</table>';
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