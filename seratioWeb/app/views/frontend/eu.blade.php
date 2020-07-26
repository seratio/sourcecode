<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Social Value Test</title>

    {{ HTML::style('assets_frontend/bootstrap/css/bootstrap.min.css')}}

    {{ HTML::style('assets_frontend/css/font-awesome.min.css')}}

    {{ HTML::style('assets_frontend/css/landing-page.css')}}

    {{ HTML::style('assets_frontend/css/bootstrap-slider.css')}}

    <!-- Custom Fonts -->
    {{ HTML::style('http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic')}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        {{ HTML::script('assets_frontend/js/modernizr.js')}}




        <style type='text/css'>
        .well {
            background-color: #E8E7DA;
        }

        .slider-example {
            padding: 10px 0;
            margin: 35px 0;
        }

        #destroyEx5Slider, #ex6CurrentSliderValLabel, #ex7-enabled {
            margin-left: 45px;
        }

        #ex1SliderVal, #ex2SliderVal, #ex3SliderVal, #ex4SliderVal, #ex5SliderVal, #ex6SliderVal,
        #ex7SliderVal, #ex8SliderVal, #ex9SliderVal {
            color: black;
        }


        #slider12a .slider-track-high, #slider12c .slider-track-high {
            background: green;
        }

        #slider12b .slider-track-low, #slider12c .slider-track-low {
            background: red;
        }

        #slider12c .slider-selection {
            background: yellow;
        }
        /* Example 1 custom styles */
        #ex1Slider .slider-selection {
            background: #BABABA;
        }

        /* Example 3 custom styles */
        #RGB {
            height: 20px;
            background: rgb(128, 128, 128);
        }
        #RC .slider-selection {
            background: #FF8282;
        }
        #RC .slider-handle {
            background: red;
        }
        #GC .slider-selection {
            background: #428041;
        }
        #GC .slider-handle {
            background: green;
        }
        #BC .slider-selection {
            background: #8283FF;
        }
        #BC .slider-handle {
            border-bottom-color: blue;
        }
        #R, #G, #B {
            width: 300px;
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
        {{ HTML::script('assets_frontend/js/modernizr.js')}}
        {{ HTML::script('assets_frontend/js/jquery-2.1.1.min.js')}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!--<script type="text/javascript">
        $(document).ready(function(){
            $("#myModal").modal('show');
        });
    </script>-->

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

               {{ HTML::image('assets_backend/images/fiware.png', 'SE Ratio', array('width' => '250')) }}

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

            <div class="content-section-b">
                <div class="container">

                    <br>



            <div class="row row-centered">

                <div class="col-lg-8 col-centered">

                    {{ Form::open(array('route' => 'eu.store', 'class' => 'form', 'id' => 'eu')) }}
                     {{ Form::hidden('user_id', $id) }}
                    <div class="form-group">
                        <h4>Choose your FIWARE Accelerator</h4>

                        <select name="question1" class="form-control" required>
                            <option selected value="">Please select
                            </option>
                            <option value="A1 CEED Tech">A1 CEED Tech</option>
                            <option value="A2 EuropeanPioneers">A2 EuropeanPioneers</option>
                            <option value="A3 FI-C3">A3 FI-C3</option>
                            <option value="A4 Finodex">A4 Finodex</option>
                            <option value="A5 frontierCities">A5 frontierCities</option>
                            <option value="A6 IMPACT">A6 IMPACT</option>
                            <option value="A7 INCENSe">A7 INCENSe</option>
                            <option value="A8 SOUL-FI">A8 SOUL-FI</option>
                            <option value="A9 SpeedUP!">A9 SpeedUP!</option>
                            <option value="B1 FI-ADOPT">B1 FI-ADOPT</option>
                            <option value="B2  FICHe">B2  FICHe</option>
                            <option value="B3 FInish">B3 FInish</option>
                            <option value="B4 FRACTALS">B4 FRACTALS</option>
                            <option value="B5 SmartAgriFood">B5 SmartAgriFood</option>
                            <option value="B6 CreatiFi">B6 CreatiFi</option>
                            <option value="B7 FABulous">B7 FABulous</option>

                        </select>
                        @if ($errors->has('question1')) <p class="help-block" style="color:red">{{ $errors->first('question1') }}</p> @endif
                    </div>

                </div>

            </div>

            <div class="row row-centered">

                <div class="col-lg-8 col-centered">

                    <br>
                    <div class="form-group">
                        <label>Roughly, what is your company worth in Euros?  <p style="color:grey;font-size: 80%">(Eg. Financial value of your company)</p></label></label>
                        <div class="well">
                            <input id="ex1" type="text" class="form-control" name="question2" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="0"/>
                            <span id="ex6CurrentSliderValLabel"><span id="ex1SliderVal">0</span>&nbsp;</span>
                        </div>
                        @if ($errors->has('question2')) <p class="help-block" style="color:red">{{ $errors->first('question2') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label>How many staff do you have?<p style="color:grey;font-size: 80%">(Eg. Full-time workers, volunteers)</p></label>
                        <div class="well">
                            <input id="ex2" type="text" name="question3" class="form-control" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                            <span id="ex6CurrentSliderValLabel"><span id="label"></span>&nbsp; <span id="ex2SliderVal">1</span>&nbsp;</span>
                        </div>
                        @if ($errors->has('question3')) <p class="help-block" style="color:red">{{ $errors->first('question3') }}</p> @endif
                    </div>
                </div>

                <div class="col-lg-8 col-centered">
                    <div class="form-group">
                        <label>What is total number of shares in your company? <p style="color:grey;font-size: 80%">(Eg. Units of ownership)</p></label>
                        <div class="well">
                            <input id="ex3" type="text" name="question4" class="form-control" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                            <span id="ex6CurrentSliderValLabel"><span id="label1"></span>&nbsp;<span id="ex3SliderVal">1</span></span>
                        </div>
                        @if ($errors->has('question4')) <p class="help-block" style="color:red">{{ $errors->first('question4') }}</p> @endif
                    </div>
                </div>

                <div class="col-lg-8 col-centered">
                    <div class="form-group">
                        <label>What is your annual social spend in Euros?  <p style="color:grey;font-size: 80%"> (Eg. Corporate Social Responsibility (CSR) spendings, charitable giving or social activities costs)</p></label>
                        <div class="well">
                            <input id="ex4" type="text" class="form-control" name="question5"  data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                            <span id="ex6CurrentSliderValLabel"><span id="label2"></span>&nbsp;<span id="ex4SliderVal">1</span></span>
                        </div>
                        @if ($errors->has('question5')) <p class="help-block" style="color:red">{{ $errors->first('question5') }}</p> @endif
                    </div>

                    <div class="form-group">
                        <label>How many people does your company support socially in a year?  <p style="color:grey;font-size: 80%"> (Eg. People helped through CSR, charitable or social activities)</p></label>
                        <div class="well">
                            <input id="ex5" type="text" class="form-control" name="question6" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                            <span id="ex6CurrentSliderValLabel"> <span id="ex5SliderVal">1</span>&nbsp;</span>
                        </div>
                        @if ($errors->has('question6')) <p class="help-block" style="color:red">{{ $errors->first('question6') }}</p> @endif
                    </div>
                </div>
                <br>
                <div class="col-lg-8 col-centered">
                    <div class="form-group">
                        <label>How happy are the beneficiaries with the services provided by your company?  <p style="color:grey;font-size: 80%"> (Eg. Positive feedback)</p> </label>
                        <select id="question7" name="question7" class="form-control" required>
                            <option selected value="">Please Select</option>
                            <option value="0">Not at all satisfied</option>
                            <option value="25">Slightly satisfied</option>
                            <option value="50">Somewhat satisfied</option>
                            <option value="75">Very satisfied</option>
                            <option value="100">Completely satisfied</option>
                        </select>
                        @if ($errors->has('question7')) <p class="help-block" style="color:red">{{ $errors->first('question7') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <label>How environmentally friendly is your company?  <p style="color:grey;font-size: 80%"> (Eg. Carbon emissions, water, electricity reduction)</p></label>
                        <select id="question8" name="question8" class="form-control" required>
                            <option selected value="">Please Select</option>
                            <option value="0">Not at all friendly</option>
                            <option value="25">Slightly friendly</option>
                            <option value="50">Somewhat friendly</option>
                            <option value="75">Very friendly</option>
                            <option value="100">Absolutely friendly</option>
                        </select>
                        @if ($errors->has('question8')) <p class="help-block" style="color:red">{{ $errors->first('question8') }}</p> @endif
                    </div>
                </div>


                <div class="row" align="center">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                        {{ Form::close() }}
                    </div>
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

function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
  }
  return val;
}

$(document).ready(function() {


    /* Question 2 */
     $("#ex1").slider({
        min: 1,
        max: 10000000,
        scale: 'logarithmic',
        step: 1
    });
    $("#ex1").on('slide', function(slideEvt) {
        $("#ex1SliderVal").html(commaSeparateNumber((slideEvt.value)));
    });
    /* Question 3 */

    $("#ex2").slider({
        min: 1,
        max: 1000,
        scale: 'linear',
        step: 1
    });
    $("#ex2").on('slide', function(slideEvt) {
        $("#ex2SliderVal").html(commaSeparateNumber((slideEvt.value)));


    });

    /* question 4 */
    $("#ex3").slider({
        min: 1,
        max: 1000000,
        scale: 'logarithmic',
        step: 1
    });
    $("#ex3").on('slide', function(slideEvt) {
        $("#ex3SliderVal").html(commaSeparateNumber((slideEvt.value)));
    });

    /* question 5 */

    $("#ex4").slider({
        min: 1,
        max: 1000000,
        scale: 'logarithmic',
        step: 1
    });
    $("#ex4").on('slide', function(slideEvt) {
        $("#ex4SliderVal").html(commaSeparateNumber((slideEvt.value)));
    });

    /* question 6 */

    $("#ex5").slider({
        min: 1,
        max: 1000000,
        scale: 'logarithmic',
        step: 1
    });
    $("#ex5").on('slide', function(slideEvt) {
        $("#ex5SliderVal").html(commaSeparateNumber((slideEvt.value)));
    });



});
</script>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, gaTrack: true, gaId: 'UA-70095941-1'}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>

</html>
