let roomTypeId 	= $('#rooms').attr('room-type-id'); 
let inArrival 	= $('#arrival')
let inDeparture = $('#departure')
let chosenRooms = [];

inArrival.datepicker({
	startDate: new Date()
})

inArrival.on('pick.datepicker', function (e) {
	inDeparture.val('')
	inDeparture.datepicker('destroy')
	inDeparture.datepicker({
		startDate: e.date
	})
})

inDeparture.on('pick.datepicker', function (e) {
	getAvailableRooms()
})

function getAvailableRooms() {

	let arrival = inArrival.datepicker('getDate', true)
	let departure = inDeparture.datepicker('getDate', true)
	let data = {
		'arrival' : arrival,
    	'departure': departure,
    	'roomTypeId': roomTypeId
	}

	$.ajax({
	    url : 'util/get_available_rooms.php',
	    type : 'GET',
	    data : data,
	    dataType:'json',
	    success : displayAvailableRooms
	})

}

function displayAvailableRooms(rooms) {
	
	// Per item holds associative array
	// Object { id: n, number: n, available: 1 or 0 }

	$('#rooms').text('');

	if (!rooms) {
		$('<h6/>').text('No rooms in database.').appendTo('#rooms');
		return;
	}

	rooms.forEach(function(room, index) {

		let elem = $('<div/>')
			.addClass('elem')
			.text(room['number'])
			.attr('room-id', room['id']);

		if (room['available'] == 1) {
			elem.addClass('available')
				.appendTo('#rooms');

			elem.on('click', function(e) {

				if (elem.hasClass('selected')) {
					elem.removeClass('selected')
					remove(chosenRooms, room['id'])
				} else {
					elem.addClass('selected')
					chosenRooms.push(room['id']);
				}

				$('#input-rooms').val(chosenRooms.toString());

			})

		} else {
			elem.appendTo('#rooms');
		}
		
	});
}

function remove(array, element) {
    const index = array.indexOf(element);
    array.splice(index, 1);
}