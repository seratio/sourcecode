<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="google-site-verification" content="VisTkJwqSJexIZirImYPSzgsinPUdwOYUeO6ssmHLMA" />
	<title>
		seratio®::Our Team
	</title>

	<link href='https://fonts.googleapis.com/css?family=Roboto:300,700' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="{{{ asset('new_assets/images/logo.png') }}}">
	{{ HTML::style('new_assets/css/bootstrap.css')}}
	<!-- Bootstrap core CSS -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<!-- Custom styles for this template -->
	<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css">-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	{{ HTML::script('assets_frontend/js/jquery-2.1.1.min.js')}}
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	{{ HTML::style('new_assets/css/demo.css')}}

	{{ HTML::style('new_assets/css/effect1.css')}}

	{{ HTML::script('new_assets/js/modernizr.custom.js')}}

	{{ HTML::style('new_assets/css/custom-styles.css')}}

	{{ HTML::style('assets_frontend/css/jquery.cookiebar.css')}}
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-71812286-1', 'auto');
		ga('send', 'pageview');

	</script>
</head>

<!-- ==================================== -->

<body>
	<!-- initial header -->
	<!-- top bar -->
	<!-- main content -->
	<div class="all-wrap pagewrap" id="pagewrap">
		<div class="containerr show" id="page-1">
			<div class="socialmedia">
				<a href="{{URL::to('https://www.facebook.com/TheCCEG')}}" target="_blank" class="facebook"></a>
				<a href="{{URL::to('https://plus.google.com/+CcegOrgUk/')}}" target="_blank" class="googlep"></a>
				<a href="{{URL::to('https://www.linkedin.com/company/centre-for-citizenship-enterprise-and-governance')}}" target="_blank" class="linkedin"></a>
				<a href="{{URL::to('https://www.youtube.com/user/TheCCEG')}}" target="_blank" class="youtube"></a>
				<!--<a href="{{URL::to('https://twitter.com/theCCEG')}}" target="_blank" class="twitter"></a>-->
				<a href="{{URL::to('http://theseratio.tumblr.com')}}" class="tumb" target="_blank"></a>
				<a href="{{URL::to('https://instagram.com/theseratio')}}" class="instagram" target="_blank"></a>
				<a href="{{URL::to('http://thecceg.blogspot.co.uk/')}}" class="blog" target="_blank"></a>
				<a href="{{URL::to('https://www.seratio.org')}}" class="edu" target="_blank"></a>
			</div>
			<div class="outer-wrapper">
				<div class="container">
					<div class="row">
						@if (Session::has('message'))
						<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong> {{ Session::get('message') }}</strong>
						</div>
						@endif
						@if($errors->has())
						@foreach ($errors->all() as $error)
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong> {{ $error }}</strong>
						</div>
						@endforeach
						@endif
						<!--first row-->
						<div class="col-md-12">
							<div class="logo-wrapper">
								<a href="{{URL::to('http://seratio.com')}}">{{ HTML::image('new_assets/images/logo.png', 'Seratio') }}</a>
								<h2>Meet Our Team</h2>
							</div>
						</div>
						<!--first row-->
						<!--3rd row-->
						<div class="col-md-3">&nbsp;</div>
						<div class="col-md-2">

							<div class="clearfix"></div>
						</div>
						<div class="col-md-12 inner-content">
							<h3> Directors</h3>
							<!-- <div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#barbara">
									{{ HTML::image('assets_frontend/images/team/barbara.png', 'Barbera', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Barbara Mellish MBA, MIRM, ACIB - CEO</h4>
							</div> -->

							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#olinga">{{ HTML::image('assets_frontend/images/team/olinga.png', 'Olinga', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Professor Olinga Ta’eed PhD FIoD - Chairman</h4>
							</div>
						</div>

						<div class="col-md-12 inner-content">
							<h3> Team</h3>

							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#joanne">{{ HTML::image('assets_frontend/images/team/joanne.png', 'Joanne', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Joanne Evans MBA - Project Manager</h4>
							</div>

							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#sajin">{{ HTML::image('assets_frontend/images/team/sajin.png', 'Sajin', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Sajin Abdu B Tech, MBA - Head of Technology</h4>
							</div>

							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#tiggy">{{ HTML::image('assets_frontend/images/team/tiggy.png', 'Tigiris', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Tigris Ta’eed - Chief Disruption Officer</h4>
							</div>

							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#phil">{{ HTML::image('assets_frontend/images/team/phil.png', 'Phil', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Phil Renshaw MCT, ACIB, PGCHE - Research Analyst</h4>
							</div>
							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#marym">{{ HTML::image('assets_frontend/images/team/marym.png', 'Maryam', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Maryam Taghiyeva - Research Analyst</h4>
							</div>

							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#christine">{{ HTML::image('assets_frontend/images/team/christine.png', 'Christine', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Christine Bamford</h4>
							</div>

							<div class="col-lg-3 profile text-center">
								<a href="#aboutModal" data-toggle="modal" data-target="#dinh">{{ HTML::image('assets_frontend/images/team/dinh.png', 'Dinh', ['class' => 'img-circle', 'width' => '140']) }}
								</a>
								<h4>Dinh Ho Nho Thong</h4>
							</div>







						</div>
					</div>
				</div>

				<footer>
					<p><a class="pageload-link" href="#about">About</a> | <a class="pageload-link" href="#citizenship">Citizenship</a> | <a  class="pageload-link" href="#seratio">S/E Ratio</a> |
						<a href="https://www.seratio.org/home" target="_blank">MOOC</a> |
						<a href="http://ow.ly/LN0zX" target="_blank">Review</a> |
						<a class="pageload-link" href="#benchmark">Benchmark</a> |
						<a class="pageload-link" href="#partners">Partners</a>|
						<a href="{{URL::route('sessions.login')}}">My Account</a> |
						<a href="{{URL::route('frontend.team')}}">Our Team</a> |
						<a href="#">Support</a> |
						<a href="#">Legal</a> |
						<a href="#">News</a> |
						<a class="pageload-link" href="#contact">Contact</a>
					</p>
					<p>© 2020 seratio®  All rights reserved Beta Version 1.4</p>
				</footer>
			</div>

			<div id="loader" class="pageload-overlay" data-opening="m -10,-10 0,80 100,0 0,-80 z m 50,-30.5 0,70.5 0,70 0,-70 z">
				<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="none" >
					<path d="m -10,-10 0,80 100,0 0,-80 z M 40,-40.5 120,30 40,100 -40,30 z"></path>
				</svg>
			</div><!-- /pageload-overlay -->

		</div>

		<!-- Barbara Bio -->
		<!-- <div class="modal fade" id="barbara" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Barbara</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/barbara.png', 'Barbera', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Barbara Mellish <small>MBA, MIRM, ACIB - CEO</small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								An experienced Director, Non-Exec and Advisor to Blue-Chip and private companies, public sector organisations and third sector businesses.
								Barbara’s commercial acumen has been built from a successful career within financial services, specialising in risk management, corporate governance and compliance, including board appointments at Barclaycard and European boards and representation for the global brands of MasterCard and Visa.
								Her private sector discipline and experience has been blended with executive roles in the not-for profit and public sectors. The most recent role being the Director of Payments Integrity and Security at the Payments Council which had responsibility for the reliability and cyber resilience of the UK’s banking payments systems.
								Barbara has two teenage children and is a keen traveller, scuba diver & adrenalin sports fan..
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Barbara Bio --> -->

		<!-- Olinga Bio -->
		<div class="modal fade" id="olinga" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Olinga</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/olinga.png', 'Olinga', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Professor Olinga Ta’eed  <small>PhD FIoD - Chairman</small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								Olinga is Director of the Centre for Citizenship, Enterprise and Governance and attributed with the creation of the Social Earnings Ratio (S/E). He is Professor of Social Enterprise at  University of Northampton, Visiting Professor in Capacity Development at Birmingham City University, Chair of EU SEiSMiC Social Value and Chair of EU PROCUREMENT Social Value & Transparency in Supply Chains. He is Executive Editor of Social Value & Intangibles Review.
								Olinga retired from a successful private sector career at the age of 48 as “entrepreneur, investor, and social activist”. In the last 7 years he has developed his role of a carer including for emergency fostering on his small holding in Wales and he remains a registered adopter. He has homes in the UK and Italy.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Olinga Bio -->

		<!-- Sajin Bio -->
		<div class="modal fade" id="sajin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Sajin</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/sajin.png', 'Sajin', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Sajin Abdu <small>B-Tech, MBA - Head of Technology</small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								A dedicated professional with over five years of combined experience as a software developer, marketing supervisor and PMO in blue chip and private companies. His most recent role being the PMO of Tata Consultancy Services which had responsibility for project commercial management, Internal audits facilitator and presales proposals creation and estimation. Sajin is a qualified electronics and communications engineer and has completed his Master of Business Administration from University of Northampton.
								He enjoys keeping up-to-date with the latest advances in technology and have remained amazed at the speed of computerised developments over the past few years. He is an avid traveller and enjoys music and good food.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Sajin Bio -->


		<!-- Joanne Bio -->
		<div class="modal fade" id="joanne" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Joanne</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/joanne.png', 'Joanne', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Joanne Evans <small>MBA - Project Manager</small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								An experienced manager, change maker and social value specialist.
								Joannes commercial and social value experience has developed through a career within the retail
								industry; a trouble shooter and change maker to one of the UKs leading retailers.  Specialising in
								Corporate Social Responsibility and marketing through Stakeholder engagement and sentiment;
								initiating bottom up change through management programme involving childrens associations,
								inspiring change and sponsorship, impacting on 400,000 children each year.
								Her experience in CSR and change was infused through her training at The Centre of Citizenship and
								Governance; specialising in the articulation of CSR contributions and the increase of the social value
								and market capital of companies.  Her most recent position; driving sentiment from the front line,
								responsible for the training and development of colleagues, customer retention and sales increase.
								Joanne is married and has 3 step-daughters, 5 cats and 2 rabbits.  Her interests include Classic VW
								Beetles, hand crafted arts, running, Reiki and veganism.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Joanne Bio -->

		<!-- Tigiris Bio -->
		<div class="modal fade" id="tiggy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Tigris </h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/tiggy.png', 'Tigiris', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Tigris Ta’eed  <small>Chief Disruption Officer</small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								Tigris is an artist, story writer and poet. She is a graduate in Fine Art from Reading University, and has been an art teacher for Primo Balleto dance school,
								where the children choreographed their pieces from ballet, hip hop and musical theatre styles, as well as voluntary youth work with delinquent teenagers,
								arming them with an artistic outlet and distraction from alcohol and drugs.
								She was also a researcher and runner for Resistance Ltd, a company who made the Nazi movie of the same name.
								Tigris is a freedom fighter and cyberpunk online, having worked with Amnesty International human rights organisation,
								petitioning against the introduction of CCTV and ID cards. Tigris, nickname Tiggy or Trip,
								is passionate and experienced in music and film, and was a part of the fantasy, science fiction and horror
								subculture when living in Cambridge. She loves dancing at psy trance and drum’n’bass raves, festivals and gigs,
								the pleasure of theatre and reading, with a fire for the occult, keeping a blog online where she expresses
								her spiritual beliefs as a psychedelic chaos magician.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Tigiris Bio -->

		<!-- Phil Bio -->
		<div class="modal fade" id="phil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Phil</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/phil.png', 'Phil', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Phil Renshaw <small>MCT, ACIB, PGCHE - Research Analyst</small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								Phil believes that maximising success for anyone requires an understanding of both value and
								leadership – if you know the value of something and the people around you, success is yours for the
								taking. Phil has a senior business leadership background as a banker, corporate financier, and a Finance
								Director. He’s lived in London, New York and Sydney. Six years ago he become a professional coach
								specialising in international assignments. He is fascinated by these assignments and the inability of
								organisations to value them. His expertise has prompted him to start a PhD at Cranfield University in
								the organisational value of international assignments. Phil is married to Alison. They love trips out in their VW campervan and are currently in the market
								for both a cat and a dog.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Phil Bio -->

			<!-- Marym Bio -->
		<div class="modal fade" id="marym" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Maryam</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/marym.png', 'Maryam', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Maryam Taghiyeva  <small>Development Analyst</small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								Maryam Taghiyeva joined CCEG in December 2015 as Development Analyst. Taghiyeva received Bachelor degree in Applied Mathematics from Baku State University and  Master’s degree in International Relations from University of Warwick. Taghiyeva has experience in working with different governmental institutions, UN, European Commission’s youth programmes and NATO.  She also represented Azerbaijan and spoke in a number of international and national events, such as Intergovernmental Youth Exchange Programme in the Republic of South Korea. Taghiyeva is also co-author of two patents in banking. Her main area of interest is interdisciplinarity, appliance of mathematical methods into social sciences in particular.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Marym Bio -->

		<!-- Christine Bio -->
		<div class="modal fade" id="christine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Christine</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/christine.png', 'Maryam', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Christine Bamford <small></small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								Christine carries an extensive portfolio of clients and assignments.  Her clients include top leaders from Government, Education, Health, Voluntary sector as well as Sports and Recreation.   Her area of expertise focuses around Leadership/talent; Organisational Change and Mergers and Top Team coaching.  As a Consultant with KPMG she undertakes the role of Cohort Director for NHS Senior Leaders Programme – NHS Leadership Academy.  Christine has co-created, with the Cabinet Office and Microsoft Corp a business exchange development experience for High Potential Director General.  She is currently working with SRA (Minister of Sport and Culture) and  CID/UNESCO on a World Congress on the impact of movement on health and wellbeing
								Christine is Visiting Professor, University of Northampton Lecturing to MBA/DBA students on Leadership, Innovation and Strategy.  She is Advisor to CCEG/Seratio on Leadership and Health and Wellbeing. She has a track record of delivering change in Government and NHS Holding the post of Director of OD in Welsh Government and National Leadership and Innovation Agency for Healthcare. As part of her international portfolio, Christine acted as World Health Organisation Consultant Adviser to the Minister of Health in the United Arab Emirates, where she received a Royal Audience in recognition of the work undertaken. Christine has been a regular speaker at UK and International conferences. She has studied Strategic Human Resources at the Executive Business School, Stanford University, California and Harvard School of Public Health, Boston.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Christine Bio -->

			<!-- Dinh Bio -->
		<div class="modal fade" id="dinh" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myModalLabel" style="color:black;">More About Dinh</h4>
					</div>
					<div class="modal-body">
						<center>
							{{ HTML::image('assets_frontend/images/team/dinh.png', 'Dinh Ho Nho Thong', ['class' => 'img-circle', 'width' => '140']) }}
							<h3 class="media-heading" style="color:black;">Dinh Ho Nho Thong <small></small></h3>
						</center>
						<hr>
						<center>
							<p align="justify" style="color:black;"><strong>Bio: </strong><br>
								Dinh Ho Nho Thong joined CCEG in November 2016 as a Development Analyst. Dinh received his Bachelor degree in Economics from Vietnam National University. Now he is doing his Master’s degree in Financial Analysis in the University of Northampton. Dinh has worked within IT industry, financial technology and e-commercial sectors. Dinh is also a co-author of two papers in development economics and has been awarded with a scholarship to do his master course. His main area of interest is the appliance of econometrics in predicting and analysis development for both social institutions and business.
							</p>
							<br>
						</center>
					</div>
					<div class="modal-footer">
						<center>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</center>
					</div>
				</div>
			</div>
		</div><!-- /Dinh Bio -->


		<!-- Start About Us Section -->
		<div class="containerr" id="about">
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>About Us</span></h2>
							<br>
							<p align="center">At S/Eratio (“seratio”) we are not a consultancy, rating agency or ‘special advisors’ – instead we focus upon turning the intangible measurements that you have always wondered about into something very real and applicable to you.  <br></br>
								Our sole objective of being able to turn intangible outcomes in real, verifiable and accurate measurements. We do this using the very latest in academic knowledge which combines social science, outcome metrics, data mining and sentiment analysis.  The logical outcome is an elite set of supermetrics which are constructed using sentiment analysis, geo-located with future proof analytical technology reinforced with the latest big data mining and machine learning technology.<br></br>
								Who do we serve? You - the citizens of the world – and we believe in multi-stakeholder engagement translated onto a citizenship map. <br></br>
								We aim to inform and empower  those responsible for making the decisions which ultimately have a positive or negative impact upon the world and all of those who aim to make a difference.  These people are not just those in executive boards of major corporations, those who reside in positions of power in government, but you, a consumer, a citizen of the world.  We focus upon informing the societies of the world<br></br>
								We believe that after decades of so called change agents trying to pioneer models of transformation from the top down – there now needs to be accurate measurements, provided by an elite, non-partisan entity which delivers the truth into the hands of the people. <br></br>
							</p>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12" align="center">
							<div class="custom-tab">
								<ul class="nav nav-tabs nav-justified" role="tablist">
									<li class="active"><a href="#tab-1" role="tab" data-toggle="tab" style="color:black;">Thought Leadership </a></li>
									<li><a href="#tab-2" role="tab" data-toggle="tab" style="color:black;">Total Value</a></li>
									<li><a href="#tab-3" role="tab" data-toggle="tab" style="color:black;">Social Earnings Ratio</a></li>
									<li><a href="#tab-6" role="tab" data-toggle="tab" style="color:black;">Milestones</a></li>
								</ul>

								<div class="tab-content">

									<div class="tab-pane active" id="tab-1">
										<br>
										<p>Seratio have devised the most relevant, scalable and accurate metric for measuring social value. For decades many have tried to make sense of what has been until now truly intangible – devising “measurements” that simply fail to take consideration the “real effects” into account. Thus far such measurements and metrics have been poorly adopted, subject to bias, too specific, not automated in any way and untranslatable. We aimed to put an end to the rather fuzzy world of social impact and social innovation and imbed it into scientific methods which can implement true change.</p>
										<p>During the previous financial crisis we were issued with the challenge of measuring more scientifically and accurately the real-time contributions corporate entities and indeed individuals make to the world around them. The Social to Earning Ratio devised by Seratio measures your impact beyond just the marketplace, showing you in hard numbers the efficiency of your social spend, in much the same way the standard P/E Ratio (Price to Earnings) measures the earnings of your company against costs.</p>
										<p>Indeed, we passionately believe that the current methodologies for measuring impact upon societies, the earth and institutions are out dated and no longer reflect the reality of what those inputs become in terms of impacts upon the grass roots or indeed intended targets. Most modern metrics also fail to utilize the huge technological advances that have occurred in the 21st century thus far. We focus on devising methodologies that are not designed to make corporations look good, but instead help the observer attain an accurate depiction of what really happens on the ground. </p>
									</div>

									<div class="tab-pane" id="tab-2">
										<br>
										<p>WHEN THE FACTS ARE OUT IN THE OPEN – WE ALL BENEFIT, IT’S JUST HOW LIFE IS MEANT TO BE.</p>
										<p>The emphasis on pure financial value and outcomes no longer reflects reality in an ever changing world – we believe  in the new economy the true value of a brand or corporate entity  is now a combination of its Financial Value (P/E) and it’s Social Value (S/E).</p>
										<p>There has to date been a systematic failure which we aim to address using our expertise in intangible measurement and analysis, big data mining and qualitative data analysis – to create metrics which systematically and consistently can measure the direct ramifications of our actions, or non-actions. </p>

									</div>

									<div class="tab-pane" id="tab-3">
										<br>
										<p>Within the financial world, the Price/Earnings Ratio (P/E Ratio or PER) is the main single index evaluation technique of economic performance and health check. Used throughout the world, and reported daily on stock exchanges, it has become the universally adopted tool. In rough terms, the P/E measures the capitalization of a company (what it's worth) against the amount of profit it generates. We have developed the corollary to the P/E, the S/E Ratio (SER) which measures the Social Impact of an organisation against the monies invested to achieve it (the earnings diverted which otherwise would be profit).</p>

										<p>A share price is a relatively weak artefact representing degrees of alignment between shareholders and the organisations. It is subject to numerous reported and unmeasured biases which mean it cannot in isolation reflect the true “value” of the corporate entity. Generally only the shareholders and management benefit, and all others are a slave to that goal. Using human dynamic and descriptive analytics we have devised academically rigorous and peer reviewed methodologies which extend beyond these simple financial metrics.</p>

										<p>Think of yourself as a operator within a ever changing environment, the impacts you make upon the world around you will change constantly as the environment evolves. Your impact as a human being is not simply a constituent of your productivity or ability to make money.</p>
										<p>The social impact interpretation is that of citizenship, that the total value of an organisation is a total of the financial and social values. Taking social value, one has to measure the stakeholder value of customers, suppliers, staff, statutory bodies, community and the environment. </p>
										<p>Independently commissioned, the methodology has been developed by the Centre for Citizenship, Enterprise and Governance (cceg.org.uk) and its affiliated network of 30+ International Universities and Research Institutes to ensure honesty and integrity in the reporting process.</p>

										<p>Seratio reports in future proof XBRL format, using the latest GRI-4 template (Global Reporting Initiative) and is compliant with IIRC (The International Integrated Reporting Council).</p>

									</div>

									<div class="tab-pane" id="tab-6">
										<br>

										<ol align="left">
											<li><a href="{{URL::to('https://procurement-forum.eu/')}}" target="_blank" style="color:red;">January 2015 – chair EU Procurement group “Social Value and Transparency in Supply Chains”</a></li>

											<li><a href="#" target="_blank" style="color:red;">December 2014 - commissioned to produce UK Modern Slavery Act 2014 metric</a></li>

											<li><a href="{{URL::to('http://www.seismicproject.eu/')}}" target="_blank" style="color:red;">November 2014 - appointed Chair of EU SEiSMiC Social Value across 10 countries</a></li>

											<li><a href="{{URL::to('http://www.theinformationdaily.com/2014/11/19/answertime01')}}" target="_blank" style="color:red;">November 2014 – video Question Time with Hazel Blears MP and Prof Ta’eed</a></li>

											<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-professor-takes-part-in-a-panel-alongside-hazel-blears-mp-to-discuss-the-concept-of-social-value')}}" target="_blank" style="color:red;">November 2014 – deliver our S/E social impact report for Loomba Foundation to Bombay Stock Exchange members by Dr Vince Cable MP, Business Secretary of State</a></li>

											<li><a href="{{URL::to('https://www.youtube.com/watch?v=WAyPxiWbOoc')}}" target="_blank" style="color:red;">October 2014 - release of national interviews on Social Value</a></li>

											<li><a href="{{URL::to('https://www.youtube.com/watch?v=lbw_GKy8cow&feature=youtu.be')}}" target="_blank" style="color:red;">October 2014 - release of national interviews on Social Value</a></li>

											<li><a href="{{URL::to('https://drive.google.com/folderview?id=0B51i5nTXo9qtV1ROTDk5QWR5cUk&usp=sharing')}}" target="_blank" style="color:red;">September 2014 - commissioned to launch 250 page "Social Value in Public Procurement" bible</a></li>

											<li><a href="{{URL::to('https://www.dropbox.com/sh/8zzxr4al853cdqe/AAAKDjiCwclOj6DLW5sc3toCa?dl=0')}}" target="_blank" style="color:red;">September 2014 - commissioned to launch 250 page "Social Value in Public Procurement" bible</a></li>

											<li><a href="{{URL::to('http://www.socialvalueportal.com/')}}" target="_blank" style="color:red;">September 2014 - commissioned to produce Social Value Portal with Hazel Blears MP</a></li>

											<li><a href="{{URL::to('http://www.zenit.org/en/articles/olinga-ta-eed-on-link-between-profit-motive-and-reduction-of-poverty')}}" target="_blank" style="color:red;">June 2014 - Speech to The Pope at The Vatican</a></li>

											<li><a href="{{URL::to('http://www.northampton.ac.uk/news/professor-olinga-ta-eed-hosts-united-nations-international-widows-day-at-the-house-of-lords')}}" target="_blank" style="color:red;">June 2014 - 100 Indian CEO's attend House of Lords conference chaired by Prof Ta'eed</a></li>

											<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-receives-unprecedented-feedback-for-inspirational-speech-at-institute-of-financial-services-event')}}" target="_blank" style="color:red;">May 2014 - Annual Institute of Financial Service Lecture</a></li>

											<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-collaborates-with-the-loomba-foundation-to-empower-245-million-widows')}}" target="_blank" style="color:red;">November 2013 - 450 attended London Guildhall event chaired by Prof Ta'eed including Deputy Prime Minister Nick Clegg, former First Lady Cherie Blair, Treasury Minister Danny Alexander</a></li>

											<li><a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - Brandanomics</a></li>

											<li><a href="{{URL::to('http://sii2000.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - SI2000</a></li>

											<li><a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - Cultiv8 Solutions</a></li>

											<li><a href="{{URL::to('http://bigredsquare.com/')}}" target="_blank" style="color:red;">October 2013 - launch licensees using automated platform - Big Red Square</a></li>

											<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-urges-individuals-worth-100-billion-collectively-to-consider-global-enterprise')}}" target="_blank" style="color:red;">June 2013 - US$ 100 billion HNWI attend The Dorchester, London, chaired by Prof Ta'eed including Lakshmi Mittal (US$ 16 b), Hinduja Brothers (US$ 17 b)</a></li>

											<li><a href="#" target="_blank" style="color:red;">January 208-Q1 2013 - wiki university approach on S/E amongst c. 30 universities</a></li>

											<li><a href="#" target="_blank" style="color:red;">November 2011 - commissioned by UK Government's 'Big Society' to develop universal social impact metric </a></li>
										</ol>
									</div>
								</div><!-- /.tab-content -->
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- End About Us Section -->

		<!-- Start Citizenship Section -->
		<div class="containerr" id="citizenship">
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Citizenship Map</span></h2>
							<br>
							<p> The Social Earnings Ratio (S/E) is built on our current understanding of organisational structure - the multistakeholder environment, often called a Citizenship Map.
								We have also developed a range of S/E prodigy metrics to reflect Total Value.
							</p>
						</div>
					</div>
					<br>
					<div class="container">
						<div class="row">
							<div class="section-title text-center">
								<h2><span>Key</span></h2>
								<br>
								<div class="list-group column">
									<h4 class ="list-group col-lg-6">1.Capitilization</h4>
									<h4 class="list-group col-lg-6">5.CO2</h4>
									<h4 class="list-group col-lg-6">2.Social Value</h4>
									<h4 class="list-group col-lg-6">6.Transparency in Supply Chains</h4>
									<h4 class="list-group col-lg-6">3.Pay Disparity</h4>
									<h4 class="list-group col-lg-6">7.Personal(Citizen) Value </h4>
									<h4 class="list-group col-lg-6">4.Tax Avoidance</h4>
								</div>
							</div>
						</div>
					</div>

					<div class="container">
						<div class="row">
							<div class="section-title text-center">

							</br>
							<img src="https://www.seratio.com/assets_frontend/images/citizen.png" width="600" height="600" alt="">
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- End Citizenship Section -->


		<!-- Start S/E Ratio Section -->
		<div class="containerr" id="seratio">
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>S/E Ratio</span></h2>
							<br>
							<p align="center">The Social to Earnings ratio (S/E) behaves as a grandfather
								metric – the corollary to the P/E ratio used in the financial
								world. We give you a more powerful way to support or
								augment trading strategies and generate new ideas by giving
								you new views of the market from both a financial context
								and a “everything else” context, principally social impact, the
								morality of interactions inside and outside the organisation.
								Having said this, we are a neutral metric – we make no
								judgement on ethics – we simply objectively report them as we
								find them and cannot ‘influence’ any figures. <br></br>
								We harness the full breadth and depth of information in
								the SOCIAL IMPACT MARKETPLACE to create visualizations
								that uncover key insights, translate any index or metric into
								a comprehensive set of measurements that we generate
								specifically for you. The S/E metric can be applied to whole
								organisations, projects and processes across public, private,
								third and community sectors. <br></br> </p>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12" align="center">
								<div class="custom-tab">
									<ul class="nav nav-tabs nav-justified" role="tablist">
										<li class="active"><a href="#tab-4" role="tab" data-toggle="tab" style="color:black;">INTEGRATION MATTERS</a></li>
										<li><a href="#tab-5" role="tab" data-toggle="tab" style="color:black;">CUSTOMISATION, COLLABORATION, FORECASTING</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab-4">
											<br>
											<p>
												Our charting integrates the entire scope of social data,
												supplemented with the most robust financial APIs to create a
												holistic platform allowing you to create charts that consolidate
												all relevant information. This means you can quickly validate
												ideas, watch trends and generate value. Only on Seratio’s
												platforms can you plot multiple instruments across every social
												and financial asset class. Compare company fundamentals,
												ratios and estimates with other companies, commodities,
												currencies and economic data, then create composites for a
												more comprehensive view of the market.<br>
												Draw from almost 400 technical studies and indicators, both
												in the financial and social world – with the ability to translate
												any including those from well-known third-party contributors.
												We help you incorporate news headlines and market-moving
												events and indicators as diverse as economic cycles, energy
												and agricultural. You can incorporate your own company data
												or upload your firm’s custom content, comparing suppliers,
												competitors or even host organisations with whom you wish to
												make strategic partnerships with.</p>
											</div>

											<div class="tab-pane" id="tab-5">
												<br>
												<p>
													Charting on our platform is powerful and customisable, with
													numerous pre-packaged applications and shortcuts that allow
													you to jump quickly to charts and studies important to you.
													Start with a template, and then choose from a vast array of
													customization tools to configure data and associated alerts.
													Create your own view of the markets with our annotations
													palette. You’re always ready to present ideas, with a few
													clicks all it takes to export charts into presentations with all
													annotations included.<br>
													Communication and collaboration using charts is simple.
													You can share and co-edit charts with clients and colleagues
													throughout the community, in real time, through our reorting
													engine. Compare ideas and build a common point of view.<br>
													Design your own custom studies and share with colleagues and
													clients to generate profitable trade ideas. Use our forecasting
													tool to play out thousands of scenarios from a wide array
													of benchmarks to determine strategies and optimization
													techniques most profitable over time
												</p>
											</div>

											<div class="section-title text-center">
												<h2><span>Information</span></h2>
											</div>
										</br>
										<div class="container">
											<div class="row">
												<div class="col-md-3 col-sm-6">
													<div class="pricing-table">
														<div class="plan-name">
															<h3>The Vatican</h3>
														</div>

														<div class="plan-list">
															<ol align="left">
																<li><a href="{{URL::to('http://www.zenit.org/en/articles/the-vatican-has-long-promoted-intangible-values-can-they-be-measured')}}" target="_blank" style="color:red;">Zenit (5th January 2015)</a></li>
																<li><a href="{{URL::to('http://www.zenit.org/en/articles/olinga-ta-eed-on-link-between-profit-motive-and-reduction-of-poverty')}}" target="_blank" style="color:red;">Interview (1st July 2014)</a></li>
																<li><a href="{{URL::to('http://ow.ly/BgAwB')}}" target="_blank" style="color:red;">Vatican Speech Video</a></li>
															</ol>
														</div>
													</div>
												</div>

												<div class="col-md-3 col-sm-6">
													<div class="pricing-table">
														<div class="plan-name">
															<h3>Networks</h3>
														</div>

														<div class="plan-list">
															<ol align="left">
																<li><a href="{{URL::to('http://ow.ly/Gpu7N')}}" target="_blank" style="color:red;">EU SEiSMiC Social Value</a></li>
																<li><a href="{{URL::to('http://ow.ly/Hi4sd')}}" target="_blank" style="color:red;">EU Procurement Social Value & Transparency in Supply Chains</a></li>
															</ol>
														</div>

													</div>
												</div>


												<div class="col-md-3 col-sm-6">
													<div class="pricing-table">
														<div class="plan-name">
															<h3>Pilots</h3>
														</div>

														<div class="plan-list">
															<ol align="left">
																<li><a href="{{URL::to('http://ow.ly/Bgx2d')}}" target="_blank" style="color:red;">Implementation</a></li>
																<li><a href="{{URL::to('http://ow.ly/BgxpJ')}}" target="_blank" style="color:red;">Case Study pilot</a></li>
																<li><a href="{{URL::to('http://ow.ly/BgAOc')}}" target="_blank" style="color:red;">Application 2% Law India</a></li>
															</ol>
														</div>

													</div>
												</div>

												<div class="col-md-3 col-sm-6">
													<div class="pricing-table">
														<div class="plan-name">
															<h3>Social Earnings Ratio</h3>
														</div>

														<div class="plan-list">
															<ol align="left">
																<li><a href="{{URL::to('http://ow.ly/CKHCf')}}" target="_blank" style="color:red;">International Research</a></li>
																<li><a href="{{URL::to('http://ow.ly/BgvR9')}}" target="_blank" style="color:red;">Prezi introduction</a></li>
																<li><a href="{{URL::to('http://ow.ly/Bgw1S')}}" target="_blank" style="color:red;">Timeglider history</a></li>
																<li><a href="{{URL::to('https://www.seratio.org/')}}" target="_blank" style="color:red;">Online course</a></li>
																<li><a href="{{URL::to('http://ow.ly/BgzZU')}}" target="_blank" style="color:red;">Jorum</a></li>
															</ol>
														</div>

													</div>
												</div>
											</div>
										</br>
										<div class="row">
											<div class="col-md-3 col-sm-6">
												<div class="pricing-table">
													<div class="plan-name">
														<h3>Licensees</h3>
													</div>

													<div class="plan-list">
														<ol align="left">
															<li><a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank" style="color:red;">Consumer brands</a> </li>
															<li><a href="{{URL::to('http://bigredsquare.com/')}}" target="_blank" style="color:red;">Public sector</a> </li>
															<li><a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank" style="color:red;">Birmingham</a></li>
															<li><a href="{{URL::to('http://sii2000.com/')}}" target="_blank" style="color:red;">Listed companies</a></li>
															<li><a href="{{URL::to('http://www.socialvalueportal.com/')}}" target="_blank" style="color:red;">Social Value Portal</a></li>
														</ol>
													</div>

												</div>
											</div>
											<div class="col-md-3 col-sm-6">
												<div class="pricing-table">
													<div class="plan-name">
														<h3>Social Value Act</h3>
													</div>

													<div class="plan-list">
														<ol align="left">
															<li><a href="{{URL::to('http://ow.ly/CbFUa')}}" target="_blank" style="color:red;">Social Value in Public Procurement (googledrive)</a></li>
															<li><a href="{{URL::to('http://ow.ly/CChMi')}}" target="_blank" style="color:red;">Social Value in Public Procurement (dropbox)</a></li>
															<li><a href="{{URL::to('http://ow.ly/Bsr9Y')}}" target="_blank" style="color:red;">Infogram of report</a></li>
															<li><a href="{{URL::to('http://ow.ly/BALSM ')}}" target="_blank" style="color:red;">Intro video (part 1)</a></li>
															<li><a href="{{URL::to('http://ow.ly/BqrbK')}}" target="_blank" style="color:red;">Intro video (part 2)</a></li>
															<li><a href="{{URL::to('http://ow.ly/Hi23r')}}" target="_blank" style="color:red;">Answer time with Hazel Blears MP</a></li>
														</ol>
													</div>

												</div>
											</div>
											<div class="col-md-3 col-sm-6">
												<div class="pricing-table">
													<div class="plan-name">
														<h3>Press Releases </h3>
													</div>

													<div class="plan-list">
														<ol align="left">
															<li><a href="{{URL::to('http://www.northampton.ac.uk/news/professor-olinga-ta-eed-hosts-united-nations-international-widows-day-at-the-house-of-lords')}}" target="_blank" style="color:red;">June 2014 - 100 Indian CEO's attend House of Lords conference chaired by Prof Ta'eed </a></li>
															<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-receives-unprecedented-feedback-for-inspirational-speech-at-institute-of-financial-services-event')}}" target="_blank" style="color:red;">May 2014 - Annual Institute of Financial Service Lecture </a></li>
															<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-collaborates-with-the-loomba-foundation-to-empower-245-million-widows')}}" target="_blank" style="color:red;">November 2013 - 450 attended London Guildhall event chaired by Prof Ta'eed including Deputy Prime Minister Nick Clegg, former First Lady Cherie Blair, Treasury Minister Danny Alexander</a></li>
															<li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-urges-individuals-worth-100-billion-collectively-to-consider-global-enterprise')}}" target="_blank" style="color:red;">June 2013 - US$ 100 billion HNWI attend The Dorchester, London, chaired by Prof Ta'eed including Lakshmi Mittal (US$ 16 b), Hinduja Brothers (US$ 17 b)</a></li>
														</ol>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div><!-- /.tab-content -->
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- End S/E Ratio Section -->


		<!-- Start Benchmark Section -->
		<div class="containerr" id="benchmark">
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Introduction</span></h2>
							<br>
							<p>  The Social Earnings Ratio came out of a leading team of academics that researched, re-modelled, and developed over a 3 year period (2011-2014) all the likely applications of a single universal non-financial metric. Working collaboratively now with over 40 universities in the world, we finally ended our testing period in Autumn 2014 and moved to implementation phase resulting in the seratio.com SaaS platform. Access to the Big Data we have harvested is by permission only, but many of our licensees across the world display parts of the data freely. Here we share with you a sample set of test data since 2011 to convey the exacting provenance of our research.
							</p>

						</div>
					</div>
					<br>
					<div class="container">
						<div class="row">
							<div class="section-title text-center">
								<h3>Factors in consideration</h3>
								<h4>GENERAL</h4>
								<li>Project</li>
								<li>Category</li>
								<li>Company</li>
								<h4>INPUT DATA</h4>
								<li>Popularity</li>
								<li>Positive Sentiment</li>
								<li>CSR spend</li>
								<li>Environmental</li>
								<li>People</li>
								<li>Cash Generated+Invested</li>
								<h4>REPORTED</h4>
								<li>SER</li>
								<li>SI by calculation</li>
								<li>Added Social Value</li>
								<li>Increase in Market Cap/NAV</li>
								<li>Environment</li>
								<li>People</li>
								<li>Cash</li>
								<li>Tax Avoidance</li>
								<li>Pay Disparity</li>

							</div>
						</div>
					</div>
					<div class="container">
						<div class="row">
							<div class="section-title text-center">
								<h3>Social Earnings Ratio</h3>
							</br>

							<img src="https://www.seratio.com/assets_frontend/images/se.jpg" width="900" height="2000" alt="">
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="section-title text-center">
							<h3>Increase in Market Cap/NAV (%)</h3>

							<img src="https://www.seratio.com/assets_frontend/images/ca.jpg" width="900" height="2000" alt="">

						</div>
					</div>
				</div>
				</div>
			</section>
		</div>
		<!-- End Benchmark Section -->

		<!-- Start Partners Section -->
		<div class="containerr" id="partners">
			<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h2><span>Seratio Partners</span></h2>
							<br>
							<div class="row">
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Brandanomics"><img src="https://www.seratio.com/assets_frontend/images/logo/brandanomics-logo.png" alt="Brandanomics"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Cultiv8 Solutions"><img src="https://www.seratio.com/assets_frontend/images/logo/cultiv8.png" alt="Cultiv8 Solutions"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://sii2000.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="SI2000"><img src="https://www.seratio.com/assets_frontend/images/logo/si2000.png" alt="SI2000"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://www.unseenuk.org/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Slavery"><img src="https://www.seratio.com/assets_frontend/images/logo/unseen.gif" alt="Slavery"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://www.seismicproject.eu/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="EU SEiSMiC Social Value"><img src="https://www.seratio.com/assets_frontend/images/logo/seismic.png" alt="EU SEiSMiC Social Value"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://www.cceg.org.uk/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="CCEG"><img src="https://www.seratio.com/assets_frontend/images/logo/cceg.png" alt="CCEG"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('https://procurement-forum.eu/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Procurement FORUM"><img src="https://www.seratio.com/assets_frontend/images/logo/pf.png" alt="Procurement FORUM"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://www.semantrica.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Semantrica"><img src="https://www.seratio.com/assets_frontend/images/logo/sem.png" alt="Semantrica"></a>
									</div>
								</div>
								<div class="col-md-3 col-sm-6">
									<div class="team-member">
										<a href="{{URL::to('http://socialvalueportal.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="The Social Value Portal"><img src="https://www.seratio.com/assets_frontend/images/logo/svportal.png" alt="The Social Value Portal"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<!-- End Partners Section -->

		<!-- Start Contact Section -->
		<div class="containerr" id="contact">
		<section><p><a class="pageload-link goback" href="#page-1">Go back</a></p>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><span>Contact With Us</span></h2>
					<br><br><br>
						<div class="container">
							<div class="row">
								<div class="col-md-8">
									<div class="well well-sm">
										<form>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="name">
															Name</label>
															<input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
													</div>
													<div class="form-group">
														<label for="email">
															Email Address</label>
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
															</span>
															<input type="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
														</div>
														<div class="form-group">
															<label for="subject">
																Subject</label>
																<select id="subject" name="subject" class="form-control" required="required">
																	<option value="na" selected="">Choose One:</option>
																	<option value="service">General Customer Service</option>
																	<option value="suggestions">Suggestions</option>
																	<option value="product">Product Support</option>
																</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="name">
																Message</label>
																<textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
																placeholder="Message"></textarea>
															</div>
													</div>
													<div class="col-md-12">
														<button type="submit" class="btn btn-primary pull-right" id="btnContactUs">
															Send Message</button>
													</div>
											</div>
										</form>
									</div>
								</div>
								<div class="col-md-4">
									<form>
										<legend><span class="glyphicon glyphicon-envelope"></span> Our Address</legend>
										<address>
											<strong>Seratio Limited</strong><br>
											Centre for Citizenship, Enterprise & Governance.<br>
											Bureau 112, UN Innovation, Green Street<br>
											Northampton, NN1 1SY<br>
											United Kingdom<br><br>

											<abbr title="Phone">P:</abbr>+44 (0) 1604 550100<br>
											<a href="mailto:#" style="color:red;">info@cceg.org.uk</a>
										</address>

									</form>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
			</section>
			</div>
			<!-- End Contact Section -->


	</div><!-- /container -->
	<!-- ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>


	{{ HTML::script('new_assets/js/snap.svg-min.js')}}

	{{ HTML::script('new_assets/js/svgLoader.js')}}

	{{ HTML::script('new_assets/js/classie.js')}}

	{{ HTML::script('new_assets/js/pathLoader.js')}}

	{{ HTML::script('new_assets/js/main.js')}}

	{{ HTML::script('new_assets/js/jquery.backstretch.min.js')}}

	{{ HTML::script('new_assets/js/letme.js')}}

	{{ HTML::script('assets_frontend/js/jquery.cookiebar.js')}}

	<script>
		$.backstretch("../new_assets/images/body_bg.jpg");
		TweenMax.staggerTo([".onee",".one",".two",".threee",".three",".four",".five",".six",".seven",".sevenn",".sevennn",".eight",".fivee",".ten", ".pro"],0,{ opacity:1,transform:"rotate(45deg)",scale:1,ease:Elastic.easeOut},.15);
		var targetItem = $('.box');
		targetItem.on("mouseenter", function(event) {
			TweenLite.to($(this), 0, {scale:1.1,ease: Elastic.easeOut});
		});

		targetItem.on("mouseleave", function(event) {
			TweenLite.to($(this), 0, {scale:1, ease: Elastic.easeOut});
		});

		/*animation*/
		TweenLite.to(".lineone", 1, { height:"97px", ease:Back.easeOut});
		TweenLite.from(".lineTwo", 1, { height:"0px",opacity:0, ease:Back.easeOut});
		TweenLite.to(".arrow", 1, { bottom:"-157px", ease:Back.easeOut});
		TweenMax.staggerTo([".facebook",".googlep",".linkedin",".youtube",".twitter",".tumb",".instagram", ".blog",".edu" ],1.8,{ right:0,opacity:1,ease: Elastic.easeOut},.20);

		$(document).ready(function(){
			$(this).scrollTop(0);
		});

	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$.cookieBar({
			});
		});
	</script>

</body>
</html>
