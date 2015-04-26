<?php

class GetImdbHtml
{
	public $domDocument;
	
	public function __construct()
	{
		$this->domDocument = new DOMDocument();
		$this->setHtml();
	}
	
	private function getHtml()
	{
		return file_get_contents(ImdbTopTen::TOPTENURL);
	}
	
	private function setHtml()
	{
		@$this->domDocument->loadHtml($this->getHtml());
	}
}

?>