/*var desc = document.getElementById('desc');
var myplace = document.getElementById('myPlace');*/
var latitude;
var longitude;
var resultArr = [];
var pageNum = 0;
var maxPage = 0;

$result =  $("#result");

function success(pos){
    var crd = pos.coords;
    latitude =  crd.latitude;
    longitude =  crd.longitude;
   /* 
    desc.innerHTML = "Your latitude is " + latitude + "<br/> Your longitude is " + longitude;
    var img = '<img src="https://maps.googleapis.com/maps/api/staticmap?center=' + latitude + "," +                    longitude + '&zoom=13&size=300x300&sensor=false">';
    myplace.innerHTML = img;
    */
}

function error(err) {
    console.warn('ERROR(' + err.code + '): ' + err.message);
    desc.innerHTML = err.message;
}

if (navigator.geolocation){
    navigator.geolocation.getCurrentPosition(success, error);
}else{
     $result.html("<p>Your browser doesn't support GeoLocation</p>");
}

$('#searchForm').on('submit',function(e){
    e.preventDefault();
    
    var y = $(window).scrollTop(); 
    
    $("html, body").animate({ scrollTop: y + $(window).height() }, 800);
    
    $result.html("<p>searching</p>");
    
    var type = $('#places').val();

    var loc = new google.maps.LatLng(latitude,longitude);
    
    //request object
    var request = {
        location: loc,
        radius: '16300',//for now
        types: [type]
      };

    service = new google.maps.places.PlacesService(document.createElement('div'));
    service.nearbySearch(request, callback);

    function callback(results, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
          $('.pager').show();
          resultArr=results;
          maxPage=resultArr.length/5;
          render(0,5);
      }    
    } 
});

$(".next").on('click',function(e){
    e.preventDefault();
    if(pageNum<maxPage-1){
        pageNum++;
        render(pageNum*5,pageNum*5+5);
    }
});
$(".previous").on('click',function(e){
    e.preventDefault();
    if(pageNum>0){
        pageNum--;
        render(pageNum*5,pageNum*5+5);
    }
});

function render(lower,upper){
    var html="";
    for (var i = lower; i < upper; i++) {
      var place = resultArr[i];
      html += '<div class="each_entry">';
      html += '<a href="place.php?name='+place.name+'&id='+place.place_id+'"><h1>' + place.name + '</h1></a>';
      html += '<a href="place.php?name='+place.name+'&id='+place.place_id+'"><img src="'+place.icon+'"></img></a>';
      html += '<h4>' + "Rating: " + place.rating + '</h4>';
      html += '<h4>' + place.vicinity + '</h4><hr>'; 
      html += '</div>';
    
    }
  $result.html(html);
}

