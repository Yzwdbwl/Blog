<footer>
    <hr>
    <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
    <p class="pull-right">B01658325</p>
    <p>WENXIN XU</p>
</footer>
<script type="text/javascript">
    $(function() {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
</script>
<iframe frameborder='0' name='hiddenwin' id='hiddenwin' scrolling='no' class='debugwin hidden'></iframe>
<div id="scrolltop" style="display: none;">
    <div id="backwords">
         <a class="fhdb" href="javascript:;">^</a>
    </div>
</div>
<script type="text/javascript">
$(function(){
	$(window).scroll(function(){
		var top = $(window).scrollTop();
		if(top > 0){
			$("#scrolltop").fadeIn("slow");
		}else{
			$("#scrolltop").fadeOut("slow");
		}
		});
		$("#scrolltop").click(function(){
			$("html,body").animate({ scrollTop:0});
		});
	});
</script>
<script src="<?php echo loadStatic('/home/common.js'); ?>" type="text/javascript"></script>