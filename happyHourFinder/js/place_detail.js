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
        var html = '<h3>'+place.formatted_address+'</h3>';
        html+='<h4> Phone #:'+place.formatted_phone_number+'</h4>';
        
        var review = "";
        for(var i=0;i<place.reviews.length;++i){
            var date = new Date(place.reviews[i].time*1000);
            review += '<div class="panel panel-info">';
            review += '<div class="panel-heading text-center">';
            
            review += '<h3>'+place.reviews[i].author_name+' <h5> '+date+' </h5></h3>';
            review += '</div>';
            
            review += '<div class="panel-body text-center">';
            
            var rating = padHTML('<img src="img/star.png" style="width:36px;height:36px;"></img>',place.reviews[i].rating);
            review += rating + '</h5>';
            
            review += '<p><i class="fa fa-quote-left fa-3x"></i> '
                + place.reviews[i].text
                + ' <i class="fa fa-quote-right fa-3x"></i></p>';
            
            review += '</div></div>';
        }
        
        $('#result').html(html);
        
        $('.comment').html(review);
        
        var img ="";
        for (var i=0;i<place.photos.length;++i){
            var url = place.photos[i].getUrl({'maxWidth': 555, 'maxHeight': 555});
            if (i==0)
                img += '<div class="item active">';
            else
                img += '<div class="item">';
            img += '<img class="img-responsive center-block" src="'+url+'">';
            img += '</div>';
        }
        
        $('.carousel-inner').html(img);
    }
