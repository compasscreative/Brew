SELECT
    article.id,
    article.title,
    article.published_date,
    photo.id AS photo_id

FROM
    blog_articles AS article

LEFT JOIN
    blog_photos AS photo ON
    (
        photo.article_id = article.id
        AND
        photo.display_order = 1
    )

WHERE
    article.status = 'Published'
    AND
    article.category_id = :category_id

ORDER BY
    article.published_date DESC