<?php

require_once('connection.php');
require_once('util.php');

if (!isset($_GET)) {
	echo json_encode(['message' => 'error']);
}

$db 			= DB::getInstance()->getConnection();
$arrival 		= formatDate($_GET['arrival']);
$departure 		= formatDate($_GET['departure']);
$roomTypeId 	= $_GET['roomTypeId'];

$query = "SELECT room.id, room.number, TRUE AS available FROM room " .
			" LEFT JOIN room_reservation_rooms ON room_reservation_rooms.room_id = room.id" .
			" LEFT JOIN room_reservation ON  room_reservation.id = room_reservation_rooms.room_reservation_id" .
			" WHERE room.room_type_id = ${roomTypeId} " .
			" AND " .
			" (" .
			"	CAST(room_reservation.date_start AS DATE) NOT BETWEEN '${arrival}' AND '${departure}' OR " .
			"	CAST(room_reservation.date_end AS DATE) NOT BETWEEN '${arrival}' AND '${departure}' AND" .
			"   CAST(room_reservation.date_start AS DATE) >= '${arrival}' AND" .
			"   CAST(room_reservation.date_end AS DATE) <= '${departure}' OR" .
			"   room_reservation.date_start IS NULL AND" .
			"   room_reservation.date_end IS NULL" .
			" )" .
			" GROUP BY room.id" .
			" UNION ALL" .
			" SELECT room.id, room.number, FALSE AS available FROM room " .
			" LEFT JOIN room_reservation_rooms ON room_reservation_rooms.room_id = room.id" .
			" LEFT JOIN room_reservation ON  room_reservation.id = room_reservation_rooms.room_reservation_id" .
			" WHERE room.room_type_id = ${roomTypeId} " .
			" AND " .
			" (" .
			"	CAST(room_reservation.date_start AS DATE) BETWEEN '${arrival}' AND '${departure}' OR " .
			"	CAST(room_reservation.date_end AS DATE) BETWEEN '${arrival}' AND '${departure}' AND" .
			"   CAST(room_reservation.date_start AS DATE) <= '${arrival}' AND" .
			"   CAST(room_reservation.date_end AS DATE) >= '${departure}'" .
			" )" .
			" GROUP BY room.id" .
			" ORDER BY number ASC";

$result = $db->query($query);
$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
$db->close();

echo json_encode($rooms);