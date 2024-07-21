<?php
class User {
    private $xml;

    public function __construct($xml) {
        $this->xml = $xml;
    }

    public function fetchByEmail($email) {
        foreach ($this->xml->user as $user) {
            if ((string)$user->email === $email) {
                return $user;
            }
        }
        return false;
    }
}
?>
