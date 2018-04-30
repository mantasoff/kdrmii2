<?php
namespace app\controllers;
use app\models\User;
use core\Controller;
use core\Database\Field;
use core\View;

class indexController extends Controller
{
    public function index()
    {
        require_once 'core/autoload.php';

// Creating the new document...
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
        /*
        $phpWord->setDefaultParagraphStyle(
            array(
                'alignment'  => \PhpOffice\PhpWord\SimpleType\Jc::START,
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(12),
                'spacing'    => 120,
            )
        );
        */

        $contentType = 'Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document; charset=utf-8';
        header($contentType);

        $Users = User::getByFields(new Field("Validated", 1));
        if (!is_array($Users)) {
            $Users=[$Users];
        }
        //$Users = User::getByFields(new Field());
        foreach ($Users as $user) {
            $section = $phpWord->addSection();
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
                //'The stable trend to lose from one-third to half of students in the first study year of computing studies motivated us to explore, which methods are used to determine in advance such applicants, who have no chance to overcome the first study year. Initially, a research about the factors influencing the attrition in Faculty of Computing at the University of Latvia was conducted. The results of our study indicated that none of the studied factors is determinant to identify those students, who are going to abandon their studies, with great precision. The research revealed that the trend of non-beginning studies might indicate the wrong choice of the study field and possible lack of understanding of what is programming by enrolled students (applicants as well as pupils). During the research, some promising programming aptitude tests were discovered for more detailed study. The study concluded that the most promising psychological and problem solving self-test summary should be offered to the prospective students. University of Latvia conducted a research based on  a “Cambridge Personality Questionnaire and Behaviour Scale”  to find out the correlation between systemizing quotient and empathy quotient and  the computing skills of the prospective students. Testing was carried out for secondary school computing students. Further study is conducted by testing the 1st study year students.',
                $user->abstract,
                $fontStyleName3,
                $pstyle
            );




            /* Note: we skip RTF, because it's not XML-based and requires a different example. */
            /* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save("php://output");
    }
}