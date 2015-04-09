function addIconClass (){
    var _hook = $("#content-feeds");
    var _target = _hook.prev("div.secondary-content");
    
    _target.addClass("home-icons");
}

function adjustFooter () {
    $("footer").css("width","100%");   
}

$("document").ready(function(){
    addIconClass();
    adjustFooter();
});