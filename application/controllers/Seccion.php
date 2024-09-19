<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require FCPATH.'vendor/autoload.php';

class Seccion extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->model('Vehiculos_model');
		$this->load->library('excel');
    }

	public function printPDF(){
		//llamar las plantillas
		$encabezado = $this->load->view('template/encabezado', '', true);
		$final = $this->load->view('template/final', '', true);
		
		//Recibir datos desde el fetch
		$tablaVehiculo = $this->input->post('tablaVehiculo');
		$num_serie = $this->input->post('num_serie');
		$vehiculo_id = $this->input->post('vehiculo_id');

		//desencriptar el id del vehiculo
		$id_desencriptado = (int)desencriptar($vehiculo_id);

		//Crrear un objketo para pasarle datos a la vista
		$data = new stdClass();

		//llamar a los modelos que regresan los datos mas especificos del vehiculo
		$robos = $this->Vehiculos_model->buscar_robo($id_desencriptado);
		$duenos = $this->Vehiculos_model->buscar_duenos($id_desencriptado);
		$placas = $this->Vehiculos_model->buscar_placas($id_desencriptado);

		//Pasar los valores traidos desde las consulatas al objeto
		$data->robos = ($robos);
		$data->duenos = $duenos;
		$data->placas = $placas;

		//Traer las vistas de las tablas 
		$tablaRobos = $this->load->view('template/tablaRobos', $data, true);
		$tablaDuenos = $this->load->view('template/tablaDuenos', $data, true);
		$tablaPlacas = $this->load->view('template/tablaPlacas', $data, true);
		
		//Armado del html final para crear el pdf
		$tabla = $encabezado.
				'<h2>Datos del vehiculo '.$num_serie.'</h2>
				<br><br>
				<table class="table ">'.$tablaVehiculo.'</table>
				<br><br>
				'.$tablaDuenos.'
				<br><br>
				<br><br>
				'.$tablaPlacas.'
				<br><br>
				<br><br>
				'.$tablaRobos.'
				<br><br>'
				.$final;

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($tabla);
		$mpdf->Output();
	}

	public function index()
    {
		
        if ($this->auth->is_signed()) {
			
            redirect(base_url()."seccion/tabla_vehiculos");
        } else {
			
			$data = new stdClass();
			$login = false;
			$data->login = $login;
			$this->load->view('template/header', $data);
			$this->load->view('secciones/ver');
			$this->load->view('template/footer');
        }
    }

	public function validate(){
		return $this->auth->is_signed();
	}

	public function logout(){
		$this->auth->logout();
		redirect(base_url());
	}

	public function tabla_vehiculos(){
		$data = new stdClass();
		$login = true;
		$data->login = $login;
		$this->load->view('template/header', $data);
        $this->load->view('secciones/tabla_vehiculos');
		$this->load->view('template/footer');
	}

	public function buscar_vehiculo_ajax(){
		$placa = $this->input->post('placa');
		$data = $this->Vehiculos_model->buscar_vehiculo($placa);
		$response['msj'] = "No se encontraron vehiculos con esas placas o numero de serie";
		if(!$data){
			return $this->output
				->set_status_header(404)
				->set_content_type("application/json")
            	->set_output(json_encode($response));
		}
		foreach($data as $d){
			$d->ve_id = encriptar($d->ve_id);
		}
		echo json_encode($data);
	}

	public function traer_robos(){
		$ve_id = $this->input->post('ve_id');
		if(empty($ve_id)){
			$response = array('msj' => 'No se encuentran robos registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}
		$id_desencriptado = (int)desencriptar($ve_id);
		if(!($id_desencriptado > 0)){
			$response = array('msj' => 'Mal  id');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		$response = $this->Vehiculos_model->buscar_robo($id_desencriptado);
		if(empty($response)){
			$response = array('msj' => 'No se encuentran robos registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		return $this->output
			->set_status_header(200)
			->set_content_type("application/json")
			->set_output(json_encode($response));

	}

	public function traer_duenos(){
		$ve_id = $this->input->post('ve_id');
		if(empty($ve_id)){
			$response = array('msj' => 'No se encuentran dueños registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}
		$id_desencriptado = (int)desencriptar($ve_id);
		if(!($id_desencriptado > 0)){
			$response = array('msj' => 'Mal  id');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		$response = $this->Vehiculos_model->buscar_duenos($id_desencriptado);
		if(empty($response)){
			$response = array('msj' => 'No se encuentran dueños registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		return $this->output
			->set_status_header(200)
			->set_content_type("application/json")
			->set_output(json_encode($response));

	}

	public function traer_placas(){
		$ve_id = $this->input->post('ve_id');
		if(empty($ve_id)){
			$response = array('msj' => 'No se encuentran placas registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}
		$id_desencriptado = (int)desencriptar($ve_id);
		if(!($id_desencriptado > 0)){
			$response = array('msj' => 'Mal  id');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		$response = $this->Vehiculos_model->buscar_placas($id_desencriptado);
		if(empty($response)){
			$response = array('msj' => 'No se encuentran placas registrados para este vehiculo');
			return $this->output
				->set_status_header(400)
				->set_content_type("application/json")
				->set_output(json_encode($response));
		}

		return $this->output
			->set_status_header(200)
			->set_content_type("application/json")
			->set_output(json_encode($response));

	}

	function exportar_excel(){
		$num_serie = $this->input->post('num_serie');
		$vehiculo_id = $this->input->post('vehiculo_id');
		$id_desencriptado = (int)desencriptar($vehiculo_id);

		$placas = $this->Vehiculos_model->buscar_placas($id_desencriptado);
		$duenos = $this->Vehiculos_model->buscar_duenos($id_desencriptado);
		$robos = $this->Vehiculos_model->buscar_robo($id_desencriptado);
		$data = ($this->Vehiculos_model->buscar_vehiculo($num_serie));

		$object = new PHPExcel();

		$object->setActiveSheetIndex(0);
		$object->getActiveSheet()->mergeCells('A1:H1');
		$object->getActiveSheet()->setCellValue('A1', 'Vehiculo encontrado');
		$object->setActiveSheetIndex(0)->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle('A1:H1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle("A1:h1")->getFont()->setSize(24);

		$object->setActiveSheetIndex(0)->getStyle("A1:h1")->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					 'rgb' => '602929'
				)
			));

		$object->setActiveSheetIndex(0)->getStyle('A1:H1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

		$object->getActiveSheet()->setCellValue('A2', 'Numero de serie');
		$object->getActiveSheet()->setCellValue('B2', 'Marca');
		$object->getActiveSheet()->setCellValue('C2', 'Modelo');
		$object->getActiveSheet()->setCellValue('D2', 'Tipo');
		$object->getActiveSheet()->setCellValue('E2', 'Color');
		$object->getActiveSheet()->setCellValue('F2', 'Placas Actuales');
		$object->getActiveSheet()->setCellValue('G2', 'Propietario Actual');
		$object->getActiveSheet()->setCellValue('H2', 'Fecha de registro');

		$object->getActiveSheet()->setCellValueExplicit('A3', $data[0]->num_serie, PHPExcel_Cell_DataType::TYPE_STRING);
		$object->getActiveSheet()->setCellValue('B3', $data[0]->nom_marca);
		$object->getActiveSheet()->setCellValue('C3', $data[0]->modelo);
		$object->getActiveSheet()->setCellValue('D3', $data[0]->nom_tipo);
		$object->getActiveSheet()->setCellValue('E3', $data[0]->nom_color);
		$object->getActiveSheet()->setCellValue('F3', 'No tiene asiganada ninguna placa actualmente');
		if($data[0]->placa){
			$object->getActiveSheet()->setCellValue('F3', $data[0]->placa);	
		}
		$object->getActiveSheet()->setCellValue('G3', $data[0]->nombre);
		if(!$data[0]->nombre){
			$object->getActiveSheet()->setCellValue('G3', 'No tiene un propietario actual');
		}
		$object->getActiveSheet()->setCellValue('H3', $data[0]->fecha_registro);

		$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		$object->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

		//Propietarios

		$object->getActiveSheet()->mergeCells('A10:E10');
		$object->getActiveSheet()->setCellValue('A10', 'Duenos');
		$object->setActiveSheetIndex(0)->getStyle('A10:E10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle('A10:E10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle("A10:E10")->getFont()->setSize(24);

		$object->setActiveSheetIndex(0)->getStyle("A10:E10")->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					 'rgb' => '602929'
				)
			));

		$object->setActiveSheetIndex(0)->getStyle('A10:E10')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

		$object->getActiveSheet()->setCellValue('A11', 'Nombre');
		$object->getActiveSheet()->setCellValue('B11', 'Actual');
		$object->getActiveSheet()->setCellValue('C11', 'Fecha de inicio');
		$object->getActiveSheet()->setCellValue('D11', 'Fecha de termino');
		$object->getActiveSheet()->setCellValue('E11', 'Fecha de registro');

		$fila = 12;
		foreach($duenos as $du){
			$object->getActiveSheet()->setCellValue('A'.$fila, $du->nombre);
			if($du->actual == 0){
				$object->getActiveSheet()->setCellValue('B'.$fila, 'NO');
			}
			$object->getActiveSheet()->setCellValue('B'.$fila, 'SI');
			$object->getActiveSheet()->setCellValue('C'.$fila, $du->fecha_inicio);
			$object->getActiveSheet()->setCellValue('D'.$fila, $du->fecha_termino);
			$object->getActiveSheet()->setCellValue('E'.$fila, $du->fecha_registro);

			$fila ++;
		}

		

		//Placas


		$object->getActiveSheet()->mergeCells('G10:K10');
		$object->getActiveSheet()->setCellValue('G10', 'Placas');
		$object->setActiveSheetIndex(0)->getStyle('G10:K10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle('G10:K10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle("G10:K10")->getFont()->setSize(24);

		$object->setActiveSheetIndex(0)->getStyle("G10:K10")->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					 'rgb' => '602929'
				)
			));

		$object->setActiveSheetIndex(0)->getStyle('G10:K10')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

		$object->getActiveSheet()->setCellValue('G11', 'Placa');
		$object->getActiveSheet()->setCellValue('H11', 'Actual');
		$object->getActiveSheet()->setCellValue('I11', 'Fecha de inicio');
		$object->getActiveSheet()->setCellValue('J11', 'Fecha de termino');
		$object->getActiveSheet()->setCellValue('K11', 'Fecha de registro');

		$fila = 12;
		foreach($placas as $du){
			$object->getActiveSheet()->setCellValue('G'.$fila, $du->placa);
			$object->getActiveSheet()->setCellValue('H'.$fila, 'SI');
			if($du->actual == 0){
				$object->getActiveSheet()->setCellValue('H'.$fila, 'NO');
			}

			$object->getActiveSheet()->setCellValue('I'.$fila, $du->fecha_inicio);
			$object->getActiveSheet()->setCellValue('J'.$fila, $du->fecha_termino);
			$object->getActiveSheet()->setCellValue('K'.$fila, $du->fecha_registro);

			$fila ++;
		}

		//Robos

		$object->getActiveSheet()->mergeCells('M10:P10');
		$object->getActiveSheet()->setCellValue('M10', 'Robos');
		$object->setActiveSheetIndex(0)->getStyle('M10:P10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle('M10:P10')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$object->setActiveSheetIndex(0)->getStyle("M10:P10")->getFont()->setSize(24);

		$object->setActiveSheetIndex(0)->getStyle("M10:P10")->getFill()->applyFromArray(array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'startcolor' => array(
					 'rgb' => '602929'
				)
			));

		$object->setActiveSheetIndex(0)->getStyle('M10:P10')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

		$object->getActiveSheet()->setCellValue('M11', 'Placas');
		$object->getActiveSheet()->setCellValue('N11', 'Descripcion');
		$object->getActiveSheet()->setCellValue('O11', 'Fecha de Robo');
		$object->getActiveSheet()->setCellValue('P11', 'Fecha de registro');

		$fila = 12;
		foreach($robos as $du){
			$object->getActiveSheet()->setCellValue('M'.$fila, $du->placa);
			$object->getActiveSheet()->setCellValue('N'.$fila, $du->descripcion);
			$object->getActiveSheet()->setCellValue('O'.$fila, $du->fecha);
			$object->getActiveSheet()->setCellValue('P'.$fila, $du->fecha_registro);

			$fila ++;
		}

		$styleArray = array(
			'font' => array(
				'bold' => true,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
				),
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'rotation' => 90,
				'startcolor' => array(
					'argb' => 'FFA0A0A0',
				),
				'endcolor' => array(
					'argb' => 'FFFFFFFF',
				),
			),
		);
		
		$object->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArray);
		$object->getActiveSheet()->getStyle('A11:E11')->applyFromArray($styleArray);
		$object->getActiveSheet()->getStyle('G11:K11')->applyFromArray($styleArray);
		
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Reporte_control_patrimonial_licencias' . date('d') . '_' . date('m') . '_' . date('Y') . '.xlsx"');
        header('Cache-Control: max-age=0');
        header("Expires: 0");
        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        ob_end_clean();
		//header('Content-Type: application/vnd.ms-excel');
		//header('Content-Disposition: attachment;filename="Employee Data.xls"');
		$object_writer->save('php://output');

		//$objPHPExcel->getActiveSheet()->mergeCells('A1:H1'); unir celdas
		//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		//$object->getActiveSheet()->setCellValueByColumnAndRow(0, 2, 'Sample Text');

	}
	

}