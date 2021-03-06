<?php 

class Cache
{
	public $cacheData;
	
	protected $memCache;
	
	public function __construct(Memcached $memCache)
	{
		$this->memCache = $memCache;
		$this->memCache->addServer('127.0.0.1', 11211);
	}
	
	public function setCacheData($cacheKey)
	{
		$this->cacheData = $this->memCache->get($cacheKey);
	}
	
	public function getCacheData()
	{
		return $this->cacheData;
	}
	
	public function saveCacheData($cacheKey, $cacheArray)
	{
		$this->memCache->set($cacheKey, $cacheArray);
	}
}

?>