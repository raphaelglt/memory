UPDATE Utilisateurs
SET user_email = "test2@gmail.com"
WHERE user_id = 1 AND NOT EXISTS (
    SELECT user_email
    WHERE user_email = "test2@gmail.com"
);
--change user_id by the good user's id and user_email by input value