SELECT
    projects.id,
    projects.title,
    projects.introduction,
    project_photos.id AS photo_id,
    project_photos.caption AS photo_caption

FROM
    projects

INNER JOIN
    project_photos ON
    (
        project_photos.project_id = projects.id
        AND
        project_photos.display_order = 1
    )

ORDER BY
    projects.completed_date,
    projects.title