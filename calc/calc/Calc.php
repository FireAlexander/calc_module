<?php

// Search file in ./
function myAutoload($classname) {
    $filename = __DIR__ . '/' . str_replace('\\', '/',$classname) . '.php';
    include_once ($filename);
}

//register Loader
spl_autoload_register('myAutoload');


// main class
class Calc
{
    public function __construct(float $operand1, float $operand2, \calc_interface\math_operation $operation)
    {
        $this->operand1 = $operand1; //operand1 - left operand in calculator
        $this->operand2 = $operand2; //operand2 - right operand in calculator
        $this->operation = $operation;  //operation - type of math operation in calculator
    }

    // Get Class name from "operaions" directory.
    public static function get_operations () {

        $array_operations = [];
        $dirs = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./operations'));
        foreach ($dirs as $name => $file) {
            $ext = $file->getExtension();
            if (in_array($ext, ['php']) && !is_dir($file))
                $array_operations[] = pathinfo($name)['filename'];
                    }
        return $array_operations;
    }

    // return result
    public function result() {
        return $this->operation->operation($this->operand1, $this->operand2);
    }

}
// if received a post request
if(isset($_POST['submit'])) {
    //filing value
    $number1 = $_POST['First_number'];  //left operand in calculator
    $number2 = $_POST['Second_number']; //right operand in calculator
    $operation = $_POST['operation']; //type of math operation in calculator

    //Are fields filed?
    if(empty($operation) || (empty($number1) && $number1 != '0') || (empty($number2) && $number2 != '0')) {
        $error_message = 'One or more fields are not filed';
    }
    else {
        //Are there number in the fields?
        if (!is_numeric($number1) || !is_numeric(($number2))) {
            $error_message = 'One or more operands are not number';
        }
    }
    //
    if(isset($error_message)) {
        echo $error_message;
    } else{ //If the checks passed
        //Create object Calc
        $classname = "\operations\\" .$operation;  // from the class name
        $obj = new Calc($number1, $number2, new $classname() );  // Create main object

        // Generate Get parameters
        //in get parameters we pass all operations from "/operations" directory to provide use in the calculator
        $array_operations = Calc::get_operations();
        $str_param = ""; // initialization
        foreach ($array_operations as $index => $classname) {
            $classname = "\operations\\" . $classname;
            $str_param .= "name" . $index . "=" . $classname::Name . "&operator" . $index . "=" . urlencode($classname::Operator) ;
            if (!($index == count($array_operations)-1)) // don't add "&" if last element in massive
                $str_param .= "&";
        }
        // Return to the index2.php with get parameters (with Result)
        $urlArray = parse_url($_SERVER['HTTP_REFERER']);
        $newUrl = $urlArray['scheme'].'://'.$urlArray['host'].$urlArray['path'];
        header("Location: " . $newUrl . "?" .  $str_param . '&Result=' . $obj->result() ); // Возвращаеся на станицу index2.php и возвращаем результат
        exit;
    }

}

// At the first opening return to index2.php all operations supported by the calculator
if (isset($_GET['loadoperator'])) {

    $array_operations = Calc::get_operations(); // list of operation from file name in "directory operations"

    $str_param = ""; // initialization
    //build string with GET parameters
    foreach ($array_operations as $index => $classname) {
        $classname = "\operations\\" . $classname;
        $obj = new $classname(); // Create all operations objects for loader
        $str_param .= "name" . $index . "=" . $classname::Name . "&operator" . $index . "=" . urlencode($classname::Operator) ;
        if (!($index == count($array_operations)-1)) // don't add "&" if last element in massive
            $str_param .= "&";
    }
    header("Location: /index2.php?" .$str_param); //return to the index2.php

}