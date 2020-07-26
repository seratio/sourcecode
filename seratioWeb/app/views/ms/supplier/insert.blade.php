    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Modern Slavery - Supplier Data Entry</title>

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

            @if($supplier)
            {{ Form::open(array('route' => array('modernslavery.change', $supplier->id), 'method' => 'POST', 'class' => 'form', 'files' => true)) }}
            {{ Form::hidden('supplier_number', $supplier->supplier_number) }}
            {{ Form::hidden('id', $supplier->id) }}

            <div class="content-section-b">
                <div class="container">

                    <br>

                    <div class="col-lg-10 col-md-offset-1">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Customer Number</label>
                                        {{ Form::text('customer_number', $supplier->customer_number, array('class' => 'form-control', 'disabled')) }}
                                        @if ($errors->has('customer_number')) <p class="help-block">{{ $errors->first('customer_number') }}</p> @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Suppplier Number</label>
                                        {{ Form::text('supplier_number', $supplier->supplier_number, array('class' => 'form-control', 'disabled')) }}
                                        @if ($errors->has('supplier_number')) <p class="help-block">{{ $errors->first('supplier_number') }}</p> @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Supplier Name</label>
                                        {{ Form::text('supplier_name', $supplier->supplier_name, array('class' => 'form-control', 'disabled')) }}
                                        @if ($errors->has('supplier_name')) <p class="help-block">{{ $errors->first('customer_number') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="form-group ">
                                       <font size="3">Have you completed this survey or provided any data
                                        before for another Customer?
                                        {{ Form::radio('supplier_another_check', "Yes", $supplier->supplier_another_check, array('class' => 'supplier1', 'required')) }} Yes
                                        {{ Form::radio('supplier_another_check', "No", $supplier->supplier_another_check, array('class' => 'supplier1')) }} No
                                    </font>
                                </div>


                                <div id="supplier_another">
                                  <div class="form-group">
                                    {{ Form::text('supplier_another', $supplier->supplier_another, array('class' => 'form-control', 'placeholder' => 'Please enter the Supplier Number', 'id'=>'supplier_another')) }}
                                    @if ($errors->has('supplier_another')) <p class="help-block">{{ $errors->first('supplier_another') }}</p> @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>



                    <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                             <label>Total Revenue in Miliion's</label>
                             {{ Form::number('total_revenue', $supplier->total_revenue, array('step' => 'any', 'class' => 'form-control', 'placeholder' => 'Total Revenue in million’s', 'required')) }}
                             @if ($errors->has('total_revenue')) <p class="help-block">{{ $errors->first('total_revenue') }}</p> @endif
                         </div>
                         <div class="form-group">
                             <label>Currency of Revenue and Payroll</label>
                             <select class ="form-control"
                             {{ Form::select('currency', $currencies, $supplier->currency, array('class' => 'form-control', 'placeholder' => 'Currency', 'required')) }}
                             @if ($errors->has('currency')) <p class="help-block">{{ $errors->first('currency') }}</p> @endif
                         </select>
                     </div>



                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                      <label>Total Payroll/wages in million’s'</label>
                      {{ Form::number('total_wages', $supplier->total_wages, array('step' => 'any','class' => 'form-control', 'placeholder' => 'Total Payroll/wages in million’s', 'required')) }}
                      @if ($errors->has('total_wages')) <p class="help-block">{{ $errors->first('total_wages') }}</p> @endif
                  </div>
                  <div class="form-group">
                    <label>Number of employees</label>
                    {{ Form::number('no_of_employees', $supplier->no_of_employees, array('step' => 'any', 'class' => 'form-control', 'placeholder' => 'Number of employees', 'required')) }}
                    @if ($errors->has('no_of_employees')) <p class="help-block">{{ $errors->first('no_of_employees') }}</p> @endif

                </div>

            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-lg-12">
                 <div class="form-group">
                        <label>Please upload last financial year’s audited accounts[File Types: pdf, doc, xls]</label>
                        {{ Form::file('document1') }}
                        @if ($errors->has('document1')) <p class="help-block">{{ $errors->first('document1') }}</p> @endif
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-10">

                      <br>
                      <div class="form-group ">
                       <font size="4">Have you carried out a sentiment survey of your employees?

                         {{ Form::select('sentiment_q1', ['-1' => '-- Please Select --', '1' => 'Yes', '0' => 'No'], $supplier->sentiment_q1, array('id' =>'viewSelector')) }}
                         @if ($errors->has('sentiment_q1')) <p class="help-block">{{ $errors->first('sentiment_q1') }}</p> @endif

                     </font>
                 </div>

                 <div id="yes">
                  <br>


                  <div class="form-group">
                    <label for="question1">What % of your employees would recommend your company to a friend to work for?</label>
                    {{ Form::number('sentiment_q2', $supplier->sentiment_q2, array('step' => 'any', 'class' => 'form-control', 'placeholder' => 'What % of your employees would recommend your company to a friend to work for?', 'id'=>'question1')) }}
                    @if ($errors->has('sentiment_q2')) <p class="help-block">{{ $errors->first('sentiment_q2') }}</p> @endif
                </div>
                <br>
                <div class="form-group">
                    <label for="question2">What % of employees completed your survey?</label>
                    {{ Form::number('sentiment_q3', $supplier->sentiment_q3, array('step' => 'any', 'class' => 'form-control', 'placeholder' => 'What % of employees completed your survey?', 'id'=>'question2')) }}
                    @if ($errors->has('sentiment_q3')) <p class="help-block">{{ $errors->first('sentiment_q3') }}</p> @endif
                </div>
                <br>
                <div class="form-group">
                    <label for="question2">When was this survey conducted? Month/Year</label>
                    {{ Form::text('sentiment_q4', $supplier->sentiment_q3, array('step' => 'any', 'class' => 'form-control', 'placeholder' => 'When was this survey conducted? Month/Year?', 'id'=>'question2')) }}
                    @if ($errors->has('sentiment_q4')) <p class="help-block">{{ $errors->first('sentiment_q4') }}</p> @endif
                </div>
                <br>


            </div>


        </div>
    </div>

</div>
</div>
<br><br>
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

{
    @else
    Something went wrong. Please input your correct Customer Number and Supplier Number

    @endif


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
        $(document).ready(function(){

            @if($supplier->supplier_another_check == "Yes")
            $("#supplier_another").show();
            @else
            $("#supplier_another").hide();
            @endif
            $(".supplier1").click(function(){
                if ($('input[name=supplier_another_check]:checked').val() == "Yes" ) {
            $("#supplier_another").show() //Slide Down Effect
        } else {
            $("#supplier_another").hide();  //Slide Up Effect
        }
    })
        });
    </script>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, gaTrack: true, gaId: 'UA-70095941-1'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $.viewMap = {
                '1' : $('#yes'),
                '0' : $('#no')
            };
            $('#viewSelector').change(function() {
            // hide all
            $.each($.viewMap, function() { this.hide(); });
            // show current
            $.viewMap[$(this).val()].show();
        }).trigger('change');
        });

    </script>

</body>

</html>
