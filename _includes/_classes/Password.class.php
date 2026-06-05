<?php

require_once 'Email.class.php';
require_once 'DB.class.php';

class PasswordReset{
    private $db;
    private $email;

    public function __construct()
    {
        $this->db = new DB();
        $this->email = new Email();
    }

    public function generateToken($email)
    {
        $token = bin2hex(random_bytes(16)); // Generate a random token
        $this->db->modify("INSERT INTO password_reset_tokens (email, token) VALUES (?, ?)", [$email, $token]);
        return $token;
    }

    public function sendPasswordResetLink($email)
    {
        $user = $this->db->exists($email, 'email', 'users');
        if (!$user) {
            return false; // User does not exist
        }

        $token = $this->generateToken($email);

        // Build the password reset link
        $resetLink = "https://bitview.net/reset-password.php?email=" . urlencode((string) $email) . "&token=" . $token;

        $this->email->To = $user["email"];
        $this->email->To_Name = "BitView User";
        $this->email->Subject = 'Reset Your Password';
        $this->email->send_email("Please click on the following link to reset your password: $resetLink");

        return true;
    }

    public function resetPassword($email, $token, $password)
    {
        // Check if the token is valid
        $validToken = $this->db->exists($token, 'token', 'password_reset_tokens');
        if (!$validToken || $validToken['email'] !== $email) {
            return false; // Invalid token or email
        }

        // Update the user's password
        $this->db->modify("UPDATE users SET password = ? WHERE email = ?", [password_hash((string) $password, PASSWORD_BCRYPT), $email]);

        // Delete the token
        $this->db->modify("DELETE FROM password_reset_tokens WHERE token = ?", [$token]);

        return true;
    }
}
