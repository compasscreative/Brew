SELECT
    blog_articles.id,
    blog_articles.title,
    blog_articles.status,
    blog_articles.published_date,
    blog_categories.name as category_name

FROM
    blog_articles

LEFt JOIN
    blog_categories ON
    (
        blog_categories.id = blog_articles.category_id
    )

ORDER BY
    blog_articles.published_date DESC