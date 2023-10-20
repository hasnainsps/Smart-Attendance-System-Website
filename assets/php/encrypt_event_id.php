<?php 

function convert_value_to_string($value) {
    $string_values = array(
        'JtD', 'IsC', 'HrB', 'GqA', 'FpZ', 'EoY', 'DnX', 'CmW', 'BlV', 'AkU'
    );
    $letters = array();
    $digits = str_split($value);
    foreach ($digits as $digit) {
        switch ($digit) {
            case 0:
                $letters[] = $string_values[0];
                break;
            case 1:
                $letters[] = $string_values[1];
                break;
            case 2:
                $letters[] = $string_values[2];
                break;
            case 3:
                $letters[] = $string_values[3];
                break;
            case 4:
                $letters[] = $string_values[4];
                break;
            case 5:
                $letters[] = $string_values[5];
                break;
            case 6:
                $letters[] = $string_values[6];
                break;
            case 7:
                $letters[] = $string_values[7];
                break;
            case 8:
                $letters[] = $string_values[8];
                break;
            case 9:
                $letters[] = $string_values[9];
                break;
            default:
                // handle invalid input
                break;
        }
    }
    $output = implode('', $letters);
    return $output;
}


 ?>