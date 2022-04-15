<?php
/**
 * @file
 * Contains \Drupal\calc\Form\ResultForm.
 */
namespace Drupal\calc\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\calc\Calc;

class ResultForm extends FormBase {
    /**
     * {@inheritdoc}.
     */
        public function getFormId() {
        return 'result_form';
    }
    /**
     * {@inheritdoc}.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['operand1'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Enter operand 1')
        );

        $form['operation'] = array (
            '#type' => 'select',
            '#options' => Calc\Calc::get_mass_operands(),
        );

        $form['operand2'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Enter operand 2'),
            '#states' => array (
                'invisible' => array (
                   ':input[name="operation"]' => array(
                       'value' => 'Abs'
                   ),
                ),
            ),
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array (
            '#type' => 'submit',
            '#value' => $this->t('Result'),
            '#button_type' => 'primaty',
        );
        return $form;
    }
    /**
     * {@inheritdoc}.
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        debug(var_dump($form_state->getValue('operation')));
        if((empty($form_state->getValue('operand1')) && $form_state->getValue('operand1') != '0'))
             {
            $form_state->setErrorByName('operand1', t('One or more fields are not filed'));
        }elseif (empty($form_state->getValue('operand2')) && $form_state->getValue('operand2') != '0') {
            if ($form_state->getValue('operation') <> 'Abs') {
                $form_state->setErrorByName('operand2', t('One or more fields are not filed'));
            }
        }
        else {
            //Are there number in the fields?
            if (!is_numeric($form_state->getValue('operand1')) || !is_numeric(($form_state->getValue('operand2')))) {
                $form_state->setErrorByName('', t('One or more operands are not number'));;
            }
        }

    }
    /**
     * {@inheritdoc}.
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
            $classname = "Drupal\\calc\\Calc\\operations\\" . $form_state->getValue('operation');
            $obj = new $classname;
            $calc = new Calc\Calc($form_state->getValue('operand1'), $form_state->getValue('operand2'), $obj);
            $message = ' ' . $calc->result();
            \Drupal::messenger()->addMessage($message);
    }
   }
