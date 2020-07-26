<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex">

    <title>Personal Value - Feedback Page </title>

    {{ HTML::style('assets_frontend/bootstrap/css/bootstrap.min.css')}}

    {{ HTML::style('assets_frontend/css/font-awesome.min.css')}}

    {{ HTML::style('assets_frontend/css/landing-page.css')}}

    {{ HTML::style('assets_frontend/css/bootstrap-slider.css')}}

    <!-- Custom Fonts -->
    {{ HTML::style('https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic')}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

<style>
.banner-feedback{
  height:400px;
}

.feedback input[type=radio]{
   visibility: hidden;
}

.feedback .btn-primary{
  width:100%;
  background-color: #BCBCBC;
  border-color: #BCBCBC;
}
.feedback .active{
  width:100%;
  background-color: #009933;
  border-color: #204d74;
}

.content{
  opacity: .10;
}

</style>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-71812286-1', 'auto');
  ga('send', 'pageview');

</script>
    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top topnav">
            <div class="container topnav">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand topnav" href="#">Personal Value</a>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>


        <!-- Header -->
        <a name="about"></a>
        <div class="intro-header banner-feedback">

                <div class="container">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="intro-message">
                            <h3>PV feedback for {{$name}}</br>

                          </h3>
                            <hr class="intro-divider">
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container -->

            </div>
            <!-- /.intro-header -->

            <!-- Page Content -->

            <a  name="services"></a>

            <div class="content-section-b">
                <p class="description">
                    @if (Session::has('message'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong> {{ Session::get('message') }}</strong>
                    </div>
                    @endif
                </p>

                <div class="container">

                @if($token)

                {{ Form::open( array('route'=>'feedback.store', 'class' => 'feedback-form')) }}
                <input type="hidden" name="token" value="{{$token}}" />
                 <h2> New PV Feedback</h2>

                 <p>This is the Personal Value feedback page for {{$name}}.
                    In just a few seconds please help {{$firstname}} understand @if($gender == 'Male')his @elseif($gender == 'Female')her @endif positive contribution to your life. Your feedback is anonymous.
                     </p>
                     <p>Please use either of these ways to tell us the positive impact {{$firstname}} has on your life</p>
                      <p>&nbsp</p>
                 <div class="row">

                   <div class="btn-group feedback" data-toggle="buttons">

                     <div class="col-lg-12">
                        <label class="btn btn-primary active option">
                          <input type="radio" name="options"  id="option1" autocomplete="off" value="1" checked> Score 1 to 10 - Click here to change the value
                        </label>

                        <div class="col-lg-12 text-center content">

                            <p>&nbsp</p>
                              <div class="input-group number-spinner col-lg-6 col-lg-push-3">
                          				 <div class="well">
                                      <input id="ex9" type="text" class="form-control" name="scale" data-slider-min="1" data-slider-max="10" data-slider-step="1" data-slider-value="1"/>
                                      <br>
                                      <span id="ex6CurrentSliderValLabel"><span id="ex9SliderVal">0</span>&nbsp;</span>
                          				 </div>
                          			</div>
                            <p>&nbsp</p>
                        </div>
                    </div>


                      <div class="col-lg-12">
                        <label class="btn btn-primary option">
                          <input type="radio" name="options"  id="option2" value="2"  autocomplete="off"> Type into box how {{$name}} makes you feel - Click here to type
                        </label>

                      <div class="col-lg-12 text-center content">
                            <p>&nbsp</p>
                            <div class="input-group number-spinner col-lg-6 col-lg-push-3">
                          				<textarea class="form-control" name="comment" cols="50" rows="10" ></textarea>

                           </div>
                            <p>&nbsp</p>
                      </div>

                        </div>


                      <!--<div class="col-lg-12">
                        <label class="btn btn-primary option">
                          <input type="radio" name="options"> Speak to us about how {{$name}} makes you feel (Work in Progress)
                        </label>

                        <div class="col-lg-12 text-center content">
                              <p>&nbsp</p>
                              <div class="input-group number-spinner col-lg-6 col-lg-push-3">
                            			<img src="assets/img/microphone_red.png" alt="mike" >
                             </div>
                              <p>&nbsp</p>
                        </div>
                      </div>-->


                    </div>

                <!-- /.col-lg-6 (nested) -->
<p>&nbsp;</p>
                <div class="col-lg-12 text-center">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg">Submit Feedback</button>
                    </div>
                    {{ Form::close() }}
                </div>

                 <p>&nbsp;</p>
                </div>
                @endif

        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-b -->


    <a  name="contact"></a>

    <!-- /.banner -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="copyright text-muted small">Copyright &copy; Seratio 2020. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    {{ HTML::script('assets_frontend/bootstrap/js/jquery.js')}}

    {{ HTML::script('assets_frontend/bootstrap/js/bootstrap.min.js')}}

    {{ HTML::script('assets_frontend/js/bootstrap-slider.js')}}

    <script type="text/javascript">

    $(".option").on("click",function(){
      $(".content").css("opacity",.4);
      $(".content",$(this).parent()).css("opacity",1);

    });
    $('.content').on('blur change click dblclick error focus focusin focusout hover keydown keypress keyup load mousedown      mouseup resize scroll select submit', function(event){
      if($(this).css("opacity")<1){
        event.preventDefault();
        return 0;
      }
    });

      $("#option1").click();


  	$(function() {
      var action;
      $(".number-spinner button").mousedown(function () {
          btn = $(this);
          input = btn.closest('.number-spinner').find('input');
          btn.closest('.number-spinner').find('button').prop("disabled", false);

      	if (btn.attr('data-dir') == 'up') {
              action = setInterval(function(){
                  if ( input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max')) ) {
                      input.val(parseInt(input.val())+1);
                  }else{
                      btn.prop("disabled", true);
                      clearInterval(action);
                  }
              }, 50);
      	} else {
              action = setInterval(function(){
                  if ( input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min')) ) {
                      input.val(parseInt(input.val())-1);
                  }else{
                      btn.prop("disabled", true);
                      clearInterval(action);
                  }
              }, 50);
      	}
      }).mouseup(function(){
          clearInterval(action);
      });
  });
  	</script>

    <script type="text/javascript">
       $("#ex9").slider();
          $("#ex9").on('slide', function(slideEvt) {
              $("#ex9SliderVal").text(slideEvt.value);
    });
    </script>

</body>

</html>
