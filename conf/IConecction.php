<?php
interface IConecction{
 	const ENV = "PROD";
//  const ENV = "QA";
//	const ENV = "DEV";
	public function configure(&$prop);
	public function init(IConecction $clase,IConecction $clase2);	
}