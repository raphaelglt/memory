SELECT 
(SELECT COUNT(*) FROM Scores) as count_scores,
(SELECT COUNT(*) FROM Utilisateurs) as count_users;