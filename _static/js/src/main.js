// ## functions ##############################


function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateContactForm(){    
    var _form = $("#contact-form");

    var _inputName = $("#input-name");
    var _inputCompany = $("#input-company");
    var _inputEmail = $("#input-email");
    var _inputMessage = $("#input-message");
    var _inputBlocker = $("#input-blocker");

    var _errorBlock = $("#error-message");
    
    //hide any errors
    _errorBlock.hide();

    if(_inputName.val() === "") {
        _inputName.focus();
        _errorBlock.html("<h3>Please enter your name.</h3>").fadeIn();
        return false;
    }

    if(_inputCompany.val() === "") {
        _inputCompany.focus();
        _errorBlock.html("<h3>Please enter your company.</h3>").fadeIn();
        return false;
    }

    if(_inputEmail.val() === "") {
        _inputEmail.focus();
        _errorBlock.html("<h3>Please enter your email.</h3>").fadeIn();
        return false;
    }

    if(!validateEmail(_inputEmail.val())) {
        _inputEmail.focus();
        _errorBlock.html("<h3>Please enter a valid email.</h3>").fadeIn();
        return false;
    }

    //all good! send the email
    var dataString = 'name=' + _inputName.val() + '&company=' + _inputCompany.val() + '&email=' + _inputEmail.val() + '&blocker=' + _inputBlocker.val() + '&message=' + _inputMessage.val();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: dataString

        })
          .done(function() {//once the page is loaded
            //alert("sent");
            _form.slideUp().fadeOut();
            _errorBlock.slideUp().fadeOut();

            $("#confirm-message").css("display","none").html("<p>Thanks! We will be in touch soon.</p>").fadeIn();
          })
            .fail(function() {
                //alert("error");
            });

    return false;
}

function initContactForm() {
    $("#btn-submit").click(function(e){
        e.preventDefault();
        validateContactForm();       
    });
    
    //fade the labels
    var _form = $("#contact-form");
    _form.find("input[type='text'],input[type='email'], textarea").focus(function(){
        var _this = $(this);
        _this.prev("label").fadeOut(150);
    });
    
    _form.find("input[type='text'],input[type='email'], textarea").blur(function(){
        var _this = $(this);
        if(_this.val() === ""){
            _this.prev("label").fadeIn(150);
        }
    });
    
}

var _globalSpeed = null;

function initParallax() {
    //duplicate and place an image tag
    var _targetContainer = $(".parallax"); 
    var _bgImg = _targetContainer.css("background-image");
    //var _bgURL = _bgImg.substring(_bgImg.indexOf("(")+1,_bgImg.lastIndexOf(")"));
    
    var _parallaxImg = "<div class='parallax-image-container'></div>";
    
    _targetContainer.append(_parallaxImg);
    
    function setParallaxSize(){
        //var _headerOffset = $("header").css("position") === "relative" ? $("header").outerHeight() : 0;
        var _headerOffset = 0;
        
        $(".parallax-image-container").css({
            "width" : _targetContainer.outerWidth(),
            "height" : _targetContainer.outerHeight() + _headerOffset,
            "backgroundImage" : _bgImg
        });
        
        $(".parallax-image-container").css("top",function(){
            var _headerOffset = 0;//$("header").css("position") === "relative" ? $("header").outerHeight() : 0;
            var _offset = $(this).offset();
            var _top = _offset.top;
            var _style = _top + _headerOffset;

            return _style;
        });
    }
    
    setParallaxSize();
    _targetContainer.removeAttr("style");//remove the original
    _targetContainer.css("background","none");
    
    //bind to scroll
    //var _speed = 0.5;
    var _speed = _globalSpeed!==null ? _globalSpeed : 0.5;
    
    function handleScroll(){   
        var _headerOffset = 0;//$("header").css("position") === "relative" ? $("header").outerHeight() : 0;
        
        $(".parallax-image-container").css("top", function(){            
            //var _newPos = "translateY(" + (-($(window).scrollTop())*_speed) + _headerOffset + "px)";
            var _newPos = (-($(window).scrollTop())*_speed) + _headerOffset;
            return _newPos;
        });
    }
    
    
    
    $(window).scroll( handleScroll );
    $(window).resize( setParallaxSize );
    
}

$("document").ready(function(){

    //JS here
    initContactForm();
    initParallax();
    
});