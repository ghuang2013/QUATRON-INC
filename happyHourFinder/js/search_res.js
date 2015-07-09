
var position={
    latitude:0,
    longitude:0
}

var mainPage = (function(){
    //private attributes
    var pageNum = 0;
    var arr = [];
    var type = "";
    $result =  $("#result");
    $searchForm = $('#genericSearchForm');
    $advancedForm = $('#advancedSearchForm');
    $next = $(".next");
    $previous = $(".previous");
    
    var event = function(){
        $searchForm.on('submit', generalSearch);
        $advancedForm.on('submit', advancedSearch);
        $next.on('click', nextPage);
        $previous.on('click',previousPage);
    };
    
    var advancedSearch = function(e){
        /*
            This function decodes the address you entered into latitude and longitude 
        */
        e.preventDefault();
        
        pageNum = 0;
        
        var zipcode = $('#zip-code').val();
        var geocoder = new google.maps.Geocoder();
        
        geocoder.geocode( { 'address': zipcode}, function(results, status) {
            position.latitude = results[0].geometry.location.A;
            position.longitude = results[0].geometry.location.F;
            
            type = $('#advancedSearchForm .places').val();
            searchImplement(type);
        });    
    }
    
    var generalSearch = function(e){
        /*
            This function detects your current position
        */
        
        e.preventDefault();

        pageNum = 0;   
                    
        function success(pos){
            var crd = pos.coords;
            position.latitude =  crd.latitude;
            position.longitude =  crd.longitude;
            
            type = $('#genericSearchForm .places').val();
            searchImplement(type);
        }

        function error(err) {
            alert("<p>"+err.message+" Please try again later.</p>");
        }

        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(success, error);
        }else{
            alert("<p>Your browser doesn't support GeoLocation</p>");
        }   
    };
    
    var searchImplement = function(type){
        
        var y = $(window).scrollTop();   
        $("html, body").animate({ scrollTop: y + $(window).height() }, 1000);
        $result.html('<img class="img-responsive center-block" style="width:200px;height:200px;" src="img/spinner.gif"></img>');
        
        console.log(type); //for debugging
        
        var loc = new google.maps.LatLng(position.latitude, position.longitude);
        service = new google.maps.places.PlacesService(document.createElement('div'));

        var request = {
            location: loc,
            radius: '16300',
            types: [type],
            rankby: 'distance'
          };

        function callback(results, status) {
            arr = results;
            console.log(arr);
            if (status == google.maps.places.PlacesServiceStatus.OK) {
                $result.empty();
                render(arr,pageNum);
            } 
        }
        service.radarSearch(request, callback);
    }
    
    var render = function(results,pageNum){
        $('.pager').show();
        $('.pageNum').html('<h3> Page '+ pageNum + '</h3>');
        for(var i=pageNum*5; i<5*(pageNum+1); ++i){
              service = new google.maps.places.PlacesService(document.createElement('div'));
              service.getDetails({placeId: results[i].place_id},
              function(result, status){

                  //console.log(result);//used for debugging

                  var html = '<div class="each_entry">';
                  html += '<a href="place.php?name='+result.name+'&id='+result.place_id+'"><h1>' 
                            + result.name + '</h1></a>';
                  html += '<a href="place.php?name='+result.name+'&id=' 
                            + result.place_id+'"><img src="'+result.icon+'"></img></a>';

                  var rating = padHTML('<img src="img/star.png" style="width:48px;height:48px;"></img>',result.rating);
                  html += '<h4>'  + rating + '</h4>';

                  var price = padHTML('<i class="fa fa-usd fa-2x fa-spin"></i>', result.price_level);
                  html += '<h4>' + "Price level: " + price + '</h4>';

                  html += '<h4>' + result.vicinity + '</h4><hr>'; 
                  html += '</div>';

                  $result.append(html);
             });
        }
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