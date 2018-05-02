<?php
namespace app\controllers;
use app\models\User;
use core\Controller;
use core\Database\Field;
use core\Helper;
use core\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class reportController extends Controller
{
    public function index() {}
    public function peopleExcel()
    {
        require_once 'core/autoload.php';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $writer = new Xlsx($spreadsheet);
        //Gets from the database
        $Users = User::getByFields(new Field("Validated", 1));
        if (!is_array($Users)) {
            $Users=[$Users];
        }
   
        //Sets autosize for the collumns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        
        //The first line on the spreadsheet. Also sets the headers.
        $lineNo = 1;
        $sheet->setCellValue('A' . $lineNo, "First Name");
        $sheet->setCellValue('B' . $lineNo, "Second Name");
        $sheet->setCellValue('C' . $lineNo, "Institution");
        $sheet->setCellValue('D' . $lineNo, "Hotel Room Types");



        //Sets the values
        foreach ($Users as $user) {
            $lineNo++;
            $sheet->setCellValue('A' . $lineNo, $user->first_name);
            $sheet->setCellValue('B' . $lineNo, $user->last_name);
            $sheet->setCellValue('C' . $lineNo, $user->institution);

            switch ($user->hotel) {
                case "roomno": 
                    $sheet->setCellValue('D' . $lineNo, "-");
                    break;
                case "roomsingle": 
                    $sheet->setCellValue('D' . $lineNo, "Single");
                    break;
                case "roomdouble": 
                    $sheet->setCellValue('D' . $lineNo, "Double");
                    break;
                default:
                    $sheet->setCellValue('D' . $lineNo, $user->hotel);
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
        $sheet ->getStyle('A1:D1')->applyFromArray($styleArray);


        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="file.xls"');

        $writer->save('php://output');

    }
    public function emailExcel()
    {
        require_once 'core/autoload.php';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $writer = new Xlsx($spreadsheet);
        //Gets from the database
        $Users = User::getByFields(new Field("Validated", 1));
        if (!is_array($Users)) {
            $Users=[$Users];
        }

        
        //Sets autosize for the collumns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        
        //The first line on the spreadsheet. Also sets the headers.
        $lineNo = 1;
        $sheet->setCellValue('A' . $lineNo, "E-mail");



        //Sets the values
        foreach ($Users as $user) {
            $lineNo++;
            $sheet->setCellValue('A' . $lineNo, $user->email);
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
        $sheet ->getStyle('A1:A1')->applyFromArray($styleArray);


        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="emails.xls"');

        $writer->save('php://output');

    }

    public function diplomaWord()
    {
        require_once 'core/autoload.php';


        //$Users = User::getByFields(new Field("Validated", 1));
        //$Users2 = User::getByFields(new Field("Validated", 1));

        $Users = User::all();
        $Users2 = User::all();
        if (!is_array($Users)) {
            $Users = [$Users];
        }


        // Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->setDefaultParagraphStyle(
            array(
                'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                'spacing' => 120,
            )
        );

        $array = [];
        foreach ($Users as $user) {
            $authorsarray = explode(',', $user->article_authors);
            foreach ($authorsarray as $author) {
                if (!isset($array[$author]))
                    $array[$author] = [[$user->article_title, $user->institution]];
                else {
                    array_push($array[$author], [$user->article_title, $user->institution]);

                }
            }
        }
        foreach ($array as $author=>$articles) {
            if(count($array[$author]) < 3)
                for($i=count($array[$author]);$i<4;$i++)
                    array_push($array[$author], ["", ""]);
        }
        foreach ($array as $author=>$articles) {

                $section = $phpWord->addSection();

                $section->addImage(
                    Helper::host() . "/images/DAMSSlogo.jpg",
                    array(
                        'width' => 141,
                        'height' => 49,
                        'marginTop' => -1,
                        'marginLeft' => -1,
                        'wrappingStyle' => 'behind'
                    )
                );

                $fontStyleName = 'oneUserDefinedStyle';

                $phpWord->addFontStyle(
                    $fontStyleName,
                    array('name' => 'Cambria', 'size' => 24, 'color' => '1B2232', 'bold' => true, 'align' => 'center')
                );
                $fontStyleName2 = 'twoUserDefinedStyle';
                $phpWord->addFontStyle(
                    $fontStyleName2,
                    array('name' => 'Cambria', 'size' => 16, 'color' => '1B2232', 'bold' => false)
                );
                $fontStyleName3 = 'threeUserDefinedStyle';
                $phpWord->addFontStyle(
                    $fontStyleName3,
                    array('name' => 'Cambria', 'size' => 18, 'color' => '1B2232', 'bold' => true)
                );
                $fontStyleName4 = 'fourUserDefinedStyle';
                $phpWord->addFontStyle(
                    $fontStyleName4,
                    array('name' => 'Cambria', 'size' => 14, 'color' => '1B2232', 'bold' => false)
                );
                $fontStyleName5 = 'fiveUserDefinedStyle';
                $phpWord->addFontStyle(
                    $fontStyleName5,
                    array('name' => 'Cambria', 'size' => 16, 'color' => '990000', 'bold' => true)
                );

                $fontStyleName6 = 'sixUserDefinedStyle';
                $phpWord->addFontStyle(
                    $fontStyleName6,
                    array('name' => 'Cambria', 'size' => 16, 'color' => '1B2232', 'bold' => false, 'italic' => true)
                );

                $section->addText(
                    'CERTIFICATE OF PARTICIPATION',
                    $fontStyleName
                );

                $section->addText(
                    'This is certify that',
                    $fontStyleName2
                );

                $section->addText(
                    $author,
                    $fontStyleName3
                );


                $section->addText(
                    $articles[0][1],
                    $fontStyleName4
                );

                $section->addText(
                    'has attended the 10th international workshop',
                    $fontStyleName4
                );

                $section->addText(
                    'Data Analysis Methods for Software Systems',
                    $fontStyleName5
                );

                $section->addText(
                    'held in Druskininkai, Lithuania, 29 November - 1 December 2018 has presented the paper',
                    $fontStyleName4
                );

                foreach ($articles as  $title) {
                    $section->addText(
                        $title[0],
                        $fontStyleName2,
                        array('space' => array('before' => 0, 'after' => 0))
                    );
                }


                $phpWord->addParagraphStyle('p2Style', array('align' => 'start', 'spaceAfter' => 100,'space' => array('before' => 400, 'after' => 0)));
                $phpWord->addParagraphStyle('p3Style', array('align' => 'end', 'spaceAfter' => 100));

                $section->addText(
                    'Program Committee',
                    $fontStyleName6,
                    'p2Style'
                );

                $section->addText(
                    '  ' . 'Dr. Saulius Maskeliūnas',
                    $fontStyleName4,
                    'p2Style'
                );


                $section->addText(
                    '  ' . 'Prof. Gintautas Dzemyda',
                    $fontStyleName4,
                    'p2Style'
                );

                $section->addText(
                    'Druskininkai, 1 December, 2018',
                    $fontStyleName4,
                    'p3Style'
                );
                // Adding Text element with font customized using explicitly created font style object...

                $section->addImage(
                    Helper::host() . "/images/Sponsors.jpg",
                    array(
                        'width'         => 425,
                        'height'        => 68,
                        'marginTop'     => -1,
                        'marginLeft'    => 0,
                        'wrappingStyle' => 'behind'
                    )
                );
            }

            $contentType = 'Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document;';
            header($contentType);
            // Saving the document as OOXML file...
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save("php://output");
        }

    public function abstractWord () {
        require_once 'core/autoload.php';     
        $phpWord = new \PhpOffice\PhpWord\PhpWord();       
        $contentType = 'Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document; charset=utf-8';
        header($contentType);     
        $Users = User::getByFields(new Field("Validated", 1));
        if (!is_array($Users)) {
            $Users=[$Users];
        }
        foreach ($Users as $user) {
            $section = $phpWord->addSection();         
            $fontStyleName = 'oneUserDefinedStyle';
        
            $phpWord->addFontStyle(
                $fontStyleName,
                array('name' => 'Times New Roman', 'size' => 13, 'color' => '1B2232', 'bold' => true)
            );
        
            $fontStyleName2 = 'twoUserDefinedStyle';
            $phpWord->addFontStyle(
                $fontStyleName2,
                array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232', 'bold' => false)
            );
            $fontStyleName3 = 'threeUserDefinedStyle';
            $phpWord->addFontStyle(
                $fontStyleName3,
                array('name' => 'Times New Roman', 'size' => 10, 'color' => '1B2232', 'bold' => false, 'align' => 'both','spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0))
            );
            $fontStyleName4 = 'fourUserDefinedStyle';
            $phpWord->addFontStyle(
                $fontStyleName4,
                array('name' => 'Courier New', 'size' => 10, 'color' => '1B2232', 'bold' => false)
            );
            $fontStyleName5 = 'fiveUserDefinedStyle';
            $phpWord->addFontStyle(
                $fontStyleName5,
                array('name' => 'Cambria', 'size' => 16, 'color' => '990000', 'bold' => true)
            );
        
            $fontStyleName6 = 'sixUserDefinedStyle';
            $phpWord->addFontStyle(
                $fontStyleName6,
                array('name' => 'Cambria', 'size' => 16, 'color' => '1B2232', 'bold' => false, 'italic' => true)
            );
        
            $pstyle = 'ParagraphStyle';
        
            $phpWord->addParagraphStyle(
                $pstyle,
                array('align' => 'both', 'spaceAfter' => 100)
            );
        
        
            $section->addText(
                $user->article_title,
                $fontStyleName
            );
            $section->addText(
                $user->article_authors,
                $fontStyleName2,
                array('space' => array('before' => 0, 'after' => 50))
            );
        
            $section->addText(
                $user->affiliation,
                $fontStyleName3,
                array('space' => array('before' => 0, 'after' => 0))
            );
        
        
            $section->addText(
                $user->email,
                $fontStyleName4
            );
        
            $section->addText(
                $user->abstract,
                $fontStyleName3,
                $pstyle
            );
            
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("php://output");

    }
}