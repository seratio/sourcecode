    <!DOCTYPE html>
    <html lang="en">

    <head>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <meta name="description" content="">
      <meta name="author" content="">

      <title>Modern Slavery - Sentiment Survey</title>

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

            <style type='text/css'>
              .well {
                background-color: #E8E7DA;
              }

              .slider-example {
                padding: 10px 0;
                margin: 35px 0;
              }



              /* centered columns styles */
              .row-centered {
                text-align:center;
              }
              .col-centered {
                display:inline-block;
                float:none;
                /* reset the text-align */
                text-align:left;
                /* inline-block space fix */
                margin-right:-4px;
              }


            </style>


            {{ HTML::script('assets_frontend/js/jquery-2.1.1.min.js')}}

            {{ HTML::script('assets/js/bootstrap.min.js') }}


            {{ HTML::script('assets_frontend/js/modernizr.js')}}

          </head>

          <body>

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-fixed-top topnav" style="background-color:black;">
              <div class="container topnav">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>

                  {{ HTML::image('assets_backend/images/logo.png', 'SE Ratio', array('width' => '100')) }}

                </div>
                <div id="google_translate_element" class="navbar-brand navbar-right"></div>
                <!-- /.navbar-collapse -->
              </div>
              <!-- /.container -->
            </nav>


            <!-- Header -->
            <a name="about"></a>
            <div class="intro-header_eu">
              <div class="container">

                <div class="row">
                  <div class="col-lg-12">
                    <div class="intro-message">

                      <h3>SERATIO is the world leader in measuring the value of the people family, communities, organisation, regions, nations and even our thoughts<br><br>

                      </h3>
                      <hr class="intro-divider">
                    </div>
                  </div>
                </div>

              </div>

            </div>
            <!-- /.intro-header -->

            <!-- Page Content -->

            <a  name="services"></a>



            {{ Form::open(array('route' => array('cusurvey.save', $customer->id), 'method' => 'POST', 'class' => 'form')) }}
            {{ Form::hidden('customer_number', $customer->customer_number)}}


            <div class="content-section-b">
              <div class="container">

                <br>

                <div class="col-lg-10 col-md-offset-1">
                  <p class="description">
                    @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                      <strong> {{ Session::get('message') }}</strong>
                    </div>
                    @endif
                  </p>
                  <div class="box-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Customer Number</label>
                          {{ Form::text('customer_number', $customer->customer_number, array('class' => 'form-control', 'disabled')) }}
                          @if ($errors->has('customer_number')) <p class="help-block">{{ $errors->first('customer_number') }}</p> @endif
                        </div>
                      </div>
                       <div class="col-lg-6">
                        <div class="form-group">
                          <label>Customer Name</label>
                          {{ Form::text('customer_name', $customer->customer_name, array('class' => 'form-control', 'disabled')) }}
                        </div>
                      </div>

                    </div>

                    <div class="row">
                      <div class="col-lg-12">

                        <div class="form-group">
                          <label>In Which Country do you work?</label>
                          <select class ="form-control"
                          {{ Form::select('country', $con, '',  array('class' => 'form-control', 'required')) }}
                          @if ($errors->has('country')) <p class="help-block">{{ $errors->first('country') }}</p> @endif
                        </select>
                      </div>

                      <div class="form-group">
                        <label>Do you feel positive when you are at work?</label>
                        <select class ="form-control"
                        {{ Form::select('question_1', ['No' => 'No', 'Rarely' => 'Rarely', 'Sometimes' => 'Sometimes', 'Often' => 'Often', 'Always' => 'Always'], '',  array('class' => 'form-control', 'required')) }}
                        @if ($errors->has('question_1')) <p class="help-block">{{ $errors->first('question_1') }}</p> @endif
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Is it safe to speak up and challenge the way things are done within your organisation?</label>
                      <select class ="form-control"
                      {{ Form::select('question_2', ['Yes' => 'Yes', 'No' => 'No'], '',  array('class' => 'form-control', 'required')) }}
                      @if ($errors->has('question_2')) <p class="help-block">{{ $errors->first('question_2') }}</p> @endif
                    </select>
                  </div>
                  <div class="form-group">
                    <label>What impact does your work have on your health?</label>
                    <select class ="form-control"
                    {{ Form::select('question_3', ['Very Positive' => 'Very Positive', 'Positive' => 'Positive', 'None' => 'None', 'Negative' => 'Negative', 'Rather Negative' => 'Rather Negative'], '',  array('class' => 'form-control', 'required')) }}
                    @if ($errors->has('question_3')) <p class="help-block">{{ $errors->first('question_3') }}</p> @endif
                  </select>
                </div>
                <div class="form-group">
                  <label>Would you recommend your work to a friend?</label>
                  <select class ="form-control"
                  {{ Form::select('question_4', ['Yes' => 'Yes', 'No' => 'No'], '',  array('class' => 'form-control', 'required')) }}
                  @if ($errors->has('question_4')) <p class="help-block">{{ $errors->first('question_4') }}</p> @endif
                </select>
              </div>
              <div class="form-group">
                <label>Are you forced to work beyond your agreed working hours or workload and threatend with unpleasent consequences if you do not?</label>
                <select class ="form-control"
                {{ Form::select('question_5', ['Yes' => 'Yes', 'No' => 'No'], '',  array('class' => 'form-control', 'required')) }}
                @if ($errors->has('question_5')) <p class="help-block">{{ $errors->first('question_5') }}</p> @endif
              </select>
            </div>
            <div class="form-group">
              <label>Do you feel safe at your workplace?</label>
              <select class ="form-control"
              {{ Form::select('question_6', ['Yes' => 'Yes', 'No' => 'No'], '',  array('class' => 'form-control', 'required')) }}
              @if ($errors->has('question_6')) <p class="help-block">{{ $errors->first('question_6') }}</p> @endif
            </select>
          </div>
          <div class="form-group">
            <label>Are you movements outside of work restricted by your employer?</label>
            <select class ="form-control"
            {{ Form::select('question_7', ['Yes' => 'Yes', 'No' => 'No'], '',  array('class' => 'form-control', 'required')) }}
            @if ($errors->has('question_7')) <p class="help-block">{{ $errors->first('question_7') }}</p> @endif
          </select>
        </div>
        <div class="form-group">
          <label>Are you working voluntarily?</label>
          <select class ="form-control"
          {{ Form::select('question_8', ['Yes' => 'Yes', 'No' => 'No'], '',  array('class' => 'form-control', 'required')) }}
          @if ($errors->has('question_8')) <p class="help-block">{{ $errors->first('question_8') }}</p> @endif
        </select>
      </div>
      <div class="form-group">
        <label>Does your employer deduct money from your wages for travel, for food or for rent?</label>
        <select class ="form-control"
        {{ Form::select('question_9', ['Yes' => 'Yes', 'No' => 'No'], '',  array('class' => 'form-control', 'required')) }}
        @if ($errors->has('question_9')) <p class="help-block">{{ $errors->first('question_9') }}</p> @endif
      </select>
    </div>
    <div class="form-group">
      <label>Do you feel exploited in your work?</label>
      <select class ="form-control"
      {{ Form::select('question_10', ['No' => 'No', 'A Little' => 'A Little', 'Perhaps' => 'Perhaps', 'Sometimes' => 'Sometimes', 'Yes' => 'Yes'], '',  array('class' => 'form-control', 'required')) }}
      @if ($errors->has('question_10')) <p class="help-block">{{ $errors->first('question_10
      ') }}</p> @endif
    </select>
  </div>
</div>
</div>
<br>
<div class="row">
  <div class="col-lg-12">


  </div>

</div>

<div class="row">
  <div class="col-lg-12 col-md-offset-5">
    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
    {{ Form::reset('Reset', ['class' => 'btn btn-warning']) }}
    {{ Form::close() }}
  </div>
</div>

</div>
<br>


</div>
</div>
</div>



<!-- /.container -->

<a  name="contact"></a>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-xs-6">
        <p class="copyright text-muted small">Copyright &copy; Seratio 2020. All Rights Reserved</p>
      </div>
    </div>
  </div>

</footer>

{{ HTML::script('assets_frontend/bootstrap/js/jquery.js')}}

{{ HTML::script('assets_frontend/bootstrap/js/bootstrap.min.js')}}

{{ HTML::script('assets_frontend/js/bootstrap-slider.js')}}



<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, gaTrack: true, gaId: 'UA-70095941-1'}, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



</body>

</html>
