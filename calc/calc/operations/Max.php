<?php



namespace operations;

Class Max implements \calc_interface\math_operation
{
    const Operator = 'max'; // type of operand - how the operation will be displayed in the calculator
    const Name = "Max"; // type of operand = Class name!!!

     //Implementation of the operation
     public function operation($operand1, $operand2) {
        if ($operand1 > $operand2) {
        return $operand1;
        }
    }
}