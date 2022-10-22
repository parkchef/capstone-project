"use strict";

function initCalendar(NioApp, $, guard_ID) {
    "use strict"; // Variable

    var $win = $(window),
        $body = $('body'),
        breaks = NioApp.Break;

    NioApp.Calendar = function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
        var t_dd = String(tomorrow.getDate()).padStart(2, '0');
        var t_mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
        var t_yyyy = tomorrow.getFullYear();
        var yesterday = new Date(today);
        yesterday.setDate(today.getDate() - 1);
        var y_dd = String(yesterday.getDate()).padStart(2, '0');
        var y_mm = String(yesterday.getMonth() + 1).padStart(2, '0');
        var y_yyyy = yesterday.getFullYear();
        var YM = yyyy + '-' + mm;
        var YESTERDAY = y_yyyy + '-' + y_mm + '-' + y_dd;
        var TODAY = yyyy + '-' + mm + '-' + dd;
        var TOMORROW = t_yyyy + '-' + t_mm + '-' + t_dd;
        var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var calendarEl = document.getElementById('calendar');
        var eventsEl = document.getElementById('externalEvents');
        var removeEvent = document.getElementById('removeEvent');
        var addEventBtn = $('#addEvent');
        var addEventForm = $('#addEventForm');
        var addEventPopup = $('#addEventPopup');
        var updateEventBtn = $('#updateEvent');
        var editEventForm = $('#editEventForm');
        var editEventPopup = $('#editEventPopup');
        var previewEventPopup = $('#previewEventPopup');
        var deleteEventBtn = $('#deleteEvent');
        var mobileView = NioApp.Win.width < NioApp.Break.md ? true : false;
        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'UTC+8',
            initialView: mobileView ? 'listWeek' : 'dayGridMonth',
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'title prev,next',
                center: null,
                right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            height: 800,
            contentHeight: 780,
            aspectRatio: 3,
            editable: false,
            droppable: true,
            views: {
                dayGridMonth: {
                    dayMaxEventRows: 2
                }
            },
            direction: NioApp.State.isRTL ? "rtl" : "ltr",
            nowIndicator: true,
            now: TODAY,
            eventDragStart: function eventDragStart(info) {
                $('.popover').popover('hide');
            },
            eventMouseEnter: function eventMouseEnter(info) {
                $(info.el).popover({
                    template: '<div class="popover"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                    title: info.event._def.title,
                    content: info.event._def.extendedProps.description,
                    placement: 'top'
                });
                info.event._def.extendedProps.description ? $(info.el).popover('show') : $(info.el).popover('hide');
            },
            eventMouseLeave: function eventMouseLeave(info) {
                $(info.el).popover('hide');
            },
            eventClick: function eventClick(info) {

                const orderStatus_arr = [
                    '<span class="badge badge-dim badge-outline-warning">Pending</span>',
                    '<span class="badge badge-dim badge-outline-info">Accepted</span>',
                    '<span class="badge badge-dim badge-outline-danger">Rejected</span>',
                    '<span class="badge badge-dim badge-outline-info">Ongoing</span>',
                    '<span class="badge badge-dim badge-outline-success">Completed</span>'
                ];
                // Get data
                var title = info.event._def.title;
                var description = info.event._def.extendedProps.description;
				
                var start = info.event._instance.range.start;
				

                var startDate = start.getFullYear() + '-' + String(start.getMonth() + 1).padStart(2, '0') + '-' + String(start.getDate()).padStart(2, '0');
                var startTime = start.toUTCString().split(' ');
                startTime = startTime[startTime.length - 2];
                startTime = startTime == '00:00:00' ? '' : startTime;
				
                var end = info.event._instance.range.end;
                var endDate = end.getFullYear() + '-' + String(end.getMonth() + 1).padStart(2, '0') + '-' + String(end.getDate()).padStart(2, '0');
                var endTime = end.toUTCString().split(' ');
                endTime = endTime[endTime.length - 2];
                endTime = endTime == '00:00:00' ? '' : endTime;

                var startLoc = info.event._def.extendedProps.startloc;
                var endLoc = info.event._def.extendedProps.endloc ?? info.event._def.extendedProps.startloc;
                var serviceType = info.event._def.extendedProps.servicetype;
                var orderStatus = orderStatus_arr[parseInt(info.event._def.extendedProps.orderstatus)];



				var clean_start = info.event._def.extendedProps.clean_start;
				var clean_end = info.event._def.extendedProps.clean_end;

                var className = info.event._def.ui.classNames[0].slice(3);

                var eventId = info.event._def.publicId; //Set data in eidt form

				console.log(parseInt(info.event._def.extendedProps.orderstatus))

                $('#edit-event-title').val(title);
                $('#edit-event-start-date').val(startDate).datepicker('update');
                $('#edit-event-end-date').val(endDate).datepicker('update');
                $('#edit-event-start-time').val(startTime);
                $('#edit-event-end-time').val(endTime);
                $('#edit-event-description').val(description);
                $('#edit-event-theme').val(className);
                $('#edit-event-theme').trigger('change.select2');
                editEventForm.attr('data-id', eventId); // Set data in preview

                var previewStart = String(start.getDate()).padStart(2, '0') + ' ' + month[start.getMonth()] + ' ' + start.getFullYear() + (startTime ? ' - ' + to12(startTime) : '');
                var previewEnd = String(end.getDate()).padStart(2, '0') + ' ' + month[end.getMonth()] + ' ' + end.getFullYear() + (endTime ? ' - ' + to12(endTime) : '');
                $('#preview-event-title').text(title);
                $('#preview-event-header').addClass('fc-' + className);
                //$('#preview-event-start').text(previewStart);
                //$('#preview-event-end').text(previewEnd);
				$('#preview-event-start').text(clean_start);
                $('#preview-event-end').text(clean_end);
                $('#preview-event-start-loc').text(startLoc);
                $('#preview-event-end-loc').text(endLoc);
                $('#preview-event-service-type').text(serviceType);
                $('#preview-event-order-status').html(orderStatus);
                $('#preview-event-description').text(description);
				$('#preview-event-description-check').css('display', description == "" ? "none" : "block");
				
				if (parseInt(info.event._def.extendedProps.orderstatus) == 6){
					$('#div-start-loc').css("display", "none");
					$('#div-end-loc').css("display", "none");
					$('#div-service-type').css("display", "none");
					$('#div-status').css("display", "none");
					$('#div-delete-event').css("display", "block");
				}else{
					$('#div-start-loc').css("display", "block");
					$('#div-end-loc').css("display", "block");
					$('#div-service-type').css("display", "block");
					$('#div-status').css("display", "block");
					$('#div-delete-event').css("display", "none");
				}
				
				
                previewEventPopup.modal('show');
                $('.popover').popover('hide');
            },
            // events are here
            events: []
        });


        calendar.render();

        // add event
        const eventClass_arr = [
            "event-warning",
            "event-info",
            "event-danger",
            "event-info",
            "event-success",
			"event-danger",
			"event-danger"
        ];
        $.post("sp/guard_operations.php", {
                calendar: guard_ID,
            },
            function(data, status) {
                if (status == 'success') {
                    try {
                        data = JSON.parse(data);
                        console.log(data);

                        for (var ind = 0; ind < data['events'].length; ind++) {
                            var dt_event = data['events'][ind];

                            var eventStartDate = dt_event['start_datetime'].split(" ")[0];
                            var eventStartTimeCheck = "T" + dt_event['start_datetime'].split(" ")[1] + "Z";

                            var eventEndDate = dt_event['end_datetime'].split(" ")[0];
                            var eventEndTimeCheck = "T" + dt_event['end_datetime'].split(" ")[1] + "Z";

                            var eventTheme = eventClass_arr[parseInt(dt_event['order_status'])];
                            var eventDescription = dt_event['order_desc'] == "" || dt_event['order_desc'] == null ? "No order description" : dt_event['order_desc'];

                            calendar.addEvent({
                                id: 'event-order-id-' + dt_event['order_ID'],
                                title: parseInt(dt_event['order_status']) != 6 ? dt_event['sub_category_name'] : dt_event['order_desc'].split("|")[0],
                                start: eventStartDate + eventStartTimeCheck,
                                end: eventEndDate + eventEndTimeCheck,
								clean_start: dt_event['formatted_start'],
								clean_end: dt_event['formatted_end'],
                                className: "fc-" + eventTheme,
                                description: parseInt(dt_event['order_status']) != 6 ? eventDescription : dt_event['order_desc'].split("|")[1],
                                servicetype: dt_event['service_type'],
                                startloc: dt_event['start_location'],
                                endloc: dt_event['end_location'],
                                orderstatus: dt_event['order_status']
                            });
                        }
                    } catch (err) {
                        console.log(data);
                        console.log("Calendar: failed to get events");
                        console.log("Error: " + err);
                    }
                } else {
                    console.log("Calendar: failed to get events");
                }
            }
        );

        addEventBtn.on("click", function(e) {
            e.preventDefault();
            var eventTitle = $('#event-title').val();
            var eventStartDate = $('#event-start-date').val();
            var eventEndDate = $('#event-end-date').val();
            var eventStartTime = $('#event-start-time').val();
            var eventEndTime = $('#event-end-time').val();
            var eventDescription = $('#event-description').val();
            var eventTheme = $('#event-theme').val();
            var eventStartTimeCheck = eventStartTime ? 'T' + eventStartTime + 'Z' : '';
            var eventEndTimeCheck = eventEndTime ? 'T' + eventEndTime + 'Z' : '';

            console.log(eventStartDate);
            console.log(eventEndDate);
            console.log(eventStartTime);
            console.log(eventEndTime);

            $.post("sp/guard_operations.php", {
                    calendar_add_leave: guard_ID,
					title: eventTitle,
					start: eventStartDate + eventStartTimeCheck,
					end: eventEndDate + eventEndTimeCheck,
					desc: eventDescription
                },
                function(data, status) {
                    if (status == 'success') {
                        try {
                            data = JSON.parse(data);
                            console.log(data);
							calendar.addEvent({
								id: 'event-order-id-' + data['leave_id'],
								title: eventTitle,
								start: eventStartDate + eventStartTimeCheck,
								end: eventEndDate + eventEndTimeCheck,
								clean_start: eventStartDate + eventStartTimeCheck,
								clean_end: eventEndDate + eventEndTimeCheck,
								className: "fc-" + 'event-danger',
								description: eventDescription,
								orderstatus: 6
							});
							addEventPopup.modal('hide');
							Swal.fire({
								text: "Leave added successfully!",
								icon: "info",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
							console.log("Calender: added leave successfully!");
                        } catch (err) {
                            console.log(data);
                            console.log("Calendar: failed to insert leave");
                            console.log("Error: " + err);
							addEventPopup.modal('hide');
							Swal.fire({
								text: "Failed to insert leave!",
								icon: "error",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
                        }
                    } else {
                        console.log("Calendar: failed to insert leave");
                    }
                }
            );

        });

        deleteEventBtn.on("click", function(e) {
            e.preventDefault();
            console.log(editEventForm[0].dataset.id);
			var order_ID = editEventForm[0].dataset.id.split('event-order-id-')[1];
			console.log(order_ID);
			$.post("sp/guard_operations.php", {
                    calendar_del_leave: guard_ID,
					order_ID: order_ID
                },
                function(data, status) {
                    if (status == 'success') {
                        try {
                            data = JSON.parse(data);
                            console.log(data);
							Swal.fire({
								text: "Removed leave successfully!",
								icon: "info",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
							var selectEvent = calendar.getEventById(editEventForm[0].dataset.id);
							selectEvent.remove();
                        } catch (err) {
                            console.log(data);
                            console.log("Calendar: failed to remove leave");
                            console.log("Error: " + err);
							Swal.fire({
								text: "Failed to remove leave!",
								icon: "error",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
                        }
                    } else {
                        console.log("Calendar: failed to remove leave");
                    }
                }
            );
        });

        function to12(time) {
            time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

            if (time.length > 1) {
                time = time.slice(1);
                time.pop();
                time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM

                time[0] = +time[0] % 12 || 12;
            }

            time = time.join('');
            return time;
        }

        function customCalSelect(cat) {
            if (!cat.id) {
                return cat.text;
            }

            var $cat = $('<span class="fc-' + cat.element.value + '"> <span class="dot"></span>' + cat.text + '</span>');
            return $cat;
        };

        $(".select-calendar-theme").select2({
            templateResult: customCalSelect
        });
        addEventPopup.on('hidden.bs.modal', function(e) {
            setTimeout(function() {
                $('#addEventForm input,#addEventForm textarea').val('');
                $('#event-theme').val('event-primary');
                $('#event-theme').trigger('change.select2');
            }, 1000);
        });
        previewEventPopup.on('hidden.bs.modal', function(e) {
            $('#preview-event-header').removeClass().addClass('modal-header');
        });
    };


    NioApp.coms.docReady.push(NioApp.Calendar);
};

function initCalendarVehicle(NioApp, $, vehicle_ID) {
    "use strict"; // Variable

    var $win = $(window),
        $body = $('body'),
        breaks = NioApp.Break;

    NioApp.Calendar = function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        var tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
        var t_dd = String(tomorrow.getDate()).padStart(2, '0');
        var t_mm = String(tomorrow.getMonth() + 1).padStart(2, '0');
        var t_yyyy = tomorrow.getFullYear();
        var yesterday = new Date(today);
        yesterday.setDate(today.getDate() - 1);
        var y_dd = String(yesterday.getDate()).padStart(2, '0');
        var y_mm = String(yesterday.getMonth() + 1).padStart(2, '0');
        var y_yyyy = yesterday.getFullYear();
        var YM = yyyy + '-' + mm;
        var YESTERDAY = y_yyyy + '-' + y_mm + '-' + y_dd;
        var TODAY = yyyy + '-' + mm + '-' + dd;
        var TOMORROW = t_yyyy + '-' + t_mm + '-' + t_dd;
        var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var calendarEl = document.getElementById('calendar');
        var eventsEl = document.getElementById('externalEvents');
        var removeEvent = document.getElementById('removeEvent');
        var addEventBtn = $('#addEvent');
        var addEventForm = $('#addEventForm');
        var addEventPopup = $('#addEventPopup');
        var updateEventBtn = $('#updateEvent');
        var editEventForm = $('#editEventForm');
        var editEventPopup = $('#editEventPopup');
        var previewEventPopup = $('#previewEventPopup');
        var deleteEventBtn = $('#deleteEvent');
        var mobileView = NioApp.Win.width < NioApp.Break.md ? true : false;
        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'UTC+8',
            initialView: mobileView ? 'listWeek' : 'dayGridMonth',
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'title prev,next',
                center: null,
                right: 'today dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            height: 800,
            contentHeight: 780,
            aspectRatio: 3,
            editable: false,
            droppable: true,
            views: {
                dayGridMonth: {
                    dayMaxEventRows: 2
                }
            },
            direction: NioApp.State.isRTL ? "rtl" : "ltr",
            nowIndicator: true,
            now: TODAY,
            eventDragStart: function eventDragStart(info) {
                $('.popover').popover('hide');
            },
            eventMouseEnter: function eventMouseEnter(info) {
                $(info.el).popover({
                    template: '<div class="popover"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
                    title: info.event._def.title,
                    content: info.event._def.extendedProps.description,
                    placement: 'top'
                });
                info.event._def.extendedProps.description ? $(info.el).popover('show') : $(info.el).popover('hide');
            },
            eventMouseLeave: function eventMouseLeave(info) {
                $(info.el).popover('hide');
            },
            eventClick: function eventClick(info) {

                const orderStatus_arr = [
                    '<span class="badge badge-dim badge-outline-warning">Pending</span>',
                    '<span class="badge badge-dim badge-outline-info">Accepted</span>',
                    '<span class="badge badge-dim badge-outline-danger">Rejected</span>',
                    '<span class="badge badge-dim badge-outline-info">Ongoing</span>',
                    '<span class="badge badge-dim badge-outline-success">Completed</span>'
                ];
                // Get data
                var title = info.event._def.title;
                var description = info.event._def.extendedProps.description;
				
                var start = info.event._instance.range.start;
				

                var startDate = start.getFullYear() + '-' + String(start.getMonth() + 1).padStart(2, '0') + '-' + String(start.getDate()).padStart(2, '0');
                var startTime = start.toUTCString().split(' ');
                startTime = startTime[startTime.length - 2];
                startTime = startTime == '00:00:00' ? '' : startTime;
				
                var end = info.event._instance.range.end;
                var endDate = end.getFullYear() + '-' + String(end.getMonth() + 1).padStart(2, '0') + '-' + String(end.getDate()).padStart(2, '0');
                var endTime = end.toUTCString().split(' ');
                endTime = endTime[endTime.length - 2];
                endTime = endTime == '00:00:00' ? '' : endTime;

                var startLoc = info.event._def.extendedProps.startloc;
                var endLoc = info.event._def.extendedProps.endloc ?? info.event._def.extendedProps.startloc;
                var serviceType = info.event._def.extendedProps.servicetype;
                var orderStatus = orderStatus_arr[parseInt(info.event._def.extendedProps.orderstatus)];



				var clean_start = info.event._def.extendedProps.clean_start;
				var clean_end = info.event._def.extendedProps.clean_end;

                var className = info.event._def.ui.classNames[0].slice(3);

                var eventId = info.event._def.publicId; //Set data in eidt form

				console.log(parseInt(info.event._def.extendedProps.orderstatus))

                $('#edit-event-title').val(title);
                $('#edit-event-start-date').val(startDate).datepicker('update');
                $('#edit-event-end-date').val(endDate).datepicker('update');
                $('#edit-event-start-time').val(startTime);
                $('#edit-event-end-time').val(endTime);
                $('#edit-event-description').val(description);
                $('#edit-event-theme').val(className);
                $('#edit-event-theme').trigger('change.select2');
                editEventForm.attr('data-id', eventId); // Set data in preview

                var previewStart = String(start.getDate()).padStart(2, '0') + ' ' + month[start.getMonth()] + ' ' + start.getFullYear() + (startTime ? ' - ' + to12(startTime) : '');
                var previewEnd = String(end.getDate()).padStart(2, '0') + ' ' + month[end.getMonth()] + ' ' + end.getFullYear() + (endTime ? ' - ' + to12(endTime) : '');
                $('#preview-event-title').text(title);
                $('#preview-event-header').addClass('fc-' + className);
                //$('#preview-event-start').text(previewStart);
                //$('#preview-event-end').text(previewEnd);
				$('#preview-event-start').text(clean_start);
                $('#preview-event-end').text(clean_end);
                $('#preview-event-start-loc').text(startLoc);
                $('#preview-event-end-loc').text(endLoc);
                $('#preview-event-service-type').text(serviceType);
                $('#preview-event-order-status').html(orderStatus);
                $('#preview-event-description').text(description);
				$('#preview-event-description-check').css('display', description == "" ? "none" : "block");
				
				if (parseInt(info.event._def.extendedProps.orderstatus) == 6){
					$('#div-start-loc').css("display", "none");
					$('#div-end-loc').css("display", "none");
					$('#div-service-type').css("display", "none");
					$('#div-status').css("display", "none");
					$('#div-delete-event').css("display", "block");
				}else{
					$('#div-start-loc').css("display", "block");
					$('#div-end-loc').css("display", "block");
					$('#div-service-type').css("display", "block");
					$('#div-status').css("display", "block");
					$('#div-delete-event').css("display", "none");
				}
				
				
                previewEventPopup.modal('show');
                $('.popover').popover('hide');
            },
            // events are here
            events: []
        });


        calendar.render();

        // add event
        const eventClass_arr = [
            "event-warning",
            "event-info",
            "event-danger",
            "event-info",
            "event-success",
			"event-danger",
			"event-danger"
        ];
        $.post("sp/vehicle_operations.php", {
                calendar: vehicle_ID,
            },
            function(data, status) {
                if (status == 'success') {
                    try {
                        data = JSON.parse(data);
                        console.log(data);

                        for (var ind = 0; ind < data['events'].length; ind++) {
                            var dt_event = data['events'][ind];

                            var eventStartDate = dt_event['start_datetime'].split(" ")[0];
                            var eventStartTimeCheck = "T" + dt_event['start_datetime'].split(" ")[1] + "Z";

                            var eventEndDate = dt_event['end_datetime'].split(" ")[0];
                            var eventEndTimeCheck = "T" + dt_event['end_datetime'].split(" ")[1] + "Z";

                            var eventTheme = eventClass_arr[parseInt(dt_event['order_status'])];
                            var eventDescription = dt_event['order_desc'] == "" || dt_event['order_desc'] == null ? "No order description" : dt_event['order_desc'];

                            calendar.addEvent({
                                id: 'event-order-id-' + dt_event['order_ID'],
                                title: parseInt(dt_event['order_status']) != 6 ? dt_event['sub_category_name'] : dt_event['order_desc'].split("|")[0],
                                start: eventStartDate + eventStartTimeCheck,
                                end: eventEndDate + eventEndTimeCheck,
								clean_start: dt_event['formatted_start'],
								clean_end: dt_event['formatted_end'],
                                className: "fc-" + eventTheme,
                                description: parseInt(dt_event['order_status']) != 6 ? eventDescription : dt_event['order_desc'].split("|")[1],
                                servicetype: dt_event['service_type'],
                                startloc: dt_event['start_location'],
                                endloc: dt_event['end_location'],
                                orderstatus: dt_event['order_status']
                            });
                        }
                    } catch (err) {
                        console.log(data);
                        console.log("Calendar: failed to get events");
                        console.log("Error: " + err);
                    }
                } else {
                    console.log("Calendar: failed to get events");
                }
            }
        );

        addEventBtn.on("click", function(e) {
            e.preventDefault();
            var eventTitle = $('#event-title').val();
            var eventStartDate = $('#event-start-date').val();
            var eventEndDate = $('#event-end-date').val();
            var eventStartTime = $('#event-start-time').val();
            var eventEndTime = $('#event-end-time').val();
            var eventDescription = $('#event-description').val();
            var eventTheme = $('#event-theme').val();
            var eventStartTimeCheck = eventStartTime ? 'T' + eventStartTime + 'Z' : '';
            var eventEndTimeCheck = eventEndTime ? 'T' + eventEndTime + 'Z' : '';

            console.log(eventStartDate);
            console.log(eventEndDate);
            console.log(eventStartTime);
            console.log(eventEndTime);

            $.post("sp/vehicle_operations.php", {
                    calendar_add_leave: vehicle_ID,
					title: eventTitle,
					start: eventStartDate + eventStartTimeCheck,
					end: eventEndDate + eventEndTimeCheck,
					desc: eventDescription
                },
                function(data, status) {
                    if (status == 'success') {
                        try {
                            data = JSON.parse(data);
                            console.log(data);
							calendar.addEvent({
								id: 'event-order-id-' + data['leave_id'],
								title: eventTitle,
								start: eventStartDate + eventStartTimeCheck,
								end: eventEndDate + eventEndTimeCheck,
								clean_start: eventStartDate + eventStartTimeCheck,
								clean_end: eventEndDate + eventEndTimeCheck,
								className: "fc-" + 'event-danger',
								description: eventDescription,
								orderstatus: 6
							});
							addEventPopup.modal('hide');
							Swal.fire({
								text: "Leave added successfully!",
								icon: "info",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
							console.log("Calender: added leave successfully!");
                        } catch (err) {
                            console.log(data);
                            console.log("Calendar: failed to insert leave");
                            console.log("Error: " + err);
							addEventPopup.modal('hide');
							Swal.fire({
								text: "Failed to insert leave!",
								icon: "error",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
                        }
                    } else {
                        console.log("Calendar: failed to insert leave");
                    }
                }
            );

        });

        deleteEventBtn.on("click", function(e) {
            e.preventDefault();
            console.log(editEventForm[0].dataset.id);
			var order_ID = editEventForm[0].dataset.id.split('event-order-id-')[1];
			console.log(order_ID);
			$.post("sp/vehicle_operations.php", {
                    calendar_del_leave: vehicle_ID,
					order_ID: order_ID
                },
                function(data, status) {
                    if (status == 'success') {
                        try {
                            data = JSON.parse(data);
                            console.log(data);
							Swal.fire({
								text: "Removed leave successfully!",
								icon: "info",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
							var selectEvent = calendar.getEventById(editEventForm[0].dataset.id);
							selectEvent.remove();
                        } catch (err) {
                            console.log(data);
                            console.log("Calendar: failed to remove leave");
                            console.log("Error: " + err);
							Swal.fire({
								text: "Failed to remove leave!",
								icon: "error",
								confirmButtonText: "OK",
								confirmButtonColor: "#00897B"
							});
                        }
                    } else {
                        console.log("Calendar: failed to remove leave");
                    }
                }
            );
        });

        function to12(time) {
            time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

            if (time.length > 1) {
                time = time.slice(1);
                time.pop();
                time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM

                time[0] = +time[0] % 12 || 12;
            }

            time = time.join('');
            return time;
        }

        function customCalSelect(cat) {
            if (!cat.id) {
                return cat.text;
            }

            var $cat = $('<span class="fc-' + cat.element.value + '"> <span class="dot"></span>' + cat.text + '</span>');
            return $cat;
        };

        $(".select-calendar-theme").select2({
            templateResult: customCalSelect
        });
        addEventPopup.on('hidden.bs.modal', function(e) {
            setTimeout(function() {
                $('#addEventForm input,#addEventForm textarea').val('');
                $('#event-theme').val('event-primary');
                $('#event-theme').trigger('change.select2');
            }, 1000);
        });
        previewEventPopup.on('hidden.bs.modal', function(e) {
            $('#preview-event-header').removeClass().addClass('modal-header');
        });
    };


    NioApp.coms.docReady.push(NioApp.Calendar);
};