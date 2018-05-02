<?php
namespace app\controllers;
use app\models\User;
use core\Controller;
use core\Database\Field;
use core\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class thirdController extends Controller
{
    public function index()
    {
        require_once 'core/autoload.php';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $writer = new Xlsx($spreadsheet);
        //Gets from the database
        $Users = User::getByFields(new Field("Validated", 0));
        if (!is_array($Users)) {
            $Users=[$Users];
        }

        
        //Sets autosize for the collumns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        
        //The first line on the spreadsheet. Also sets the headers.
        $lineNo = 1;
        $sheet->setCellValue('A' . $lineNo, "First Name");
        $sheet->setCellValue('B' . $lineNo, "Second Name");
        $sheet->setCellValue('C' . $lineNo, "E-mail");
        $sheet->setCellValue('D' . $lineNo, "Institution");
        $sheet->setCellValue('E' . $lineNo, "Hotel Room Types");



        //Sets the values
        foreach ($Users as $user) {
            $lineNo++;
            $sheet->setCellValue('A' . $lineNo, $user->first_name);
            $sheet->setCellValue('B' . $lineNo, $user->last_name);
            $sheet->setCellValue('C' . $lineNo, $user->email);
            $sheet->setCellValue('D' . $lineNo, $user->institution);

            switch ($user->hotel) {
                case "roomno": 
                    $sheet->setCellValue('E' . $lineNo, "-");
                    break;
                case "roomsingle": 
                    $sheet->setCellValue('E' . $lineNo, "Single");
                    break;
                case "roomdouble": 
                    $sheet->setCellValue('E' . $lineNo, "Double");
                    break;
                default:
                    $sheet->setCellValue('E' . $lineNo, $user->hotel);
                    break;
            }
        }


        //Array Style array creation
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('argb' => '000'),
                ),
            ),
        );
        //Style setting for the chosen cells
        $sheet ->getStyle('A1:E1')->applyFromArray($styleArray);


        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="file.xls"');

        $writer->save('php://output');

    }
}