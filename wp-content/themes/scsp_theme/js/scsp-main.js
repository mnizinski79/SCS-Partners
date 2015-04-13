function addIconClass (){
    var _hook = $("#content-feeds");
    var _target = _hook.prev("div.secondary-content");
    
    _target.addClass("home-icons");
}

function adjustFooter () {
    if($("footer").css("zIndex") === "2"){
        $("footer").css({"width":"","zIndex":"1"});  
    } else {
        $("footer").css({"width":"auto","zIndex":"2"}); 
    }
}

$("document").ready(function(){
    addIconClass();
    adjustFooter();
    
    $(window).scroll(function(){
        adjustFooter();
    });
});