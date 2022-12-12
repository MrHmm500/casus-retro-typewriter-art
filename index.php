<?php
$jsonTestCases = file_get_contents('testcases.json');
$testCases = json_decode($jsonTestCases);
foreach ($testCases as $caseName => $caseData) {
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

function extractOutputFromInput(array $input): void {
    $answer = '';
    foreach ($input as $chunk) {
        $repeatingChar = '';
        $multiplicativeChar = '';

        foreach (str_split($chunk) as $index => $char) {
            if (is_numeric($char)) {
                $multiplicativeChar .= $char;
            } else {
                $repeatingChar .= $char;
            }

            if (($index + 1) !== strlen($chunk) || is_numeric($char) === false) {
                continue;
            }

            $repeatingChar = $char;
            $multiplicativeChar = substr($multiplicativeChar, 0, -1);
        }
        switch ($repeatingChar) {
            case 'nl':
                $repeatingChar = "<br />";
                break;
            case 'sp':
                $repeatingChar = "&nbsp;";
                break;
            case 'bS':
                $repeatingChar = "\\";
                break;
            case 'sQ':
                $repeatingChar = "'";
                break;
        }
        $answer .= str_repeat($repeatingChar, ($multiplicativeChar === '' ? 1 : (int)$multiplicativeChar));
    }

    echo $answer;
}