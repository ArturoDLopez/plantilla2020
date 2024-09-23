<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Impresiones extends CI_Controller
{
    function __construct(){
        parent::__construct();

        //LIBRERIAS
        $this->load->library('Pdf');

        // MODELS
        $this->load->model('comunes/Comunes_model');
    }

    public function imprimir(){
        $marcas = $this->Comunes_model->get_marcas();

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetTitle('TCPDF Example 002');
        // remove default header/footer
        $pdf->AddPage();
        $html2 = '<h2>Marcas</h2>';

        $html = '<h2>Marcas</h2>';
        $html .= '<table>';
            $html .= '<thead>';
                $html .= '<tr>';
                    $html .= '<th>Marca</th>';
                    $html .= '<th>Fecha de registro</th>';
                $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

        foreach($marcas['rows'] as $row){
                $html .= '<tr>';
                    $html .= '<td>';
                        $html .= $row->nom_marca;
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= $row->fecha_registro;
                    $html .= '</td>';
                $html .= '</tr>';
        }
            $html .= '</tbody>';
        $html .= '</table>';


        // print a block of text using Write()
        $pdf->writeHTML($html);

        header('Content-Type: application/pdf');
        header('Access-Control-Allow-Origin: *');

        //Close and output PDF document
        $pdf->Output('example_002.pdf', 'I');
        
        
    }
}