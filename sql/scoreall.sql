SELECT game_name,score_level,user_pseudo,score_value,score_datetime FROM Scores
INNER JOIN Utilisateurs ON Scores.score_user_id = Utilisateurs.user_id
INNER JOIN Jeux ON Scores.score_game_id = Jeux.game_id
ORDER BY score_level ASC, game_name ASC, score_value DESC;