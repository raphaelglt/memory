INSERT INTO Scores (score_user_id, score_game_id, score_level, score_value, score_stopwatch, score_datetime)
VALUES (:score_user_id, :score_game_id, :score_level, :score_value, :score_stopwatch, NOW());
--change values by input values