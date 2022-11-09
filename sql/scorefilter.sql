SELECT game_name,score_level,user_pseudo,score_value FROM Scores
INNER JOIN Utilisateurs ON Scores.score_user_id = Utilisateurs.user_id
INNER JOIN Jeux ON Scores.score_game_id = Jeux.game_id
WHERE game_name = :game_name AND score_level=:score_level AND user_id=:user_id
ORDER BY game_name ASC, score_level ASC, score_value ASC