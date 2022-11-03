UPDATE Utilisateurs
SET user_password = "test2passwordverysecure"
WHERE user_id = 1;
--change user_id by the good user's id and user_password by input value
--don't forget to hash the new password ;-)