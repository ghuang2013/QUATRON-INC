var id='';
$(document).ready(function(){
    id = $('#id').val();

    var request = {
      placeId: id
    };

    service = new google.maps.places.PlacesService(document.createElement('div'));
    service.getDetails(request, callback);

    function callback(place, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
            console.log(place);
            render(place);
      }
    }
    
    function render(place){
        var html = '<h3>'+place.formatted_address+'</h3>';
        html+='<h4> Phone #:'+place.formatted_phone_number+'</h4>';
        for(var i=0;i<place.reviews.length;++i){
            var date = new Date(place.reviews[i].time*1000);
            
            html += '<h3>'+place.reviews[i].author_name+' said <h5>at '+date+' </h5></h3>';
            html += '<h5>Rating: '+place.reviews[i].rating+'</h5>';
            html += '<p><blockquote>'+place.reviews[i].text+'</blockquote></p>';
        }
        $('#result').html(html);
    }
    
});