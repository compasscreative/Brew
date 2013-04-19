SELECT
    products.id,
    products.title,
    products.slug,
    product_photos.id AS photo_id,
    product_photos.caption AS photo_caption

FROM
    products

INNER JOIN
    product_photos ON
    (
        product_photos.product_id = products.id
        AND
        product_photos.display_order = 1
    )

ORDER BY
    products.display_order