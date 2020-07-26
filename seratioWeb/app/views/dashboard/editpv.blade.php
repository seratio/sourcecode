@extends('layout.dashboard_default')
@section('title')
SE Ratio::
@parent
@stop
@section('css')
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
@stop
@section('content')
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Redo Your Quick PV
      </h1>
      <ol class="breadcrumb">
         <li>
            <div id="google_translate_element"></div>
         </li>
      </ol>
   </section>
   <p class="description">
      @if (Session::has('message'))
   <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <strong> {{ Session::get('message') }}</strong>
   </div>
   @endif
   </p>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
               <div class="row row-centered">
                  <div class="col-lg-8 col-centered">
                     <!--<div class="alert alert-danger">
                        <button href="#" type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="glyphicon glyphicon-remove-circle text-info"></i></button>
                        <h4>Get your PV score in 3 easy steps</h4>
                        <p>Step 1  Select your country to use the right currency using the drop down menu <br><br>
                          Step 2  Answer all 8 questions by sliding the button to the right number/range OR select an option from the drop down menu<br><br>
                          Step 3  Press "submit button" to calculate your PV
                          <br><br>
                          If you want to start again just press "reset button" </p>
                        </div>-->
                     {{ Form::open(array('route' => array('personalvalue.update', $pvalue->id), 'method' => 'PUT')) }}
                     <div class="form-group">
                        <h4>Please select your Country</h4>
                        <select id="mySelect" name="currency" class="form-control" onchange="copy();">
                           <option selected value="">Please Select Your Country</option>
                           <option value="GBP1">United Kingdom</option>
                           <option value="AFN2">Afghanistan</option>
                           <option value="ALL3">Albania</option>
                           <option value="DZD4">Algeria</option>
                           <option value="EUR5">Andorra</option>
                           <option value="AOA6">Angola</option>
                           <option value="XCD7">Anguilla</option>
                           <option value="XCD8">Antigua and Barbuda</option>
                           <option value="ARS9">Argentina</option>
                           <option value="AMD10">Armenia</option>
                           <option value="AWG11">Aruba</option>
                           <option value="AUD12">Australia</option>
                           <option value="EUR13">Austria</option>
                           <option value="AZN14">Azerbaijan</option>
                           <option value="BSD15">Bahamas</option>
                           <option value="BHD16">Bahrain</option>
                           <option value="BDT17">Bangladesh</option>
                           <option value="BBD18">Barbados</option>
                           <option value="EUR20">Belgium</option>
                           <option value="BZD21">Belize</option>
                           <option value="XOF22">Benin</option>
                           <option value="BMD23">Bermuda</option>
                           <option value="INR24">Bhutan</option>
                           <option value="BOB25">Bolivia, Plurinational State of</option>
                           <option value="BAM26">Bosnia and Herzegovina</option>
                           <option value="BWP27">Botswana</option>
                           <option value="BRL28">Brazil</option>
                           <option value="BND29">Brunei Darussalam</option>
                           <option value="BGN30">Bulgaria</option>
                           <option value="XOF31">Burkina Faso</option>
                           <option value="BIF32">Burundi</option>
                           <option value="KHR33">Cambodia</option>
                           <option value="XAF34">Cameroon</option>
                           <option value="CAD35">Canada</option>
                           <option value="CVE36">Cape Verde</option>
                           <option value="KYD37">Cayman Islands</option>
                           <option value="XAF38">Central African Republic</option>
                           <option value="XAF39">Chad</option>
                           <option value="CLP40">Chile</option>
                           <option value="CNY41">China</option>
                           <option value="COP42">Colombia</option>
                           <option value="KMF43">Comoros</option>
                           <option value="XAF44">Congo</option>
                           <option value="NZD45">Cook Islands</option>
                           <option value="CRC46">Costa Rica</option>
                           <option value="XOF47">Côte d'Ivoire</option>
                           <option value="HRK48">Croatia</option>
                           <option value="CUP49">Cuba</option>
                           <option value="EUR50">Cyprus</option>
                           <option value="CZK51">Czech Republic</option>
                           <option value="DKK52">Denmark</option>
                           <option value="DJF53">Djibouti</option>
                           <option value="XCD54">Dominica</option>
                           <option value="DOP55">Dominican Republic</option>
                           <option value="USD56">Ecuador</option>
                           <option value="EGP57">Egypt</option>
                           <option value="USD58">El Salvador</option>
                           <option value="XAF59">Equatorial Guinea</option>
                           <option value="ERN60">Eritrea</option>
                           <option value="EUR61">Estonia</option>
                           <option value="ETB62">Ethiopia</option>
                           <option value="DKK63">Faroe Islands</option>
                           <option value="FKP64">Falkland Islands (Malvinas)</option>
                           <option value="FJD65">Fiji</option>
                           <option value="EUR66">Finland</option>
                           <option value="EUR67">France</option>
                           <option value="EUR68">French Guiana</option>
                           <option value="XPF69">French Polynesia</option>
                           <option value="XAF70">Gabon</option>
                           <option value="GMD71">Gambia</option>
                           <option value="GEL72">Georgia</option>
                           <option value="EUR73">Germany</option>
                           <option value="GIP75">Gibraltar</option>
                           <option value="EUR76">Greece</option>
                           <option value="DKK77">Greenland</option>
                           <option value="XCD78">Grenada</option>
                           <option value="EUR79">Guadeloupe</option>
                           <option value="GTQ80">Guatemala</option>
                           <option value="GNF81">Guinea</option>
                           <option value="XOF82">Guinea-Bissau</option>
                           <option value="GYD83">Guyana</option>
                           <option value="USD84">Haiti</option>
                           <option value="HNL85">Honduras</option>
                           <option value="HUF86">Hungary</option>
                           <option value="ISK87">Iceland</option>
                           <option value="INR88">India</option>
                           <option value="IQD91">Iraq</option>
                           <option value="EUR92">Ireland</option>
                           <option value="ILS93">Israel</option>
                           <option value="EUR94">Italy</option>
                           <option value="JMD95">Jamaica</option>
                           <option value="JPY96">Japan</option>
                           <option value="JOD97">Jordan</option>
                           <option value="KZT98">Kazakhstan</option>
                           <option value="KES99">Kenya</option>
                           <option value="AUD100">Kiribati</option>
                           <option value="KPW101">Korea (North Korea)</option>
                           <option value="KRW102">Korea (South Korea)</option>
                           <option value="KWD103">Kuwait</option>
                           <option value="KGS104">Kyrgyzstan</option>
                           <option value="LAK105">Lao People's Democratic Republic</option>
                           <option value="EUR106">Latvia</option>
                           <option value="LBP107">Lebanon</option>
                           <option value="LSL108">Lesotho</option>
                           <option value="LRD109">Liberia</option>
                           <option value="LYD110">Libya</option>
                           <option value="CHF111">Liechtenstein</option>
                           <option value="EUR112">Lithuania</option>
                           <option value="EUR113">Luxembourg</option>
                           <option value="MWK115">Malawi</option>
                           <option value="MYR116">Malaysia</option>
                           <option value="MVR117">Maldives</option>
                           <option value="XOF118">Mali</option>
                           <option value="USD120">Marshall Islands</option>
                           <option value="EUR121">Martinique</option>
                           <option value="MRO122">Mauritania</option>
                           <option value="MUR123">Mauritius</option>
                           <option value="MXN124">Mexico</option>
                           <option value="USD125">Micronesia, Federated States of</option>
                           <option value="MNT126">Mongolia</option>
                           <option value="EUR127">Montenegro</option>
                           <option value="XCD128">Montserrat</option>
                           <option value="MAD129">Morocco</option>
                           <option value="MMK131">Myanmar</option>
                           <option value="ZAR132">Namibia</option>
                           <option value="AUD133">Nauru</option>
                           <option value="NPR134">Nepal</option>
                           <option value="EUR135">Netherlands</option>
                           <option value="NZD136">New Zealand</option>
                           <option value="NIO137">Nicaragua</option>
                           <option value="XOF138">Niger</option>
                           <option value="NGN139">Nigeria</option>
                           <option value="NZD140">Niue</option>
                           <option value="NOK141">Norway</option>
                           <option value="OMR142">Oman</option>
                           <option value="PKR143">Pakistan</option>
                           <option value="USD144">Palau</option>
                           <option value="USD145">Panama</option>
                           <option value="PGK146">Papua New Guinea</option>
                           <option value="PYG147">Paraguay</option>
                           <option value="PEN148">Peru</option>
                           <option value="PHP149">Philippines</option>
                           <option value="PLN150">Poland</option>
                           <option value="EUR151">Portugal</option>
                           <option value="QAR152">Qatar</option>
                           <option value="EUR153">Réunion</option>
                           <option value="EUR155">Russian Federation</option>
                           <option value="RWF156">Rwanda</option>
                           <option value="SHP157">Saint Helena, Ascension and Tristan da Cunha</option>
                           <option value="XCD158">Saint Kitts and Nevis</option>
                           <option value="XCD159">Saint Lucia</option>
                           <option value="XCD160">Saint Vincent and the Grenadines</option>
                           <option value="WST161">Samoa</option>
                           <option value="SAR163">Saudi Arabia</option>
                           <option value="XOF164">Senegal</option>
                           <option value="SCR166">Seychelles</option>
                           <option value="SLL167">Sierra Leone</option>
                           <option value="SGD168">Singapore</option>
                           <option value="EUR170">Slovenia</option>
                           <option value="SBD171">Solomon Islands</option>
                           <option value="SOS172">Somalia</option>
                           <option value="ZAR173">South Africa</option>
                           <option value="EUR174">Spain</option>
                           <option value="LKR175">Sri Lanka</option>
                           <option value="SDG176">Sudan</option>
                           <option value="SZL178">Swaziland</option>
                           <option value="SEK179">Sweden</option>
                           <option value="CHF180">Switzerland</option>
                           <option value="SYP181">Syrian Arab Republic</option>
                           <option value="TJS182">Tajikistan</option>
                           <option value="THB183">Thailand</option>
                           <option value="USD184">Timor-Leste</option>
                           <option value="XOF185">Togo</option>
                           <option value="TOP186">Tonga</option>
                           <option value="TTD187">Trinidad and Tobago</option>
                           <option value="TND188">Tunisia</option>
                           <option value="TRY189">Turkey</option>
                           <option value="USD191">Turks and Caicos Islands</option>
                           <option value="UGX192">Uganda</option>
                           <option value="UAH193">Ukraine</option>
                           <option value="AED194">United Arab Emirates</option>
                           <option value="USD195">United States</option>
                           <option value="UYU196">Uruguay</option>
                           <option value="UZS197">Uzbekistan</option>
                           <option value="VUV198">Vanuatu</option>
                           <option value="VEF199">Venezuela, Bolivarian Republic of</option>
                           <option value="XPF201">Wallis and Futuna</option>
                           <option value="YER202">Yemen</option>
                           <option value="ZMK203">Zambia</option>
                        </select>
                        @if ($errors->has('currency'))
                        <p class="help-block" style="color:red">{{ $errors->first('currency') }}</p>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="row row-centered">
                  <div class="col-lg-8 col-centered">
                     <h4>Please answer these 6 questions. We promise this information will not be shared without your permission. Do not worry about the options, they may be changed later.</h4>
                     <br>
                     <div class="form-group">
                        <label>
                           How many people in my family are dependent on me for housing, food, education, care and/or money
                           <p style="color:grey;font-size: 80%">(Do not count yourself in this number)</p>
                        </label>
                        <div class="well">
                           <input id="ex1" type="text" class="form-control" name="question1" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="0"/>
                           <span id="ex6CurrentSliderValLabel"><span id="ex1SliderVal">0</span>&nbsp;</span>
                        </div>
                        @if ($errors->has('question1'))
                        <p class="help-block" style="color:red">{{ $errors->first('question1') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>
                           The value of my assets is ...
                           <p style="color:grey;font-size: 80%"> (such as house, bank, car, shares MINUS what I owe)</p>
                        </label>
                        <div class="well">
                           <input id="ex2" type="text" name="question2" class="form-control" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                           <span id="ex6CurrentSliderValLabel"><span id="label"></span>&nbsp; <span id="ex2SliderVal">1</span>&nbsp;</span>
                        </div>
                        @if ($errors->has('question2'))
                        <p class="help-block" style="color:red">{{ $errors->first('question2') }}</p>
                        @endif
                     </div>
                  </div>
                  <div class="col-lg-8 col-centered">
                     <div class="form-group">
                        <label>
                           I take environmentally considerate decisions
                           <p style="color:grey;font-size: 80%"> (for example, about recycling, commuting, travel, home energy consumption, and the origins of my food and clothes)</p>
                        </label>
                        <select id="question3" name="question3" class="form-control">
                           <option selected value="">Please Select</option>
                           <option value="poor">Not really</option>
                           <option value="low">Not always</option>
                           <option value="avg">Generally</option>
                           <option value="good">Mostly</option>
                           <option value="high">Definitely</option>
                        </select>
                        @if ($errors->has('question3'))
                        <p class="help-block" style="color:red">{{ $errors->first('question3') }}</p>
                        @endif
                     </div>
                  </div>
                  <div class="col-lg-8 col-centered">
                     <div class="form-group">
                        <label>
                           In a year how much money do I give to help others?
                           <p style="color:grey;font-size: 80%">(such as donations and sponsoring)</p>
                        </label>
                        <div class="well">
                           <input id="ex4" type="text" name="question4" class="form-control" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                           <span id="ex6CurrentSliderValLabel"><span id="label1"></span>&nbsp;<span id="ex4SliderVal">1</span></span>
                        </div>
                        @if ($errors->has('question4'))
                        <p class="help-block" style="color:red">{{ $errors->first('question4') }}</p>
                        @endif
                     </div>
                  </div>
                  <div class="col-lg-8 col-centered">
                     <div class="form-group">
                        <label>
                           In a year how much money do I  help raise to help others ?
                           <p style="color:grey;font-size: 80%"> (through for example charity runs, charity events, street collections)</p>
                        </label>
                        <div class="well">
                           <input id="ex6" type="text" class="form-control" name="question6"  data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                           <span id="ex6CurrentSliderValLabel"><span id="label2"></span>&nbsp;<span id="ex6SliderVal">1</span></span>
                        </div>
                        @if ($errors->has('question6'))
                        <p class="help-block" style="color:red">{{ $errors->first('question6') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>
                           How many people do I positively influence?
                           <p style="color:grey;font-size: 80%"> (such as through youth groups, community groups, carer role, personal networks, mentoring and coaching)</p>
                        </label>
                        <div class="well">
                           <input id="ex5" type="text" class="form-control" name="question5" data-slider-step="1" data-slider-value="0" data-slider-tooltip="hide"/>
                           <span id="ex6CurrentSliderValLabel"> <span id="ex5SliderVal">1</span>&nbsp;</span>
                        </div>
                        @if ($errors->has('question5'))
                        <p class="help-block" style="color:red">{{ $errors->first('question5') }}</p>
                        @endif
                     </div>
                  </div>
                  <br><br>
                  <h4>Optional </h4>
                  <br>
                  <div class="col-lg-8 col-centered">
                     <div class="form-group">
                        <label>Is my employer seen as a good corporate citizen?</label>
                        <select id="question7" name="question7" class="form-control">
                           <option selected value="null">Please Select</option>
                           <option value="not at all">not at all</option>
                           <option value="not really">not really</option>
                           <option value="not always">not always</option>
                           <option value="generally">generally</option>
                           <option value="mostly">mostly</option>
                           <option value="definitely">definitely</option>
                        </select>
                        @if ($errors->has('question7'))
                        <p class="help-block" style="color:red">{{ $errors->first('question7') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>I am concerned about the ethics of what I buy</label>
                        <select id="question8" name="question8" class="form-control">
                           <option selected value="null">Please Select</option>
                           <option value="not at all">not at all</option>
                           <option value="not really">not really</option>
                           <option value="not always">not always</option>
                           <option value="generally">generally</option>
                           <option value="mostly">mostly</option>
                           <option value="definitely">definitely</option>
                        </select>
                        @if ($errors->has('question8'))
                        <p class="help-block" style="color:red">{{ $errors->first('question8') }}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>
                           As a citizen, I meet my obligations to my community, region and country
                           <p style="color:grey;font-size: 80%"> ( I pay all my taxes, abide by local & central government rules and vote on important issues) </p>
                        </label>
                        <select id="question9" name="question9" class="form-control">
                           <option selected value="null">Please Select</option>
                           <option value="never">never</option>
                           <option value="sometimes">sometimes</option>
                           <option value="generally">generally </option>
                           <option value="mostly">mostly</option>
                           <option value="100% of the time">100% of the time </option>
                        </select>
                        @if ($errors->has('question9'))
                        <p class="help-block" style="color:red">{{ $errors->first('question9') }}</p>
                        @endif
                     </div>
                  </div>
                  <div class="row" align="center">
                     <div class="col-lg-12">
                        <div class="form-group">
                           <button type="submit" class="btn btn-success">Submit Button</button>
                           <a style="color:grey;font-size: 80%" href="{{URL::asset('assets_frontend/pv/images/legal.pdf')}}" target="_blank">(Legal Terms & Conditions)</a>
                        </div>
                        {{ Form::close() }}
                     </div>
                  </div>
               </div>
               <!-- /.box -->
            </div>
            <!--/.col (right) -->
         </div>
         <!-- /.row -->
      </div>
   </section>
   <!-- /.content -->
</div>
<!-- /.right-side -->
@stop
@section('scripts')
<script type="text/javascript">
   function commaSeparateNumber(val){
      while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
      }
      return val;
    }
      $(document).ready(function() {


          /* Question 1 */
          $("#ex1").slider();
          $("#ex1").on('slide', function(slideEvt) {
              $("#ex1SliderVal").html(commaSeparateNumber((slideEvt.value)));
          });
          /* Question 2 */

          $("#ex2").slider({
              min: 1,
              max: 100000000,
              scale: 'logarithmic',
              step: 1
          });
          $("#ex2").on('slide', function(slideEvt) {
              $("#ex2SliderVal").html(commaSeparateNumber((slideEvt.value-((slideEvt.value*20)/100)).toFixed()+" "+ 'to'+" "+(slideEvt.value+((slideEvt.value*20)/100)).toFixed()));


          });
      //Question 3

      $("#ex3").slider();
      $("#ex3").on('slide', function(slideEvt) {
          $("#ex3SliderVal").html(commaSeparateNumber((slideEvt.value-((slideEvt.value*20)/100)).toFixed()+" "+ 'to'+" "+(slideEvt.value+((slideEvt.value*20)/100)).toFixed()));
      });

      $("#ex4").slider({
          min: 1,
          max: 100000000,
          scale: 'logarithmic',
          step: 1
      });
      $("#ex4").on('slide', function(slideEvt) {
          $("#ex4SliderVal").html(commaSeparateNumber((slideEvt.value-((slideEvt.value*20)/100)).toFixed()+" "+ 'to'+" "+(slideEvt.value+((slideEvt.value*20)/100)).toFixed()));
      });

      $("#ex5").slider({
          min: 1,
          max: 100000000,
          scale: 'logarithmic',
          step: 1
      });
      $("#ex5").on('slide', function(slideEvt) {
          $("#ex5SliderVal").html(commaSeparateNumber((slideEvt.value-((slideEvt.value*20)/100)).toFixed()+" "+ 'to'+" "+(slideEvt.value+((slideEvt.value*20)/100)).toFixed()));
      });

      $("#ex6").slider({
          min: 1,
          max: 100000000,
          scale: 'logarithmic',
          step: 1
      });
      $("#ex6").on('slide', function(slideEvt) {
          $("#ex6SliderVal").html(commaSeparateNumber((slideEvt.value-((slideEvt.value*20)/100)).toFixed()+" "+ 'to'+" "+(slideEvt.value+((slideEvt.value*20)/100)).toFixed()));
      });

      $("#ex7").slider();
      $("#ex7").on('slide', function(slideEvt) {
          $("#ex7SliderVal").text(slideEvt.value+'%');
      });

      $("#ex8").slider();
      $("#ex8").on('slide', function(slideEvt) {
          $("#ex8SliderVal").text(slideEvt.value+'%');
      });

      $("#ex9").slider();
      $("#ex9").on('slide', function(slideEvt) {
          $("#ex9SliderVal").text(slideEvt.value+'%');
      });



   });
</script>
<script type="text/javascript">
   function copy() {
       document.getElementById("label").innerHTML=document.getElementById("mySelect").value.substr(0, 3)
       document.getElementById("label1").innerHTML=document.getElementById("mySelect").value.substr(0, 3)
       document.getElementById("label2").innerHTML=document.getElementById("mySelect").value.substr(0, 3)
   }

</script>
<script type="text/javascript">
   function googleTranslateElementInit() {
     new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, gaTrack: true, gaId: 'UA-70095941-1'}, 'google_translate_element');
   }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
@stop
