SELECT Messages.*, Utilisateurs.user_pseudo FROM `Messages`
INNER JOIN Utilisateurs ON Messages.message_user_id = Utilisateurs.user_id
WHERE message_datetime > DATE_SUB(NOW(),INTERVAL 24 HOUR);