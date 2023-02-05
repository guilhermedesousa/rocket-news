<?php

namespace app\controllers;

use src\{DatabaseConnection, Validation, ValidationEmail};
use app\models\Email;

class EmailController
{
    public $dbc;

    public function runAction($actionName)
    {
        $actionName .= 'Action';

        if (method_exists($this, $actionName)) {
            $this->$actionName();
        }
    }

    public function defaultAction()
    {
        include ROOT_PATH . 'app/views/index.html';
    }

    public function registerAction()
    {
        if ($_POST['action'] ?? false == true) {
            $email = $_POST['email'] ?? '';

            $validation = new Validation;

            if (!$validation
                ->addRule(new ValidationEmail())
                ->validate($email)) {
                $_SESSION['validationRules']['error'] = $validation->getAllErrorMessages();
            }

            if (($_SESSION['validationRules']['error'] ?? '') == '') {
                $register = new Email($this->dbc, 'emails');
                $existRegister = $register->findBy('email', $email);

                if (!$existRegister) {
                    $register->setValues($_POST);
                    $register->insert();
                }
            }
        }

        include ROOT_PATH . 'app/views/index.html';
        unset($_POST);
        unset($_SESSION['validationRules']['error']);
    }
}