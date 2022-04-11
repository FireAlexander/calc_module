<?php

namespace Drupal\calc\Controller;

use Drupal\Core\Controller\ControllerBase;

class CalcController extends ControllerBase {

public function content() {

  return [
    '#type' => 'markup',
    '#markup' => $this->t('Hi! how do you do?'),
  ];
}
}
