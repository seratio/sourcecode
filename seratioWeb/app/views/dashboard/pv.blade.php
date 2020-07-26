@extends('layout.dashboard_default')
@section('title')
@parent
@stop
{{ HTML::style('assets_frontend/css/landing-page.css')}}
<style>
   .glyphicon-copy{
   padding: 30px;
   border-radius: 1px;
   color: #381414;
   font-size: 33px;
   }
   .textarea {
   height: 8%;
   width: 70%;
   -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
   -moz-box-sizing: border-box;    /* Firefox, other Gecko */
   box-sizing: border-box;         /* Opera/IE 8+ */
   }
</style>
@section('content')

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Dashboard
      </h1>
      <ol class="breadcrumb">
         <li>
            <div id="google_translate_element"></div>
         </li>
      </ol>
   </section>
   </br>
   <section class="content">
      <div class="row">
         <div class="col-lg-12">
            <p class="description">
               @if (Session::has('message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
               <strong> {{ Session::get('message') }}</strong>
            </div>
            @endif
            </p>
            <!-- Danger box -->
            <div class="box box-solid box-primary">
               <div class="col-lg-12" >
                  <!--Danger box -->
                  <div class="box box-solid box-success">
                     <div class="box-header">
                        <h3 class="box-title">Personal Value</h3>
                     </div>
                     <div class="box">
                        <div class="box-body">
                           <div id="widget">
                              <div class="value_bg" align="center" style="overflow:hidden;">
                                 <div class="corners1" style="overflow:hidden;">
                                    <div class="value_text" style="overflow:hidden;">{{round($avg,2)}}
                                    </div>
                                 </div>
                              </div>
                              <p style="font-size:125%" align="center"><a href="www.seratio.com">www.seratio.com</a></p>
                              <p style="font-size:125%" align="center"> {{ Auth::user()->lastname}} {{Auth::user()->firstname}}</p>
                              <p style="font-size:125%" align="center">{{ $updated_at }}</p>
                           </div>
                           <p style="font-size:80%" align="center"> The ratio is how much social value you create compared to your financial value</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     <!--Danger box -->
                     <div class="box box-solid box-danger">
                        <div class="box-header">
                           <h3 class="box-title">Comparisons</h3>
                        </div>
                        <div class="box">
                           <div class="box-body" align="center">
                              <div id="chart_div"></div>
                              <span align="center">"This is your score relative to others"</span>
                           </div>
                        </div>
                     </div>
                     <!-- /.box-body -->
                  </div>
                  <div class="col-xs-6">
                     <div class="box box-solid box-info">
                        <div class="box-header">
                           <h3 class="box-title">Positive Feedback</h3>
                        </div>
                        <div class="box">
                           <div class="box-body" align="center">
                              <div id="chart_div_avg"></div>
                           </div>
                        </div>
                     </div>
                     <!-- /.box -->
                  </div>
                  <div class="col-xs-6">
                     <div class="box box-solid box-primary">
                        <div class="box-header">
                           <h3 class="box-title">Feedbacks</h3>
                        </div>
                        <div class="box">
                           <div class="box-body">
                              <div class="small-box bg-yellow">
                                 <div class="inner">
                                    <h3>{{$count ? $count : 0}}</h3>
                                    @if($count > 1)
                                    <p>feedbacks received</p>
                                    @else
                                    <p>feedback received</p>
                                    @endif
                                 </div>
                                 <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /.box -->
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     <div class="box box-solid box-success">
                        <div class="box-header">
                           <h3 class="box-title">Please validate your PV by reaching out to your networks, copy the text below to your friends or do it via social media. For social media, please click copy first and then paste it on the respective social media.</h3>
                        </div>
                        <div class="box">
                           <div class="box-body" align="center">
                              <textarea class="textarea">{{ Auth::user()->firstname }} wants you to help measure @if($gender == 'Male')his @elseif($gender == 'Female')her @endif Personal Value – your 30 sec feedback could help @if($gender == 'Male')him @elseif($gender == 'Female')her @endif {{$shorturl}}
                      </textarea>
                              <div class="box-body">
                                 <div class="text-center">
                                    <button class="button">Copy</button>
                                    <a class="btn btn-social-icon btn-facebook" href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook"></i></a>
                                    <a class="btn btn-social-icon btn-google" href="https://plus.google.com/" target="_blank"><i class="fa fa-google-plus"></i></a>
                                    <a class="btn btn-social-icon btn-linkedin" href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin"></i></a>
                                    <a class="btn btn-social-icon btn-twitter" href="https://twitter.com/" target="_blank"><i class="fa fa-twitter"></i></a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- /.box -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- /.right-side -->
</div>
<!-- add new calendar event modal -->
@stop
@section('scripts')
<script type="text/javascript">
   $(document).ready(function() {
     var $btnSets = $('#responsive'),
     $btnLinks = $btnSets.find('a');

     $btnLinks.click(function(e) {
       e.preventDefault();
       $(this).siblings('a.active').removeClass("active");
       $(this).addClass("active");
       var index = $(this).index();
       $("div.user-menu>div.user-menu-content").removeClass("active");
       $("div.user-menu>div.user-menu-content").eq(index).addClass("active");
     });
   });

   $(".button").on("click",function(){
     var copyTextarea = document.querySelector('.textarea');
     copyTextarea.select();
     try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Copying text command was ' + msg);
    } catch (err) {
      console.log('Oops, unable to copy');
    }
   });


   $( document ).ready(function() {
     $("[rel='tooltip']").tooltip();

     $('.view').hover(
       function(){
             $(this).find('.caption').slideDown(250); //.fadeIn(250)
           },
           function(){
             $(this).find('.caption').slideUp(250); //.fadeOut(205)
           }
           );
   });
</script>
<script type="text/javascript">
   google.load("visualization", "1", {packages:["gauge"]});
   google.setOnLoadCallback(drawChart);
   google.setOnLoadCallback(drawChartavg);
   function drawChart() {

     var data = google.visualization.arrayToDataTable([
       ['Label', 'Value'],
       ['Benchmarking', {{round($perc,2)}}]
       ]);

     var options = {
       minorTicks: 5
     };

     var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

     chart.draw(data, options);


   }

   function drawChartavg() {

     var data = google.visualization.arrayToDataTable([
       ['Label', 'Value'],
       ['Sentiment', {{round($avg_pos,2)}}]
       ]);

     var options = {
       minorTicks: 5
     };

     var chart = new google.visualization.Gauge(document.getElementById('chart_div_avg'));

     chart.draw(data, options);


   }
</script>
<script type="text/javascript">
   function googleTranslateElementInit() {
     new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL, gaTrack: true, gaId: 'UA-70095941-1'}, 'google_translate_element');
   }
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script type="text/javascript">
   $('#btnSave').click(function(){
    html2canvas($('#widget'),
    {
      onrendered: function (canvas) {
        var a = document.createElement('a');
        // toDataURL defaults to png, so we need to request a jpeg, then convert for file download.
        a.href = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
        a.download = 'pv.png';
        a.click();
      }
    });
   });

</script>
@stop
