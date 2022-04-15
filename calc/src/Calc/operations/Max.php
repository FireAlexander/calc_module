<?php



namespace Drupal\calc\Calc\operations;

use Drupal\calc\Calc\calc_interface;

Class Max implements calc_interface\math_operation
{
    const Operator = 'max'; // type of operand - how the operation will be displayed in the calculator
    const Name = "Max"; // type of operand = Class name!!!

     //Implementation of the operation
     public function operation($operand1, $operand2) {
        if ($operand1 > $operand2) {
            return $operand1;
        } elseif ($operand1 < $operand2){
            return $operand2;
        } else return "Equal";
    }
}
