SELECT id_user, COUNT(id_reservation) AS total_reservations
FROM reservation
GROUP BY id_user
HAVING COUNT(id_reservation) > 2;
ORDER BY asc





