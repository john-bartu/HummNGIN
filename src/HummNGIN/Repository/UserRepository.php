<?php

namespace HummNGIN\Repository;

use PDO;
use HummNGIN\Models\User;

class UserRepository extends BaseRepository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('SELECT * FROM hb_users WHERE email = :email;');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['name'],
            $user['role']
        );
    }

    public function addUser(string $name, string $email, string $password)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO hb_users (name, email, password)
            VALUES (?, ?, ?)
        ');

        $stmt->execute([
            $name,
            $email,
            $password
        ]);
    }
}