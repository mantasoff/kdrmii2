<?php
namespace app\controllers;
use core\Controller;

class documentController extends Controller
{
    public function index()
    {
        require_once 'core/autoload.php';

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();

/* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
$phpWord->setDefaultParagraphStyle(
    array(
        'alignment'  => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
        'spacing'    => 120,
    )
);



$section = $phpWord->addSection();

$section->addImage(
    "./core/phpoffice/resources/DAMSSlogo.jpg",
    array(
        'width'         => 141,
        'height'        => 49,
        'marginTop'     => -1,
        'marginLeft'    => -1,
        'wrappingStyle' => 'behind'
    )
);
// Adding Text element to the Section having font styled by default...

/*
 * Note: it's possible to customize font style of the Text element you add in three ways:
 * - inline;
 * - using named font style (new font style object will be implicitly created);
 * - using explicitly created font style object.
 */

// Adding Text element with font customized inline...

// Adding Text element with font customized using named font style...
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
    array('name' => 'Cambria', 'size' => 16, 'color' => '1B2232', 'bold' => false,'italic' => true)
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
    'Petras Petraitis',
    $fontStyleName3
);


$section->addText(
    'Vilnius Gediminas Technical University',
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

$section->addText(
    'Automatic Adjustment of Disparity in Stereo View by Eye Activity Based Markers',
    $fontStyleName2
);



$phpWord->addParagraphStyle('p2Style', array('align'=>'start', 'spaceAfter'=>100));
$phpWord->addParagraphStyle('p3Style', array('align'=>'end', 'spaceAfter'=>100));



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
    "./core/phpoffice/resources/Sponsors.jpg"
);

$contentType = 'Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document;';
header($contentType);
// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save("php://output");

/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
    }
}