$(function(){
		
	$.each($(".sidebar-item"), function( index, value ) {
		$parent = false;
		$toggleUl = false;
		$(value).find("ul > li > a").on("click", function(e){
			e.preventDefault();
			$parent = $(this).parent();
			$toggleUl = $parent.find("> .sidebar-item-content");
		 	$(value).find("ul > li > .sidebar-item-content").not($toggleUl).slideUp(200).parent().removeClass("active");
		 	
			$toggleUl.slideToggle(200);
			$parent.toggleClass('active');
		});
	});


	$('#navbar-toggle-btn').on('click', function(e){
		e.preventDefault();
		$('.header-navbar').slideToggle(200);
	})
	// console.log('hello');
	
	$('.masonry-container').imagesLoaded()
	  .always( function( instance ) {
	    console.log('all images loaded');
	  })
	  .done( function( instance ) {
	    console.log('all images successfully loaded');
	  })
	  .fail( function() {
	    console.log('all images loaded, at least one is broken');
	  })
	  .progress( function( instance, image ) {
	    var result = image.isLoaded ? 'loaded' : 'broken';
	    console.log( 'image is ' + result + ' for ' + image.img.src );
	  });

	$('.masonry-container').imagesLoaded(function () {
		$('.masonry-container').masonry({ itemSelector: '.item'	});
	$('.home-items-container').masonry({ itemSelector: '.home-item'	});

	
	});
	
	var colCount = 0;
	var colWidth = 0;
	var margin = 0;
	var containerWidth = 0;

	setupBlocks();
	positionBlocks($('.home-items-container > .home-item'));

	// If any img loads
	$(".home-item-img img").load(function() {
		setupBlocks();
		positionBlocks($('.home-items-container > .home-item'));
	});

	// On view port change reinit
	$(document).on("viewPortChange", function(){
		setupBlocks();
		positionBlocks($('.home-items-container > .home-item'));
	});
	$('.item-close').on("click", function(e){
		e.preventDefault();
		$(this).closest('.home-item, .home-sidebar-item').remove();
		
	    setupBlocks();
		positionBlocks($('.home-items-container > .home-item'));
		
	});

	$( window ).resize(function() {
	 	setupBlocks();
		positionBlocks($('.home-items-container > .home-item'));
	});
	// navigation
	$(".modal-fixed-list ul li a").click(function(e){
		e.preventDefault();
		$href=$(this).data("href");
		console.log($href);
		$(".bg-overlay:hidden").show();
		$(".modal-content-wrapper").fadeOut("fast", function(){
//			$.get( "inner-"+$href+".php", function( data ) {
			$.get( "index.php?r="+$href, function( data ) {
			  $( ".modal-content-wrapper" ).html( data );
			  $(".modal-content-wrapper").fadeIn("fast");
			  $("html, body").animate({ scrollTop: 0 });
			});
		});

	});
	$(".bg-overlay").delegate(".item-close", "click", function(e){
		e.preventDefault();
		$(".bg-overlay").fadeOut("fast", function(){$(".modal-content-wrapper").hide()});
	});

	
});
function setupBlocks() {
    containerWidth = $(".home-items-container").outerWidth();
    colWidth = $('.home-items-container > .home-item').outerWidth()-0.5;
    colCount = Math.floor(containerWidth/colWidth);

    blocks = [];

    for(var i=0; i < colCount; i++) {
        blocks[i]=0;
    }
}

function positionBlocks($items) {
    $items.each(function(){
        var min = Array.min(blocks);
        var index = $.inArray(min, blocks);
        var leftPos = (index*colWidth);

        $(this).css({
        	position : "absolute",
            left : leftPos+'px',
            top : min+15+'px'
        });

        blocks[index] = min+15+$(this).outerHeight();

        $(".home-items-container").css({
	    	height : Array.max(blocks)
	    });
    });
}

//opens dialog form 
function navigation(e){
	href=$(e).data("href");
	$(".bg-overlay:hidden").show();
	$(".modal-content-wrapper").fadeOut("fast", function(){
                
				/*
				$.get(href, function( data ) {
                  $( ".modal-content-wrapper" ).html( data );
                  $(".modal-content-wrapper").fadeIn("fast");
                  $("html, body").animate({ scrollTop: 0 });
                });
				*/
				$.ajax({
					 async: false,
					 type: 'GET',
					 url: href,
					 beforeSend: function( xhr ) {
						$(".loading").show();
					 },
					 success: function(data) {

						   $( ".modal-content-wrapper" ).html( data );
						  $(".modal-content-wrapper").fadeIn("fast");
						  $("html, body").animate({ scrollTop: 0 });
						  $(".loading").hide();
					 },
					 error: function(){
						 $(".loading").hide();
						 }
				});
        });


}
function navigationToView(url){
	//href=$(e).data("href");
	$(".bg-overlay:hidden").show();
	$(".modal-content-wrapper").fadeOut("fast", function(){
                $.get(url, function( data ) {
                  $( ".modal-content-wrapper" ).html( data );
                  $(".modal-content-wrapper").fadeIn("fast");
                  $("html, body").animate({ scrollTop: 0 });
                });
        });


}

function navigationToViewAfterUpdate(url){
	//href=$(e).data("href");
//	$(".bg-overlay:hidden").show();
//	$(".modal-content-wrapper").fadeOut("fast", function(){
//                $.get(url, function( data ) {
//                  $( ".modal-content-wrapper" ).html( data );
//                  $(".modal-content-wrapper").fadeIn("fast");
//                  $("html, body").animate({ scrollTop: 0 });
//                });
//        });


}


Array.min = function(array) {
    return Math.min.apply(Math, array);
};
Array.max = function(array) {
    return Math.max.apply(Math, array);
};

//show or hide car data from announcement creating page
function car_data(e){
    if(e.value == 1)
        $('.car-data').show();
    else
        $('.car-data').hide();
}
function mySubmitFormFunction(form, data, hasError){
    if (!hasError){
        // No errors! Do your post and stuff
        // FYI, this will NOT set $_POST['ajax']... 
        $.post(form.attr('action'), form.serialize(), function(res){
            // Do stuff with your response data!
            if (res.result)
                console.log(res.data);
            
            location.reload();  
        });
    }
    // Always return false so that Yii will never do a traditional form submit
    return false;
}

function mySubmit(form, data, hasError){
    if (!hasError){
        console.log(form);
        //form.submit();
    }
    // Always return false so that Yii will never do a traditional form submit
    return false;
}

function paymentSubmit(url, formId,update){
    var data=$("#"+formId).serialize();
    $.ajax({
        "type"  : "POST",
        "url"   : url,
        "data"  : data,
        success  : function(response){
            $("."+update).remove();
            $(".bieden-content").after(response);
        },
    });
}

function closeImage(e){
    var path = $(e).data('path');
    var id = $(e).data('id');
    var url = $(e).data('url');
    var selector = "input[value="+"\'"+id+"\'"+"]";
    				
    $.ajax({
        "type"  : "POST",
        "url"   : url,
        "data"  : {'id' : id, 'path' : path},
        success  : function(response){
            $(".photo-item-input").find(selector).remove();
            $(this).parent().parent().remove();
            $(".click-photo").css("background-image","none");		
        },
    });
}

function morephotos(){
        $('#more-photos-div').show();
		$('#more-photos i').hide();
		$('#more-photos span').hide();
		$('#more-photos').css('background-color', 'transparent');
	}
	
	function changeMainImageBackground(currentObject){
		var bug_url = $(currentObject).css("background-image").replace('/thumbs','');
		$(".click-photo-wrapper .click-photo").css("background-image",bug_url);
	}


Share = {
    facebook: function(purl, ptitle, pimg, text) {
        url  = 'http://www.facebook.com/sharer.php?s=100';
        url += '&p[title]='     + encodeURIComponent(ptitle);
        url += '&p[summary]='   + encodeURIComponent(text);
        url += '&p[url]='       + encodeURIComponent(document.URL+purl);
        url += '&p[images][0]=' + encodeURIComponent(pimg);
        Share.popup(url);
    },
    twitter: function(purl, ptitle) {
        url  = 'http://twitter.com/share?';
        url += 'text='      + encodeURIComponent(ptitle);
        url += '&url='      + encodeURIComponent(purl);
        url += '&counturl=' + encodeURIComponent(purl);
        Share.popup(url);
    },

    popup: function(url) {
        window.open(url,'','toolbar=0,status=0,width=626,height=436');
    }
};

/*function for getting category childs*/
function changeCategory(e){
    var href=$(e).data("href");
    var id = $(e).val();
    var elements = $(e).parent('div').nextAll(".child");
    elements.each(function(){
        $(this).not("parent_"+id).remove();
    });
    if(id != ''){
        var data = {id:id};
        $.ajax({
             async: false,
             type: "POST",
             url: href,
             data : data,
             success: function(data) {
                $(".buttons").before(data);
             },
             dataType:"html"
        });
    }
}

/*
 * ajax function for save what widgetsto show for user
 */
function widgetOperations(e){
    var href=$(e).data("href");
    var status=$(e).data("status");
    var id=$(e).data("id");
    var data = {status:status, id:id};
    $.ajax({
         async: false,
         type: "POST",
         url: href,
         data : data,
         success: function(data) {
            location.reload();
         },
         dataType:"html"
    });
   
}
/*
 * ajax function for save what widgetsto show for user
 */
function saveAnnouncement(e){
    var href=$(e).data("href");
    var id=$(e).data("id");
    var data = {id:id};
    $.ajax({
         async: false,
         type: "POST",
         url: href,
         data : data,
         success: function(data) {
                $(".alert-success").remove();
                $(".main-title").after('<div class="alert alert-success in alert-block fade"><a class="close" type="button" data-dismiss="alert" href="#">×</a>'+data+'</div>');
         },
         dataType:"html"
    });
}

/*
 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
 */

$('.fancybox-thumbs').fancybox({
        prevEffect : 'none',
        nextEffect : 'none',

        //closeBtn  : false,
        //arrows    : false,
        nextClick : true,

        helpers : {
                thumbs : {
                        width  : 50,
                        height : 50
                },
                title	: {
				type: 'inside',
                position : 'top'
			},
        }
});

//	$(".fancybox-thumb").fancybox({
//		prevEffect	: 'none',
//		nextEffect	: 'none',
//		helpers	: {
//			title	: {
//				type: 'outside'
//			},
//			thumbs	: {
//				width	: 50,
//				height	: 50
//			}
//		}
//	});

function deleteAnn(e){
    var conf = confirm("Are you sure to delete?")
    if(conf == true){
        var href = $(e).data('submit');
        window.location.assign(href);
    }else{
        return false;
    }
}