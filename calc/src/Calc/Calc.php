<?php

namespace Drupal\calc\Calc;

use Drupal\calc\Calc\calc_interface;
use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;

// main class
class Calc
{
    public function __construct(float $operand1, $operand2, calc_interface\math_operation $operation)
    {
        $this->operand1 = $operand1; //operand1 - left operand in calculator
        $this->operand2 = $operand2; //operand2 - right operand in calculator
        $this->operation = $operation;  //operation - type of math operation in calculator
    }

    // Get Class name from "operaions" directory.
    public static function get_operations () {

        $array_operations = [];
        $dirs = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../Calc/operations'));
        foreach ($dirs as $name => $file) {
            $ext = $file->getExtension();
            if (in_array($ext, ['php']) && !is_dir($file))
                $array_operations[] = pathinfo($name)['filename'];
                    }
        return $array_operations;
    }

    public static function get_mass_operands ()
    {
        $array_operands = [];
        foreach (Calc::get_operations() as $value) {
            $classname = "Drupal\\calc\\Calc\\operations\\" . $value;
            $array_operands[$classname::Name] = $classname::Operator;
        }
        return $array_operands;
    }

    // return result
    public function result() {
        return $this->operation->operation($this->operand1, $this->operand2);
    }

}
