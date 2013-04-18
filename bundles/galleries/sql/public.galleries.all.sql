SELECT
    galleries.id,
    galleries.title,
    gallery_photos.id AS photo_id,
    gallery_photos.caption AS photo_caption

FROM
    galleries

INNER JOIN
    gallery_photos ON
    (
        gallery_photos.gallery_id = galleries.id
        AND
        gallery_photos.display_order = 1
    )

ORDER BY
    galleries.display_order