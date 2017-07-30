console.log('Start running 2moons tests');

var page = require('webpage').create();
var prefix = 'http://localhost:8000';


page.open(prefix, function(status) {
    console.log(status);
});