function padHTML(string, length){
    var result = '';
    for(var i=0;i<length;++i){ 
        result+=string;
    }
    return result;
};

function sortByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key];
        var y = b[key];
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });
};

/*
  This function below converts latitude and longitude to miles
  This function is borrowed from StackOverflow forum
  url: http://stackoverflow.com/questions/29001716/compute-latitude-and-longitude-to-kilometer
  Author: See Yah Later(original), Ray Suelzer(improvement)
*/

function toMiles(lat1, lon1, lat2, lon2){ 
    var R = 6378.137; 
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
    Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;
    return d*0.621371; 
};
