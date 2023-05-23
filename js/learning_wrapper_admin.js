/*Script to make sure there's no conflict with Jquery*/
var $j = jQuery.noConflict();

/*script for tabs*/
$j(function() {

    $j(".LWtab li").click(function() {
        var num = $j(".LWtab li").index(this);
        $j(".content_wrap").addClass('disnon');
        $j(".content_wrap").eq(num).removeClass('disnon');
        $j(".LWtab li").removeClass('select');
        $j(this).addClass('select')
    });
});

/*The following Javascript will only be enabled if the viewer is on Tablet,  Laptop or  Desktop*/  
var windowWidth = $j(window).width();
if(windowWidth > 767){
/*Video& Menu will be on the sidebar when clicked*/
        $j(".videoside").click(function(){
          
          $j(".LWsidebar").css("width", "30%");
          $j(".maincontent").css("width", "70%");
          location.href = '#';
        });

/*Video& Menu will not be on the side bar when clicked*/
 $j(".videobig").click(function(){
          
          $j(".LWsidebar").css("width", "100%");
          $j(".maincontent").css("width", "100%");
      location.href = '#';
   
        });

}

