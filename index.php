<?php
$jsonTestCases = file_get_contents('testcases.json');
$testCases = json_decode($jsonTestCases);
foreach($testCases as $caseName => $caseData) {
    echo "-----------------------------------<br />";
    echo $caseName . ' wordt getest<br />';
    echo 'expected output: <br />';
    echo str_replace("\n", '<br />', str_replace(' ', '&nbsp;', $caseData->expectedOutput)) . '<br /><br />';

    $input = explode(" ", $caseData->input);

    echo "-----------------------------------<br />";
    echo "actual output:<br />";

    extractOutputFromInput($input);

    echo "<br />";
}

function extractOutputFromInput($input) {
    $answer = '';
    foreach ($input as $chunk) {
        $repeatingChar = '';
        $multiplicitiveChar = '';

        foreach (str_split($chunk) as $index => $char) {
            if (is_numeric($char)) {
                $multiplicitiveChar .= $char;
            } else {
                $repeatingChar .= $char;
            }
            if (($index + 1) == strlen($chunk) && is_numeric($char)) {
                $repeatingChar = $char;
                $multiplicitiveChar = substr($multiplicitiveChar, 0, -1);
            }
        }
        for ($i = 0; $i < ($multiplicitiveChar == '' ? 1 : $multiplicitiveChar); $i++) {
            switch ($repeatingChar) {
                case 'nl':
                    $answer .= "<br />";
                    break;
                case 'sp':
                    $answer .= "&nbsp;";
                    break;
                case 'bS':
                    $answer .= "\\";
                    break;
                case 'sQ':
                    $answer .= "'";
                    break;
                default:
                    $answer .= $repeatingChar;
                    break;
            }
        }
    }

    echo $answer;
}