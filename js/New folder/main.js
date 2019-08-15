
/*goto top btn*/
$(window).scroll(function(e) {
	if($(window).scrollTop() > 30) {
        $('.navbar-default').addClass('scrolled');
        $('.gotobtn').css('right','10px');
    }
	else  {
        $('.navbar-default').removeClass('scrolled');
        $('.gotobtn').css('right','-40px');
    }
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip()
    
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("400");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("400");
            $(this).toggleClass('open');       
        }
    );
});

$('.gotobtn').click(function(e) {
	$("html, body").animate({ scrollTop: 0 }, 600);
});

$('.mob-search-btn').click(function(event) {
    $('.search').toggleClass('show');
});

$('.mob-menu-toggle,.mob-menu-close,.mob-menu').click(function(event) {
    $('.mob-menu,.mob-menu-close').toggleClass('show');
});

function subscribe($this){

    if($($this).parents('.row').find('#subMail').val().trim() == ''){
        $($this).parents('.row').find('#subErr').html('<i class="fa fa-warning fa-fw"></i> Enter email address!');
    }
    else{
       if(!/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i.test($($this).parents('.row').find('#subMail').val().trim())){
            $($this).parents('.row').find('#subErr').html('<i class="fa fa-warning fa-fw"></i> Invalid email address!');
        } 
        else{
            $($this).parents('.row').find('#subErr').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Subscribing...');
            $.ajax({
                url: 'ajax/subs.php',
                type: 'post',
                data: {se: $($this).parents('.row').find('#subMail').val().trim()},
                success: function(res){
                    if(res.trim() == 'e'){
                        $($this).parents('.row').find('#subMail').val('');
                        $($this).parents('.row').find('#subErr').html('<i class="fa fa-check fa-fw"></i> You are already in our mailing list.');
                    }
                    else{
                        $($this).parents('.row').find('#subMail').val('');
                        $($this).parents('.row').find('#subErr').html('<i class="fa fa-check fa-fw"></i> Thank you for subscribing!');
                    }
                }
            });
        }
    }
    setTimeout(function(){$('#subErr').html('')}, 3000);
}
$(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})

$('[data-star]').click(function(event) {
  rate=$(this).data('star');
  $('[data-star]').find('i').removeClass('fa-star').addClass('fa-star-o');
  for (var i = 1; i <= rate; i++) {
    $('[data-star='+i+']').find('i').addClass('fa-star').removeClass('fa-star-o');
  }
});

function login(){
    $('#login').modal('show');
    $('#signup').modal('hide');
}
function register(){
    $('#signup').modal('show');
    $('#login').modal('hide');
}

function forgot(){
    $('#fmodal').modal('show');
    $('#login').modal('hide');
}



// search
$("#search").on('keyup',function(){
  if(this.value.length >= 2){
    $.ajax({
      type: "POST",
      url: "ajax/search.php",
      data:'q='+$(this).val(),
      beforeSend: function(){
        $("#search").parent().find('i').removeClass('fa-search').addClass('fa-refresh fa-spin');
      },
      success: function(data){
        $("#search").parent().find('i').addClass('fa-search').removeClass('fa-refresh fa-spin');
        $(".sugg-box").html(data);
        $(".sugg-box").show();
      }
    });
  }else{$(".sugg-box").html('');}
});
$("#search").on('focusin click',function(e){$(".sugg-box").show();e.stopPropagation();});
$("body").on('click',function(e){$(".sugg-box").hide()});