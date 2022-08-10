<?php
//  error_reporting(-1);
/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
class doExcel{
	public $objPHPExcel;
	public function __construct(){
		$this-> objPHPExcel = new PHPExcel();
		$this-> objPHPExcel->getProperties()->setCreator("Bibliotechnia 3.0")
		->setLastModifiedBy("Bibliotechnia 3.0")
		->setTitle("Estadisticas Detalladas ")
		->setDescription("Este document contiene las Estadisticas Detalladas, segun los parametros proporcionados por el usuario.")
		->setKeywords("Bibliotechnia 3.0");
		$this->objPHPExcel->removeSheetByIndex();
	}
	
	/**
	 * Funcion para generar y descargar el archivo de Excel
	 * @param string $name Nombre que se desea colocar al archivo
	 */
	public function descargaXLSX($name = "estadisticas"){
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	
	
	private function  headExcel(PHPExcel_Worksheet &$sheet,$longitud){
		$longitud+=1;
		$col =  65;
		// Add a drawing to the worksheet
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$logo=  __DIR__."/../../portal/RESOURCE/logo.png";
		$objDrawing->setPath($logo);
		$objDrawing->setCoordinates('B2');
		$objDrawing->setHeight(48);
		$objDrawing->setWidth(260);
		$objDrawing->setWorksheet($sheet);
		
		for($filas = 1; $filas <= 7;$filas++){
// 			$this->objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
// 			echo chr($col).$filas.":".chr($col+$longitud).$filas;
// 			echo $filas;
			if($filas<6){
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col).$filas.":".chr($col+$longitud).$filas)->getFill()->applyFromArray(array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FFFFFF'
						)
				));
			}else if($filas==6){
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col).$filas.":".chr($col+$longitud).$filas)->getFill()->applyFromArray(array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FFFFFF'
						)
				));
				
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col).$filas.":".chr($col+$longitud).$filas)->applyFromArray(array(
						'borders' => array(
						'bottom' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('rgb' => '000000')
							)
						)
				));
				
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col+$longitud)."1:".chr($col+$longitud).$filas)->getFill()->applyFromArray(array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => 'FFFFFF'
						)
				));
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col+$longitud)."1:".chr($col+$longitud).$filas)->applyFromArray(array(
						'borders' => array(
								'right' => array(
										'style' => PHPExcel_Style_Border::BORDER_THIN,
										'color' => array('rgb' => '000000')
								)
						)
				));
			}else{
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col).$filas.":".chr($col+$longitud).$filas)->getFill()->applyFromArray(array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
								'rgb' => '9BC2E6'
						),'font'  => array('bold'  => true,'color' => array('rgb' => 'FFFFFF'))
				));
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col).$filas.":".chr($col+$longitud).$filas)->applyFromArray(array(
						'borders' => array(
								'bottom' => array(
										'style' => PHPExcel_Style_Border::BORDER_THIN,
										'color' => array('rgb' => '000000')
								)
						)
				));
				$this->objPHPExcel->getActiveSheet()->getStyle(chr($col+$longitud).$filas)->applyFromArray(array(
						'borders' => array(
								'right' => array(
										'style' => PHPExcel_Style_Border::BORDER_THIN,
										'color' => array('rgb' => '000000')
								)
						)
				));
			}
		}
		
// 		$this->objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
// 		$this->objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
		$bold=array('font'  => array('bold'  => true,'color' => array('rgb' => '3075CF')));		
		$boldUnder=array('font'  => array('bold'  => true,'color' => array('rgb' => '3075CF'), 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE));
		$sheet->setCellValue("J2","telefono:");
		$this->objPHPExcel->getActiveSheet()->getStyle("J2")->applyFromArray( array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ),'font'  => array('color' => array('rgb' => '7D75B5'))));
		$sheet->setCellValue("K2","5605 8295");
		$this->objPHPExcel->getActiveSheet()->getStyle("K2")->applyFromArray($bold);
		$sheet->setCellValue("J3","correo electrónico:");
		$this->objPHPExcel->getActiveSheet()->getStyle("J3")->applyFromArray( array(
				'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				),
				'font'  => array('color' => array('rgb' => '7D75B5'))
		));
		$sheet->setCellValue("K3","ventas@tercerescalon.com");
		$this->objPHPExcel->getActiveSheet()->getStyle("K3")->applyFromArray($boldUnder);
		$sheet->setCellValue("K4","www.bibliotechnia.com.mx");
		$this->objPHPExcel->getActiveSheet()->getStyle("K4")->applyFromArray($boldUnder);
		
		for($i = 0;$i<= $longitud;$i++){
			$this->objPHPExcel->getActiveSheet()->getColumnDimension(chr($col+$i))->setAutoSize(true);
		}
	}
	
	/**
	 * Metodo para agregar al documento Excel
	 * 
	 * @param string $nombre Nombre de la hoja de excel.
	 * @param array $valores Un array bidimensional con los valores de cada fila, no asociativos
	 * @param bool $default True si se desea colocar la hoja como default al abrir el archivo
	 */
	public function agregarHoja($nombre,$valores,$fila=7,$default=false){
		if(strlen($nombre)> 31){
			$nombre = substr($nombre, 0, 31);
		}
		$newSheet = new PHPExcel_Worksheet;
		$newSheet->setTitle($nombre);
		
// 		$fila=7;
		$longitud= 10;
		foreach($valores as $row){
			$col=65;
			foreach($row as $cell){
				$newSheet->setCellValue(chr($col++).$fila,$cell);
			}
			$fila++;
			$longitud = count($row)>$longitud? count($row):$longitud;
		}
		$this->objPHPExcel->addSheet($newSheet);
		if($default){
			$this->objPHPExcel->setActiveSheetIndex($this->objPHPExcel->getIndex($newSheet));
		}
		$this->headExcel($newSheet,$longitud);
	}
	
	public function hojaActiva($indexHoja=0){
		$this->objPHPExcel->setActiveSheetIndex($indexHoja);
	}
	
	public function sendXLSXToEmail($name = "estadisticas",$email,$extraInfo){
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		ob_start();
		$objWriter->save('php://output');
		$file = ob_get_clean();
		$params = array("string"=>$file,"filename"=>$name.'.xlsx"');
		$subject = $extraInfo["subject"];
		$msj = $extraInfo["msj"];
		$authController = new AuthController();
		$authController->sendMail($email, $subject, $msj,1,null,$params);
	}
	
}
?>