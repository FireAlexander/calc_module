<?php



namespace Drupal\calc\Calc\operations;

use Drupal\calc\Calc\calc_interface;

Class Abs implements calc_interface\math_operation
{
    const Operator = 'abs'; // type of operand - how the operation will be displayed in the calculator
    const Name = "Abs"; // type of operand = Class name!!!

     //Implementation of the operation
     public function operation($operand1, $operand2) {
         return abs($operand1);
    }
}