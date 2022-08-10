<?php
class utf8 {
	/**
	 * Codifica una cadena o un array a UTF8
	 *
	 * @param unknown $dat        	
	 * @return string|unknown|multitype:Ambigous <unknown, string, multitype:Ambigous <string, unknown> >
	 */
	public function utf8_encode_all($dat) // -- It returns $dat encoded to UTF8
{
		if (is_string ( $dat )) {
			if (! mb_detect_encoding ( $dat, 'UTF-8', true ))
				return utf8_encode ( $dat );
			else
				return $dat;
		}
		if (! is_array ( $dat ))
			return $dat;
		$ret = array ();
		foreach ( $dat as $i => $d )
			$ret [$i] = $this->utf8_encode_all ( $d );
		return $ret;
	}
	/**
	 * Decodifica una cadena o un array UTF8
	 *
	 * @param unknown $dat        	
	 * @return string|unknown|multitype:Ambigous <unknown, string, multitype:Ambigous <string, unknown> >
	 */
	public function utf8_decode_all($dat) // -- It returns $dat decoded from UTF8
{
		if (is_string ( $dat )) {
			if (! mb_detect_encoding ( $dat, 'UTF-8', true ))
				return utf8_decode ( $dat );
			else
				return $dat;
		}
		if (! is_array ( $dat ))
			return $dat;
		$ret = array ();
		foreach ( $dat as $i => $d )
			$ret [$i] = $this->utf8_decode_all ( $d );
		return $ret;
	}
}
?>