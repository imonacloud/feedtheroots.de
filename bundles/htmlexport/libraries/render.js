var page = require('webpage').create(),
    system = require('system'),
    address, output, format, ortientation, zoom;

function printArgs() {
    var i, ilen;
    for (i = 0, ilen = arguments.length; i < ilen; ++i) {
        console.log("    arguments[" + i + "] = " + arguments[i]);
    }
    console.log("");
} 

/*
 *  Tracking Events.....
 */ 
page.onInitialized = function() {
    console.log("Initializing...");
};
page.onLoadStarted = function() {
    console.log("Loading...");
};
page.onLoadFinished = function(status) {
    console.log("Load Finished!");
};

page.onNavigationRequested = function(url, type, willNavigate, main) {
    console.log('Navigation Request');
}
/*
 * Tracking any error
 */ 
page.onError = function(msg, trace) {
    console.error(msg);
};

/*
 * Check Arguments.
 */ 
if (system.args.length != 6) {
    console.log('Usage: render.js URL filename [paperformat] [orientation] [zoom]');
    phantom.exit(1);
} else {
    address = system.args[1];
    output = system.args[2];
    format = system.args[3];
    orientation = system.args[4];
    zoom = system.args[5];
    
    //page.viewportSize = { width: 600, height: 600 };
    
    if (output.substr(-4) === ".pdf") {
        page.paperSize = { format: format, orientation: orientation, margin: '1cm' };
    }
    
    page.zoomFactor = zoom;
    
    page.open(address, function (status) {
        if (status !== 'success') {
            console.error('Unable to load the address!.. Status: ' + status);
            phantom.exit();
        } else {
            window.setTimeout(function () {
                page.render(output);
                phantom.exit();
            }, 200);
        }
    });
}
