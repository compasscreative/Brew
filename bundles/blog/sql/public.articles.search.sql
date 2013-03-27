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

LEFT JOIN
    blog_categories AS category ON
    (
        category.id = article.category_id
    )

WHERE
    article.status = 'Published'
    AND
    (
        article.title LIKE :query
        OR
        category.name LIKE :query
    )

ORDER BY
    article.published_date DESC