//Extend the Date() object.
Date.prototype.getISODay = function(){ return (this.getDay() + 6) % 7; }

//Create a global object.
var g = (function() { return this})();

//Create my object on the global reference to encapsulate my app.
if(!g.hvEvents) { g.hvEvents = { }; }

//Define the enclosing object.
g.hvEvents.constants = { };
g.hvEvents.render = { };
g.hvEvents.cookies = { };

jQuery(document).ready(function($) {
	//Get the events.
	var events = hv_events;
	
	//Merge them.
	events.events = hv_events.past.concat(hv_events.upcoming);
	
	//Define a variable for the container.
	var container = $('article div#hv-events');
	
	//Append the view changer.
	$(container).append('<div id="view-changer" class="clearfix">');
	//Append the view options.
	$('div#view-changer', container)
		.append('<div id="calendar" class="icon">')
		.append('<div id="tiles" class="icon">')
		.append('<div id="rows" class="icon">')
		.append('<div id="save-view" class="border-box">');
	//Append the save option.
	$('div#save-view', container).append('Använd alltid denna vy');
	
	//Clicking on the calendar option should render out events in a calendar view.
	$('div#calendar', container).on('click', function() {
		if($('section#calendar', container).length !== 0) {
			return false;
		}
		
		g.hvEvents.render.CALENDAR(events, container);
	});
	
	//Clicking on the tiles option should render out events ordered in tiles.
	$('div#tiles', container).on('click', function() {
		if($('a.tile', container).length !== 0) {
			return false;
		}
		
		g.hvEvents.render.TILES(events, container);
	});
	
	//Clicking on the rows option should render out events ordered in rows.
	$('div#rows', container).on('click', function() {
		if($('a.row', container).length !== 0) {
			return false;
		}
		
		g.hvEvents.render.ROWS(events, container);
	});
	
	//Clicking on the save option should save the current view in a cookie to be used from now on.
	$('div#save-view', container).on('click', function() {
		g.hvEvents.cookies.create('hv_events_view', $('div#view-changer div.active', container).attr('id'), 7);
		
		$(this).css('background', '#0C6').css('opacity', '1');
		$(this).text('Sparat!');
		
		var that = this;
		
		window.setTimeout(function() {
			$(that).fadeOut('slow', function() {
				$(this).css('background', '#333').css('opacity', '0.3');
				$(this).text('Använd alltid denna vy');
			});
		}, 1500);
	});
	
	//If no cookie is saved then render out the events as tiles.
	if(g.hvEvents.cookies.read('hv_events_view') === null) {
		g.hvEvents.render.CALENDAR(events, container);
	}
	
	//If the cookie is saved as tiles then render out events as tiles.
	else if(g.hvEvents.cookies.read('hv_events_view') === 'tiles') {
		g.hvEvents.render.TILES(events, container);
	}
	
	//If the cookie is saved as rows then render out events as rows.
	else if(g.hvEvents.cookies.read('hv_events_view') === 'rows') {
		g.hvEvents.render.ROWS(events, container);
	}
	
	//If the cookie is saved as calendar then render out events as a calendar.
	else if(g.hvEvents.cookies.read('hv_events_view') === 'calendar') {
		g.hvEvents.render.CALENDAR(events, container);
	}
});




//Set up some constants needed for the calendar.
g.hvEvents.constants.DAYS_LABELS = ['Mån', 'Tis', 'Ons', 'Tors', 'Fre', 'Lör', 'Sön'];

g.hvEvents.constants.MONTH_LABELS = ['Januari', 'Februari', 'Mars', 'April', 'Maj',
									'Juni', 'Juli', 'Augusti', 'September',
									'Oktober', 'November', 'December'];

g.hvEvents.constants.DAYS_IN_MONTH = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

g.hvEvents.constants.CURRENT_DATE = new Date();

g.hvEvents.constants.MAX_NUMBER_NEW_EVENTS = 20;

g.hvEvents.constants.MAX_NUMBER_OLD_EVENTS = 10;

g.hvEvents.CALENDAR = function(month, year) {
	this.month = (isNaN(month) || month == null) ? g.hvEvents.constants.CURRENT_DATE.getMonth() : month;
	this.year = (isNaN(year) || year == null) ? g.hvEvents.constants.CURRENT_DATE.getFullYear() : year;
	this.jQueryObj = null;
}

g.hvEvents.CALENDAR.prototype.generateMarkup = function(container, events) {
	//Save this.
	var that = this;
	
	//Get first day of the month.
	var firstDay = new Date(this.year, this.month, 1);
	var startingDay = firstDay.getISODay();

	//Get number of days in this month.
	var monthLength = Date.getDaysInMonth(this.year, this.month);
	
	//var html will be the generated HTML that is returned.
	var calendarContainer = $('<div id="event-calendar" class="hv-calendar-container">');
	
	//Get the month name from the constant.
	var monthName = g.hvEvents.constants.MONTH_LABELS[this.month];
	
	//Add the month display/changer.
	var hvHeader = $('<div class="hv-header clearfix">');
	$(calendarContainer).append(hvHeader);
	
	//Add the trigger to change to the previous month.
	var previous = $('<div id="previous">');
	$(hvHeader).append(previous);
	
	//Add the calendar legend.
	var hvLegend = $('<div class="hv-legend">');
	$(hvHeader).append(hvLegend);
	
	//Add the month name.
	var spanMonth = $('<span class="month unselectable">' + monthName + '</span>');
	$(hvLegend).append(spanMonth);
	
	//Add the year.
	var inputYear = $('<input class="year" type="text" value="' + this.year + '">');
	$(hvLegend).append(inputYear);
	
	//Add the trigger to change to the next month.
	var next = $('<div id="next">');
	$(hvHeader).append(next);
	
	//Add the head div.
	var hvHead = $('<div class="hv-head">');
	$(calendarContainer).append(hvHead);
	
	//Loop and add the names of the days.
	for(var i = 0; i < 7; i++) {
		$(hvHead).append('<div>' + g.hvEvents.constants.DAYS_LABELS[i] + '</div>');
	}
	
	//Add the body (which will contains all the days) div.
	var hvBody = $('<div class="hv-body clearfix">');
	$(calendarContainer).append(hvBody);
	
	//Day variable.
	var day = 1;
	
	//Counter variable.
	var c = 0;
	
	//While-loop for weeks (rows).
	while(true) {
		//Add the row div.
		var hvRow = $('<div class="hv-row clearfix">');
		$(hvBody).append(hvRow);
		
		//A for-loop for weekdays.
		for (var i = 0; i < 7; i++) {
			var css = (Date.compare(new Date(this.year, this.month, day), Date.today()) === 0) ? 'today' : '';
			var dayDiv = $('<div class="' + css + '">');
			$(hvRow).append(dayDiv);
			
			if(day <= monthLength && (c > 0 || i >= startingDay)) {
				//Year.
				y = this.year;
				
				//Month.
				m = this.month+1; m=(m < 10) ? '0' + m : m;
				
				//Day.
				d = (day < 10) ? '0' + day : day;
				
				$(dayDiv).append('<span class="hv-date" data-date="' + y + '-' + m + '-' + d + '">' + day + '</span>');
				day++;
			}
		}
		
		//If we've run of out days then stop making rows.
		if(day > monthLength) {
			break;
		}
		
		c++;
	}
	
	/*
	 * Event binds.
	 *
	 */
	//Function that change month. Used in the previous and next triggers.
	function change_month(n) {
		var mn = parseInt(Date.getMonthNumberFromName($('span.month', container).text()), 10); //Get the current month number.
		var yn = parseInt($('input.year', container).val(), 10);
		
		//Create a new Calendar object.
		var cal = new g.hvEvents.CALENDAR(mn, yn);
		
		//Add one month.
		cal.setMonth(n);
		
		//Regenerate the markup.
		cal.generateMarkup(container, events);
		
		//Remove the section.
		$('section#calendar', container).remove();
		
		//Append a new one.
		$(container).append('<section id="calendar">');
		
		//Append the calendar.
		$('section#calendar', container).append(cal.jQueryObj);
		
		//Add the events.
		cal.addEvents(events.events);
	}
	
	//Function to change the year.
	function change_year(n) {
		//If the input isn't a valid number, return.
		if(isNaN(n) || !Date.validateYear(parseInt(n, 10))) return false;
		
		//Create a new Calendar object.
		var cal = new g.hvEvents.CALENDAR(0, n);
		
		//Generate the markup.
		cal.generateMarkup(container, events);
		
		//Remove the section.
		$('section#calendar', container).remove();
		
		//Append a new one.
		$(container).append('<section id="calendar">');
		
		//Append the calendar.
		$('section#calendar', container).append(cal.jQueryObj);
		
		//Add the events.
		cal.addEvents(events.events);
	}
	
	//Next month.
	$(next).on('click', function() {
		change_month(1);
	});
	
	//Previous month.
	$(previous).on('click', function() {
		change_month(-1);
	});
	
	//Change the year more easily.
	$(inputYear).on('blur', function() {
		//If the value isn't a number or it isn't in the valid range then revert.
		if(isNaN($(this).val()) || !Date.validateYear(parseInt($(this).val(), 10))) {
			$(this).val(that.year);
		}
		
		change_year($(this).val());
	});
	
	//Also change on enter.
	$(inputYear).on('keypress', function(e) {
		//If the key is enter.
		if(e.which == 13) {
			//If the value isn't a number or it isn't in the valid range then revert.
			if(isNaN($(this).val()) || !Date.validateYear(parseInt($(this).val(), 10))) {
				$(this).val(that.year);
			}
			
			change_year($(this).val());
		}
	});
	
	//Return the jQuery object.
	this.jQueryObj = $(calendarContainer);
}

g.hvEvents.CALENDAR.prototype.addEvents = function(events) {
	$.each(events, function(i, ev) {
		//Try and match the event to a date in the calendar.
		var dateSpan = $('span.hv-date[data-date="'+ev.date.start.ISO+'"]');
		
		//If one is found...
		if(dateSpan.length !== 0) {
			//Create a div which will show the event title in the calendar.
			var t = $('<a href="' + ev.permalink + '" title="' + ev.description + '" class="event">' + ev.title + '</a>');
			
			//Append it.
			$(dateSpan).parent().append(t);
		}
	});
}

g.hvEvents.CALENDAR.prototype.getMonth = function() {
	return this.month;
}

g.hvEvents.CALENDAR.prototype.setMonth = function(n) {
	if(this.month + n > 11) {
		this.month = 0;
		this.year = this.year + 1;
	}
	
	else if(this.month + n < 0) {
		this.month = 11;
		this.year = this.year -1;
	}
	
	else {
		var date = new Date(this.year, this.month).addMonths(n);
		this.month = date.getMonth();
	}
}

g.hvEvents.CALENDAR.prototype.getYear = function() {
	return this.year;
}

g.hvEvents.render.CALENDAR = function(events, container) {
	//Remove the previous view.
	$('section', container).remove();
	
	//If the cookie isn't set to always show calendar, then show the save option.
	if(g.hvEvents.cookies.read('hv_events_view') !== 'calendar')
	{
		$('div#save-view', container).show();
	}
	
	//If it is, then hide it.
	else {
		$('div#save-view', container).hide();
	}
	
	//Remove the active class from the last view used.
	$('div#view-changer div', container).removeClass('active');
	
	//Add the active class to the current view.
	$('div#calendar', container).addClass('active');
	
	//Create a new Calendar object.
	var calendar = new g.hvEvents.CALENDAR();
	
	//Generate the markup.
	calendar.generateMarkup(container, events);
	
	//Append a new section.
	$(container).append('<section id="calendar">');
	
	//Append the calendar.
	$('section#calendar', container).append(calendar.jQueryObj);
	
	//Add the events.
	calendar.addEvents(events.events);
}

g.hvEvents.render.ROWS = function(events, container) {
	//Remove the previous view.
	$('section', container).remove();
	
	//If the cookie isn't set to always show rows, then show the save option.
	if(g.hvEvents.cookies.read('hv_events_view') !== 'rows')
	{
		$('div#save-view', container).show();
	}
	
	//If it is, then hide it.
	else {
		$('div#save-view', container).hide();
	}
	
	//Remove the active class from the previously used view.
	$('div#view-changer div', container).removeClass('active');	
	
	//Add the active class to the current view.
	$('div#rows', container).addClass('active');
	
	//Append a new section.
	$(container).append('<section id="event-rows">');
	
	//Append the legend and the events container to the section.
	$('section#event-rows', container)
		.append('<div class="legend">')
		.append('<div class="events">');
	
	///Append the upcoming and past triggers to the legend.	
	$('div.legend', container)
		.append('<div class="upcoming"><div class="legend-box"></div>= Kommande ↓ <span>(visa/dölja)</span></div>')
		.append('<div class="past"><div class="legend-box"></div>= Förflutna ↓ <span>(visa/dölja)</span></div>');
	
	//This below takes an event, creates and appends markup.
	function render_event(e) {
		//var c is the css class.
		var c = (e.ispast) ? 'row past border-box' : 'row upcoming border-box';
		
		//Add the permalink to the a (which is the event).
		var a = $('<a class="' + c + '" href="' + e.permalink + '">');
		
		//Some appends.
		$(a).append('<div class="left">');
		$(a).append('<div class="right">');
		$('div.left', a).append('<div class="title border-box">' + e.title + '</div>');
		$('div.left', a).append('<div class="venue border-box">' + e.venue + '</div>');
		$('div.left', a).append('<div class="date border-box">');
		$('div.right', a).append('<div class="description border-box">' + e.description + '</div>');
		$(a).append('<div class="clear">');
		
		$('div.date', a)
			.append('<span class="from"><strong>Från:</strong>&nbsp;&nbsp;' + e.date.start.formatted + '</span>')
			.append('<span class="to"><strong>Till:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + e.date.end.formatted + '</span>');
		
		//Add the event.	
		$('div.events', container).append(a);
	}
	
	//If the event object has some upcoming events.
	if(events.hasOwnProperty('upcoming') && events.upcoming.length > 0) {
		var i = 0;
		$.each(events.upcoming, function(index, value) {
			//Make sure we stick within the acceptable limit of events rendered.
			if(i >= g.hvEvents.constants.MAX_NUMBER_NEW_EVENTS) return false;
			
			value.ispast = false;
			//Render them.
			render_event(value);
			
			//Add to the counter.
			i = i + 1;
		});
	}
	
	//If the event object has some past events.
	if(events.hasOwnProperty('past') && events.past.length > 0) {
		var i = 0;
		$.each(events.past, function(index, value) {
			//Make sure we stick within the acceptable limit of events rendered.
			if(i >= g.hvEvents.constants.MAX_NUMBER_OLD_EVENTS) return false;
			
			value.ispast = true;
			//Render them.
			render_event(value);
			
			//Add to the counter.
			i = i + 1;
		});
	}
	
	//When you click the upcoming div in the legend either show or hide the upcoming events.
	$('div.legend .upcoming', container).on('click', function() {
		$('a.upcoming', container).slideToggle();
	});
	
	//When you click the past div in the legend either show or hide the past events.
	$('div.legend .past', container).on('click', function() {
		$('a.past', container).slideToggle();
	});	
}

g.hvEvents.render.TILES = function(events, container) {
	//Remove the previous view.
	$('section', container).remove();
	
	//If the cookie is set to show tiles, then hide the save option.
	if(g.hvEvents.cookies.read('hv_events_view') !== 'tiles')
	{
		$('div#save-view', container).show();
	}
	
	//If it isn't, then show it.
	else {
		$('div#save-view', container).hide();
	}
	
	//Remove the active class from the previous view.
	$('div#view-changer div', container).removeClass('active');
	
	//Add the active class to the current view.
	$('div#tiles', container).addClass('active');
	
	//Add a new section.
	$(container).append('<section id="tiles">');
	
	//If the events object has some upcoming events.
	if(events.hasOwnProperty('upcoming') && events.upcoming.length > 0) {
		var i = 0;
		
		//Append an upcoming events container.
		$('section#tiles', container).append('<div class="upcoming clearfix">');
		
		//Add a title and a hide option.
		$('div.upcoming', container)
			.append('<header class="events-title"><h2>Kommande</h2></header>')
			.append('<div id="upcoming-click" class="collapse-trigger">Dölj &darr;</div>')
			.append('<div class="clear"></div>')
			.append('<div class="events clearfix">');
		
		//Loop through the events and render them.
		$.each(events.upcoming, function(index, value) {
			//Make sure we stick within the acceptable limit of events rendered.
			if(i >= g.hvEvents.constants.MAX_NUMBER_NEW_EVENTS) return false;
			
			var a = $('<a class="tile" href="' + value.permalink + '">');
			
			$(a).append('<div class="title border-box">' + value.title + '</div>');
			$(a).append('<div class="date">');
			
			$('div.date', a)
				.append('<span class="day">' + value.date.start.day + '</span>')
				.append('<span class="month">' + value.date.start.month + '</span>')
				.append('<span class="year">' + value.date.start.year + '</span>');
				
			$('div.upcoming .events', container).append(a);
			
			//Add to the counter.
			i = i + 1;
		});
	}
	
	//If the events object has some past events.
	if(events.hasOwnProperty('past') && events.past.length > 0) {
		var i = 0;
		
		//Append an upcoming events container.
		$('section#tiles', container).append('<div class="past clearfix">');
		
		//Add a title and a hide option.
		$('div.past', container)
			.append('<header class="events-title"><h2>Gångna</h2></header>')
			.append('<div id="past-click" class="collapse-trigger">Dölj &darr;</div>')
			.append('<div class="clear"></div>')
			.append('<div class="events clearfix">');
		
		//Loop through the events and render them.
		$.each(events.past, function(index, value) {
			//Make sure we stick within the acceptable limit of events rendered.
			if(i >= g.hvEvents.constants.MAX_NUMBER_OLD_EVENTS) return false;
			
			var a = $('<a class="tile" href="' + value.permalink + '">');
			
			$(a).append('<div class="title border-box">' + value.title + '</div>');
			$(a).append('<div class="date">');
			
			$('div.date', a)
				.append('<span class="day">' + value.date.start.day + '</span>')
				.append('<span class="month">' + value.date.start.month + '</span>')
				.append('<span class="year">' + value.date.start.year + '</span>');
				
			$('div.past .events', container).append(a);
			
			//Add to the counter.
			i = i + 1;
		});
	}
	
	//Bind events to the hide triggers.
	$('div.collapse-trigger').each(function(i, e) {
		var that = this;
		$(this).on('click', function() {
			$('div.events', this.parentNode).slideToggle('slow', function() {
				if($('div.events', this.parentNode).is(':visible')) {
					$(that).text('Dölj ↓');
				}
				
				else {
					$(that).text('Visa ↓');
				}
			});
		});
	});
	
}

g.hvEvents.cookies.create = function(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	
	else {
		var expires = "";
	}
	
	document.cookie = name+"="+value+expires+"; path=/";
	return value;
}

g.hvEvents.cookies.read = function(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		
		while (c.charAt(0)==' ') {
			c = c.substring(1,c.length);
		}
		
		if (c.indexOf(nameEQ) == 0) {
			return c.substring(nameEQ.length,c.length);
		}
	}
	
	return null;
}

g.hvEvents.cookies.remove = function(name) {
	g.hvEvents.cookies.create(name, '', -1);
}