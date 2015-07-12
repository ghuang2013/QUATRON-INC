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
