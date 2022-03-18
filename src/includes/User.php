<?php

require_once __DIR__.'\BD.php';

class User {
    private $id;
    private $email;
    private $password;
    private $role;

    private function __construct($id = null, $email, $password, $role) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    public function hasRole($role) {
        return ($this->role === $role) ? true : false;
    }

    public static function findUserByEmail($email) {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM User U WHERE U.email='%s'", $conn->real_escape_string($email));
        $rs = $conn->query($query);
        $user = false;

        if ($rs) {
            $row = $rs->fetch_assoc();  
            if ($row)
                $user = new User($row['u_id'], $row['email'], $row['password'], $row['role']);
            $rs->free();
        } else
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        return $user;
    }

    public static function findUserById($idUser) {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("select * from User where u_id=%d", $idUser);
        $rs = $conn->query($query);
        $result = false;

        if ($rs) {
            $row = $rs->fetch_assoc();
            if ($row) {
                $result = new User($row['id'], $row['email'], $row['password'], $row['role']);
            }
            $rs->free();
        } else
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        return false;
    }

    public static function login($email, $password) {
        $user = self::findUserByEmail($email);
        
        return ($user && $user->verifyPassword($password)) ? $user : false;
    }

    private static function hashPassword($password) {
        $options = [
            'cost' => 12
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }
   
    private static function insertUser($user) {
        $auxUser = User::findUserByEmail($user->getEmail());

        if(!$auxUser) {
            $result = false;
            $conn = BD::getInstance()->getConexionBd();
            $query= sprintf("insert into User(email, password, role) VALUES ('%s', '%s', '%s')"
                , $conn->real_escape_string($user->email)
                , $conn->real_escape_string($user->password)
                , $conn->real_escape_string($user->role)
            );

            if ( ($result = $conn->query($query)) )
                $user->id = $conn->insert_id;
            else
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            
            return $result;
        } else
            return false;        
    }    
    
    private static function update($user) {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query=sprintf("update User U set email = '%s', password='%s', role='%s' where U.u_id=%d"
            , $conn->real_escape_string($user->email)
            , $conn->real_escape_string($user->password)
            , $conn->real_escape_string($user->role)
            , $user->id
        );

        $result = $conn->query($query);

        if (!$result)
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        return $result;
    }

    public function save() {
        if ($this->id !== null) {
            return self::update($this);
        }
        return self::insertUser($this);
    }

    public function changePassword($newPassword) {
        $this->password = self::hashPassword($newPassword);
    }

    public static function createUser($email, $password, $role) {
        $user = new User(null, $email, self::hashPassword($password), $role);
        return $user->save();
    }
    
    private static function deleteUser($user) {
        return self::deleteUserById($user->id);
    }
    
    private static function deleteUserById($idUser) {
        if (!$idUser)
            return false;
        
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("delete from User U where U.u_id = %d", $idUser);

        if ( !$conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }

        return true;
    }

    public function delete() {
        return ($this->id !== null) ? self::deleteUser($this) : false;
    }
    
}
