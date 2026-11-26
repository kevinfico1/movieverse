USE movieverse;

INSERT IGNORE INTO movie_categories (movie_id, category_id)
SELECT m.id, c.id
FROM movies m
JOIN categories c
WHERE (m.title = 'Lanterns'             AND c.name IN ('Action', 'Mystery', 'Sci-Fi', 'Drama'))
   OR (m.title = 'Daredevil Born Again' AND c.name IN ('Action', 'Crime', 'Drama', 'Thriller'))
   OR (m.title = 'Spider Noir'          AND c.name IN ('Action', 'Crime', 'Mystery', 'Drama'))
   OR (m.title = 'Vision Quest'         AND c.name IN ('Action', 'Sci-Fi', 'Drama'))
   OR (m.title = 'Breaking Bad'         AND c.name IN ('Crime', 'Drama', 'Thriller'))
   OR (m.title = 'Reacher'              AND c.name IN ('Action', 'Crime', 'Drama', 'Thriller'))
   OR (m.title = 'Ted'                  AND c.name IN ('Comedy', 'Fantasy'))
   OR (m.title = 'Moon Knight'          AND c.name IN ('Action', 'Adventure', 'Fantasy', 'Psychological'))
   OR (m.title = 'Wednesday'            AND c.name IN ('Comedy', 'Fantasy', 'Mystery', 'Supernatural'))
   OR (m.title = 'Stranger Things'      AND c.name IN ('Drama', 'Mystery', 'Sci-Fi', 'Supernatural'))
   OR (m.title = 'Severance'            AND c.name IN ('Drama', 'Mystery', 'Sci-Fi', 'Thriller'))
   OR (m.title = 'The Rookie'           AND c.name IN ('Action', 'Crime', 'Drama'));
