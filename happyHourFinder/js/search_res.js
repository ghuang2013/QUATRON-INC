var mainPage = (function(){
    //private attributes
    
    function Position(latitude, longitude){
        this.latitude = latitude;
        this.longitude = longitude;
    };
    
    var pageNum = 0;
    var arr = new Array();
    var type = "";
    $result =  $("#result");
    $searchForm = $('form[id=genericSearchForm]');
    $advancedForm = $('form[id=advancedSearchForm]');
    $next = $(".next");
    $previous = $(".previous");
    var myPosition;
    var Position;
    
    var event = function(){
        $searchForm.on('submit', generalSearch);
        $advancedForm.on('submit', advancedSearch);
        $next.on('click', nextPage);
        $previous.on('click',previousPage);
        $result.on('submit', 'form[id=distance]', calcDist);
    };
    
    var advancedSearch = function(e){
        /*
            This function decodes the address
            you entered into latitude and longitude 
        */
        e.preventDefault();
        
        pageNum = 0;
        
        var zipcode = $('#zip-code').val();
        
        var geocoder = new google.maps.Geocoder();
        
        geocoder.geocode( { 'address': zipcode}, function(results, status) {
            position = new Position(results[0].geometry.location.A,results[0].geometry.location.F);
            /* 
            position.latitude = results[0].geometry.location.A;
            position.longitude = results[0].geometry.location.F;
            */
            
            type = $('#advancedSearchForm .places').val();
            searchImplement(type, pageNum, position);
        });    
    };
    
    var generalSearch = function(e){
        /*
            This function detects your current position
        */
        
        e.preventDefault();

        pageNum = 0; 
        
        if (myPosition==undefined){             

            detectMyLocation(function(){
                type = $('#genericSearchForm .places').val();
                searchImplement(type, pageNum, myPosition);
            });
 
        }
        else{
            type = $('#genericSearchForm .places').val();
            searchImplement(type, pageNum, myPosition);
        }
    };
    
    var detectMyLocation = function(lambda){
        
        function success(pos){
            var crd = pos.coords;

            myPosition = new Position(crd.latitude, crd.longitude);

            lambda();
        }

        function error(err) {
            alert(err.message+" and please try again later!");
        }

        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(success, error);
        }else{
            alert("Your browser doesn't support GeoLocation!");
        }  

    };
    
    var searchImplement = function(type, pageNum, position){
        
        var y = $(window).scrollTop();   
        $("html, body").animate({ scrollTop: y + $(window).height() }, 1000);
        
        $result.html('<img class="img-responsive center-block" style="width:200px;height:200px;" src="img/spinner.gif"></img>');
            
        var loc = new google.maps.LatLng(position.latitude, position.longitude);
        service = new google.maps.places.PlacesService(document.createElement('div'));

        var request = {
            location: loc,
            radius: 9000,
            types: [type]      
          };

        function callback(results, status) {
            arr = results;
      
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                $result.empty();
                if(myPosition){
                    for(var i in results){
                        var distance = toMiles(
                            myPosition.latitude,
                           myPosition.longitude,
                           results[i].geometry.location.A,
                           results[i].geometry.location.F
                        );
                           arr[i]['dist'] = distance;
                    }
                }
                arr = sortByKey(arr,'dist');
                render(arr, pageNum);
            } 
        }
        service.radarSearch(request, callback);
    };

    var render = function(results, pageNum){
        $('.pager').show();
        $('.pageNum').html('<h3> Page '+ pageNum + '</h3>');
        var mileCounter = 0;
        for(var i=pageNum*5; i<5*(pageNum+1); ++i){
              service = new google.maps.places.PlacesService(document.createElement('div'));
                
                 function callback(result, status){
                      var html = '<div class="each_entry row">';
                      html += '<div class="col-md-8">';
                      html += '<a href="place.php?name='+result.name+'&id='+result.place_id+'"><h1>' 
                                + result.name + '</h1></a>';
                      html += '<a href="place.php?name='+result.name+'&id=' 
                                + result.place_id+'"><img src="'+result.icon+'"></img></a>';

                      var rating = padHTML('<img src="img/star.png" style="width:48px;height:48px;"></img>', result.rating);
                      html += '<h4>'  + rating + '</h4>';

                      var price = padHTML('<i class="fa fa-usd fa-2x fa-spin"></i>', result.price_level);
                      html += '<h4>' + "Price level: " + price + '</h4>';

                      html += '<h4>' + result.formatted_address + '</h4>'; 
                      html += '</div><div class="col-md-4">';

                      html += (typeof result.opening_hours != 'undefined' && 
                               result.opening_hours.open_now === true)? 
                          '<h4>Open now: <i class="fa fa-check fa-3x"></i></h4>':
                            '<h4>Open Now: <i class="fa fa-times fa-3x"></i></h4>';

                      html += '<form id="distance"><input id="lat" type="hidden" value="'+result.geometry.location.A+'">';
                      html += '<input id="long" type="hidden" value="'+result.geometry.location.F+'">';
                      html += '<input type="submit" class="btn btn-success" value="Get Distance"></form></div></div>';

                      $result.append(html);
                 }
              if (results[i].place_id){
                     service.getDetails({placeId: results[i].place_id}, callback);
              }
        }
    };
    
    var toMiles = function(lat1, lon1, lat2, lon2){ 
        var R = 6378.137; 
        var dLat = (lat2 - lat1) * Math.PI / 180;
        var dLon = (lon2 - lon1) * Math.PI / 180;
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        return d*0.621371; 
    };
    
    var calcDist = function(e){
        e.preventDefault();
        var lat = $(this).find('input[id=lat]').val();
        var lng = $(this).find('input[id=long]').val();
        if(!myPosition){
            detectMyLocation(function(){
                /*empty on purpose*/
            });
        }
        var distance = toMiles(lat, lng, myPosition.latitude, myPosition.longitude).toPrecision(4);
        $(this).fadeOut("slow", function(){
            $(this).replaceWith("<h4>"+distance+" Miles from your home</h4>");
            $(this).fadeIn("slow");
        });
    };
    
    var nextPage = function(e){
        if (pageNum<20){
            $result.empty();
            pageNum++;
            render(arr,pageNum);
        }
    };

    var previousPage = function(e){
        if (pageNum!=0){
            $result.empty();
            pageNum--;
            render(arr,pageNum);
        }
    };

    return{       
        event:event
    };
})();
    
mainPage.event();