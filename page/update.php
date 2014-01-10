<?php

	$updateDir = "updates";

	/**
	 * @param $root Root directory
	 * @return Array of directories inside root directory
	 */
	function getSubdirs( $root ){
		$dirs = glob( $root.'/*' , GLOB_ONLYDIR );
		$pages;
		foreach( $dirs as $d ){
			$pages[] = str_replace( $root."/", "", $d );
		}
		return $pages;
	}
	
	/**
	 * @return Array of pages inside update folder
	 */
	function getPages(){
		global $updateDir;
		return getSubdirs( $updateDir );
	}
	
	/**
	 * @param $page	Name of update page
	 * @return Array of version inside page update folder
	 */
	function getVersions($page){
		global $updateDir;
		$versions = getSubdirs( $updateDir."/".$page );
		arsort($versions);
		return $versions;
	}
	
	/**
	 * Shows files for a version of an update page
	 * @param unknown $page		Name of update page
	 * @param unknown $version	Version to show files for
	 * @return Array of update files
	 */
	function getUpdateFiles( $page, $version ){
		global $updateDir;
		$dirs = glob( $updateDir."/".$page."/".$version.'/*', GLOB_ONLYDIR );
		$all = glob( $updateDir."/".$page."/".$version.'/*' );
		$files = array_diff($all, $dirs);
		arsort($files);
		return $files;
	}
	
	/**
	 * @return Current website url
	 */
	function curPageURL() {
		$pageURL = 'http';
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].dirname($_SERVER["REQUEST_URI"]);
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].dirname($_SERVER["REQUEST_URI"]);
		}
		return $pageURL;
	}
	
	
	
	// process parameter
	if( !array_key_exists('p', $_GET) ){

		// show pages
		foreach( getPages() as $page )		
			print $page."<br>";
		
	} elseif(!array_key_exists('v', $_GET)){
		
		// show versions
		$page = $_GET['p'];
		foreach( getVersions($page) as $version )
			print $version . "<br>";
		
	} else{
		
		// show files with url
		$url = curPageURL();
		$page = $_GET['p'];
		$version = $_GET['v'];
		foreach( getUpdateFiles($page, $version) as $file )
			print $url."/".$file . "<br>";
		
	}
	
	
	
	
?>