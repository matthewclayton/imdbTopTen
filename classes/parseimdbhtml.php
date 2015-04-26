<?php

class ParseImdbHtml
{
	
	protected $domXPath;
	
	protected $topTenMovies = array();
	
	public function __construct(DomXPath $domXPath)
	{
		$this->domXPath = $domXPath;
	}
	
	private function filterHtml()
	{
		return $this->domXPath->query("//*[contains(@class, 'odd')]|//*[contains(@class, 'even')]");
	}
	
	protected function setTopTen()
	{
		$moviesHtml = $this->filterHtml();
		$movieCount = 1;
		$dateId = $this->getDateId();
		foreach ($moviesHtml AS $movieHtml) {
			if ($movieCount <= 10) {
				$this->topTenMovies[] = array(
					'date_id' => $dateId,
					'movie_rank' => $movieCount,
					'movie_title' => $this->getTitle($movieHtml),
					'movie_year' => $this->getYear($movieHtml),
					'movie_rating' => $this->getRating($movieHtml),
					'movie_votes' => $this->getVotes($movieHtml),
				);
			}
			$movieCount++;
		}
	}
	
	private function getTitle($movieHtml)
	{
		$getTitle = $movieHtml->getElementsByTagName('a');
		return $getTitle->item(1)->nodeValue;
	}
	
	private function getYear($movieHtml)
	{
		$getYear = $movieHtml->getElementsByTagName('span');
		$movieYearData = $getYear->item(1)->getAttribute('data-value');
		return substr($movieYearData, 0, 4);
	}
	
	private function getRatingsData($movieHtml)
	{
		$getRating = $movieHtml->getElementsByTagName('strong');
		return $getRating->item(0)->getAttribute('title'); 
	}
	
	private function getRating($movieHtml) 
	{
		return substr($this->getRatingsData($movieHtml), 0, 3);
	}
	
	private function getVotes($movieHtml)
	{
		$movieVotesHtml = $this->getRatingsData($movieHtml);
		$movieVotesBegin = strpos($movieVotesHtml, 'on') + 3;
		$movieVotesEnd = strpos($movieVotesHtml, 'votes') - $movieVotesBegin;
		return substr($movieVotesHtml, $movieVotesBegin, $movieVotesEnd); 
	}
	
}

?>