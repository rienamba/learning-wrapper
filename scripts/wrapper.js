
$(function() { 


/*script for tabs*/
$(function() {
    $(".LWtab li").click(function() {
        var num = $(".LWtab li").index(this);
        $(".content_wrap").addClass('disnon');
        $(".content_wrap").eq(num).removeClass('disnon');
        $(".LWtab li").removeClass('select');
        $(this).addClass('select')
    });
});

/*The following Javascript will only be enabled if the viewer is on Tablet,  Laptop or  Desktop*/  
var windowWidth = $(window).width();
if(windowWidth > 767){
/*Video& Menu will be on the sidebar when clicked*/
        $(".videoside").click(function(){
          
          $(".LWsidebar").css("width", "30%");
          $(".maincontent").css("width", "70%");
          location.href = '#';
        });

/*Video& Menu will not be on the side bar when clicked*/
 $(".videobig").click(function(){
          
          $(".LWsidebar").css("width", "100%");
          $(".maincontent").css("width", "100%");
    location.href = '#';
   
        });

}
});
