UPDATE Utilisateurs
SET user_email = :user_email
WHERE user_id = 1 AND NOT EXISTS (
    SELECT user_email
    WHERE user_email = :user_email
);
--change user_id by the good user's id and user_email by input value