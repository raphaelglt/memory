UPDATE Utilisateurs
SET user_password = :user_password
WHERE user_id = 1;
--change user_id by the good user's id and user_password by input value
--don't forget to hash the new password ;-)