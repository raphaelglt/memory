SELECT * FROM Utilisateurs
WHERE user_email = "test@gmail.com" AND user_password = "test2passwordverysecure";
--change user_email and user_password by inputs values
--password must be hashed
--if no return then either mail or password is incorrect