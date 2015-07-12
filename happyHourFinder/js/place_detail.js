var id = $('#id').val();

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
    var contact = '<h3>'+place.formatted_address+'</h3>';
    contact += '<h4> Phone #:'+place.formatted_phone_number+'</h4>';
    $('#contact_info').html(contact);

    var review = "";
    if(place.reviews){
        for(var i in place.reviews){
            var date = new Date(place.reviews[i].time*1000);
            review += '<div class="panel panel-default">';
            review += '<div class="panel-heading text-center">';

            review += '<h4>'+place.reviews[i].author_name+' <h5> '+date+' </h5></h4>';
            review += '</div>';

            review += '<div class="panel-body text-center">';

            var rating = padHTML('<img src="img/star.png" style="width:36px;height:36px;"></img>', place.reviews[i].rating);
            review += rating + '</h5>';

            review += '<p>' + place.reviews[i].text + '</p>';
            review += '</div></div>';
        }
    }else{
        review += '<p>Sorry, comments are not available. </p>';
    }
    $('#comment').html(review);
    
    var hours = "";
    if(place.opening_hours){
        for(var i in place.opening_hours.weekday_text){
            hours += '<h5>'+place.opening_hours.weekday_text[i]+'</h5>';
        }
    }else{
        hours += '<h5>Sorry, opening hours are not available. </h5>';
    }
    $("#opening_hours").html(hours);
    
    

    var img = "";
    if(place.photos){
        for (var i in place.photos){
            var url = place.photos[i].getUrl({'maxWidth': 555, 'maxHeight': 555});
            if (i==0)
                img += '<div class="item active">';
            else
                img += '<div class="item">';
            img += '<img class="img-responsive center-block" src="'+url+'">';
            img += '</div>';
        }
    }else{
        img += '<div class="item active"><img class="img-responsive center-block" src="img/nopics.jpg"></div>';
    }

    $('.carousel-inner').html(img);
}
