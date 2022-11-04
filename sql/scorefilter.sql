SELECT game_name,score_level,user_pseudo,score_value FROM Scores
INNER JOIN Utilisateurs ON Scores.score_user_id = Utilisateurs.user_id
INNER JOIN Jeux ON Scores.score_game_id = Jeux.game_id
WHERE game_name = "The Power Of Memory" AND score_level="easy" AND user_id="1"
ORDER BY game_name ASC, score_level ASC, score_value ASC