<?php



namespace operations;

Class Addition implements \calc_interface\math_operation
{
    const Operator = '+'; // type of operand - how the operation will be displayed in the calculator
    const Name = "Addition"; // type of operand = Class name!!!

     //Implementation of the operation
     public function operation($operand1, $operand2) {
        return $operand1 + $operand2;
    }
}