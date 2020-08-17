<?php

namespace app\models;

class Auth extends \app\core\Model
{
    public function registerUser($data)
    {
        $email = null;
        $phoneNumber = null;
        $bornDate = implode(' ', $data['bornDate']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        if (strpos($data['emailOrPassword'], '@') !== false) {
            $email = $data['emailOrPassword'];
        } else {
            $phoneNumber = $data['emailOrPassword'];
        }

        $this->db->row("
            INSERT INTO `users` 
                (`first_name`, `last_name`, `email`, `phone_number`, `password`, `gender`, `born_date`, `ip`) 
            VALUES
                ('{$data['firstName']}', '{$data['lastName']}', '$email', '$phoneNumber', '$password', '{$data['gender']}', '$bornDate', '{$_SERVER['REMOTE_ADDR']}');");

    }
}