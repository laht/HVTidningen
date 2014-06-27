var map = {
	map: null,
	infoWindow: null,
	myLatlng: null,

	createMap: function() {
		var that = this;
		that.myLatlng = new google.maps.LatLng(63,16);
		var mapOptions = {
			zoom: 4,
			center: that.myLatlng
		}
		that.map = new google.maps.Map($("#map-canvas")[0], mapOptions);
	},

	setMarker: function(lat, lng, region) {
		var that = this;
		var latLng = new google.maps.LatLng(lat, lng);		

		var marker = new google.maps.Marker({
			position: latLng,
			map: that.map,
			title: region.bat
		});

		var content = getContent(region);

		var myOptions = {
			content: content
		}

		if (that.infoWindow == null) {
			this.infoWindow = new google.maps.InfoWindow();	
		}

		google.maps.event.addListener(marker, 'click', function() {			
			that.infoWindow.setOptions(myOptions);
			that.infoWindow.open(this.map, marker);
		});	
	}
}

var maps = Object.create(map);
maps.createMap();

jQuery(document).ready(function($) {
	$.post('http://tidningenhemvarnet.se/wp-admin/admin-ajax.php', {
		action: 'getPosts'
	}, function(data) {
		var posts = jQuery.parseJSON(data);
		processPosts(posts);
	});
	return false;
});

function getContent(group) {
	var content = "<div id='infoWindow'><h3>"+group.bat+"</h3>";
	content += "<a href="+group.url+">Hemsida</a></br>";
	for (var i = 0; i < group.posts.length; i++) {
		content += "<a href='"+group.posts[i].m_guid+"'>"+group.posts[i].m_title+"</a></br>";
	}
	content += "</div>";
	return content;
}

function processPosts(posts) {	
	var rp = getRegionPosts(posts);	

	if (getLocs() != null) {
		var locs = JSON.parse(getLocs());
		renderMarks(locs, rp);
		return;
	}

	$.post('http://tidningenhemvarnet.se/wp-admin/admin-ajax.php', {
		action: 'getLocs'
	}, function(data) {
		var parsedLocs = JSON.parse(data);
		var locs = [];
		for (var i = 0; i < parsedLocs.length; i++) {
			var lat = parsedLocs[i].lat;
			var lng = parsedLocs[i].lng;
			locs.push( { "lat" : lat, "lng" : lng } );
			if (locs.length == rp.regions.length) {
				saveLocs(locs);
				renderMarks(locs, rp);
			}
		}
	});	
}

function renderMarks(locs, posts) {
	for (var i = 0; i < locs.length; i++) {
		maps.setMarker(locs[i].lat, locs[i].lng, posts.regions[i]);
	}	
}

function getRegionPosts(posts) {
	var regionPosts = { "regions" : [   { "name" : "Kiruna", "bat" : "Lapplandsjägargruppen", "url" : "http://ug66.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Boden", "bat" : "Norrbottensgruppen", "url" : "http://ug63.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Umeå", "bat" : "Västerbottensgruppen", "url" : "http://ug61.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Östersund", "bat" : "Fältjägargruppen", "url" : "http://ug22.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Härnösand", "bat" : "Västernorrlandsgruppen", "url" : "http://ug23.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Gävle", "bat" : "Gävleborgsgruppen", "url" : "http://gabg.hemvarnet.se/", "posts" : [] },
										{ "name" : "Falun", "bat" : "Dalregementsgruppen", "url" : "http://drg.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Enköping", "bat" : "Upplands-och-Västmanlandsgruppen", "url" : "http://uvg.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Strängnäs", "bat" : "Södermanlandsgruppen", "url" : "http://slg.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Stockholm", "bat" : "Livgardesgruppen", "url" : "http://lgag.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Örebro", "bat" : "Örebro-och-Värmlandsgruppen", "url" : "http://ovg.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Malmslätt", "bat" : "Livgrenadjärgruppen", "url" : "http://lgrg.hemvarnet.se/", "posts" : [] },
										{ "name" : "Skövde", "bat" : "Skaraborgsgruppen", "url" : "http://skg.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Skredsvik", "bat" : "Bohusdalgruppen", "url" : "http://bdg.hemvarnet.se/", "posts" : [] },								
										{ "name" : "Göteborg", "bat" : "Elfsborgsgruppen", "url" : "http://ebg.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Eksjö", "bat" : "Norra Smålandsgruppen", "url" : "http://nsg.hemvarnet.se/", "posts" : [] },										
										{ "name" : "Visby", "bat" : "Gotlandsgruppen", "url" : "http://glg.hemvarnet.se/", "posts" : [] },										
										{ "name" : "Berga", "bat" : "Södertörnsgruppen", "url" : "http://sdtg.hemvarnet.se/", "posts" : [] },
										{ "name" : "Växjö", "bat" : "Kalmar-och-Kronobergsgruppen", "url" : "http://krag.hemvarnet.se/", "posts" : [] },
										{ "name" : "Halmstad", "bat" : "Hallandsgruppen", "url" : "http://hag.hemvarnet.se/", "posts" : [] },
										{ "name" : "Karlskrona", "bat" : "Blekingegruppen", "url" : "http://blg.hemvarnet.se/", "posts" : [] }, 
										{ "name" : "Revingehed", "bat" : "Skånska gruppen", "url" : "http://ssk.hemvarnet.se/", "posts" : [] }]};

	for (var i = 0; i < posts.length; i++) {
    	for (var s = 0; s < posts[i].m_tags.length; s++) {
    		for (var e = 0; e < regionPosts.regions.length; e++) {
    			if (posts[i].m_tags[s] == regionPosts.regions[e].bat) {
    				regionPosts.regions[e].posts.push(posts[i]);
    			}
    		}
    	}
    }

	return regionPosts;
}

function saveLocs(locs) {
	localStorage.setItem("locs", JSON.stringify(locs));
}

function getLocs() {
	return localStorage.getItem("locs");
}
