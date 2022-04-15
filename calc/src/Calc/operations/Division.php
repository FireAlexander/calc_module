<?php


namespace Drupal\calc\Calc\operations;

use Drupal\calc\Calc\calc_interface;

class Division implements calc_interface\math_operation
{
    const Operator = '/'; // type of operand - how the operation will be displayed in the calculator
    const Name = "Division"; // type of operand = Class name!!!

    //Implementation of the operation
    public function operation($operand1, $operand2) {
        if ($operand2 == '0') {
            return "Can't divide by zero";
        }else {
            return $operand1 / $operand2;
        }
    }
}
