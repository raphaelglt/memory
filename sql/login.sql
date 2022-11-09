SELECT * FROM Utilisateurs
WHERE user_email = :user_email AND user_password = :user_password;
--change user_email and user_password by inputs values
--password must be hashed
--if no return then either mail or password is incorrect