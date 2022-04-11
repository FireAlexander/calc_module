<?php

namespace calc_interface;

interface math_operation
{
  // type of operation
  public function operation($operand1, $operand2);
}