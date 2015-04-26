<?php

class GetImdbHtml
{
	public $domDocument;
	
	public function __construct(DOMDocument $domDocument)
	{
		$this->domDocument = $domDocument;
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