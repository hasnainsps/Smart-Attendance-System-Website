<?php 

function decode_string_to_value($string) {
  $letters = str_split($string, 3); // split the string into groups of 3 letters
  $values = array(); // initialize the array of output values
  // map each string to its corresponding value using a switch statement
  foreach ($letters as $letter) {
    switch ($letter) {
      case 'JtD':
        $values[] = 0;
        break;
      case 'IsC':
        $values[] = 1;
        break;
      case 'HrB':
        $values[] = 2;
        break;
      case 'GqA':
        $values[] = 3;
        break;
      case 'FpZ':
        $values[] = 4;
        break;
      case 'EoY':
        $values[] = 5;
        break;
      case 'DnX':
        $values[] = 6;
        break;
      case 'CmW':
        $values[] = 7;
        break;
      case 'BlV':
        $values[] = 8;
        break;
      case 'AkU':
        $values[] = 9;
        break;
      default:
        // handle invalid input
        break;
    }
  }

  // concatenate the output values into a single integer
  $output = implode('', $values);
  
  return $output;
}
 ?>