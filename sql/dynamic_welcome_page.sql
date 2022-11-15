SELECT 
(SELECT COUNT(*) FROM Scores) as count_scores,
(SELECT COUNT(*) FROM Utilisateurs) as count_users,
(SELECT score_stopwatch FROM Scores WHERE score_level = 'impossible' GROUP BY score_stopwatch ASC LIMIT 1) as best_score,
(SELECT COUNT(*) FROM Utilisateurs WHERE user_last_connection > date_sub(now(), interval 5 minute)) as users_connected