@extends('layout.info_default')

@section('title')

@parent
@stop

@section('content')

<!-- Start About Us Section -->
<div class="section-modal modal fade" id="about-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>About Us</h3>
                </br>
                <p align="center">At S/Eratio (“seratio”) we are not a consultancy, rating agency or ‘special advisors’ – instead we focus upon turning the intangible measurements that you have always wondered about into something very real and applicable to you.  <br></br>                        
                    Our sole objective of being able to turn intangible outcomes in real, verifiable and accurate measurements. We do this using the very latest in academic knowledge which combines social science, outcome metrics, data mining and sentiment analysis.  The logical outcome is an elite set of supermetrics which are constructed using sentiment analysis, geo-located with future proof analytical technology reinforced with the latest big data mining and machine learning technology.<br></br> 
                    Who do we serve? You - the citizens of the world – and we believe in multi-stakeholder engagement translated onto a citizenship map. <br></br> 
                    We aim to inform and empower  those responsible for making the decisions which ultimately have a positive or negative impact upon the world and all of those who aim to make a difference.  These people are not just those in executive boards of major corporations, those who reside in positions of power in government, but you, a consumer, a citizen of the world.  We focus upon informing the societies of the world<br></br> 
                    We believe that after decades of so called change agents trying to pioneer models of transformation from the top down – there now needs to be accurate measurements, provided by an elite, non-partisan entity which delivers the truth into the hands of the people. <br></br> 
                </div>
            </div>

            <div class="row">

                <div class="col-md-8">
                    <div class="custom-tab">

                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Thought Leadership </a></li>
                            <li><a href="#tab-2" role="tab" data-toggle="tab">Total Value</a></li>
                            <li><a href="#tab-3" role="tab" data-toggle="tab">Social Earnings Ratio</a></li>
                            <li><a href="#tab-6" role="tab" data-toggle="tab">Milestones</a></li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="tab-1">
                                <p>Seratio have devised the most relevant, scalable and accurate metric for measuring social value. For decades many have tried to make sense of what has been until now truly intangible – devising “measurements” that simply fail to take consideration the “real effects” into account. Thus far such measurements and metrics have been poorly adopted, subject to bias, too specific, not automated in any way and untranslatable. We aimed to put an end to the rather fuzzy world of social impact and social innovation and imbed it into scientific methods which can implement true change.</p>
                                <p>During the previous financial crisis we were issued with the challenge of measuring more scientifically and accurately the real-time contributions corporate entities and indeed individuals make to the world around them. The Social to Earning Ratio devised by Seratio measures your impact beyond just the marketplace, showing you in hard numbers the efficiency of your social spend, in much the same way the standard P/E Ratio (Price to Earnings) measures the earnings of your company against costs.</p>
                                <p>Indeed, we passionately believe that the current methodologies for measuring impact upon societies, the earth and institutions are out dated and no longer reflect the reality of what those inputs become in terms of impacts upon the grass roots or indeed intended targets. Most modern metrics also fail to utilize the huge technological advances that have occurred in the 21st century thus far. We focus on devising methodologies that are not designed to make corporations look good, but instead help the observer attain an accurate depiction of what really happens on the ground. </p>
                            </div>


                            <div class="tab-pane" id="tab-2">
                                <p>WHEN THE FACTS ARE OUT IN THE OPEN – WE ALL BENEFIT, IT’S JUST HOW LIFE IS MEANT TO BE.</p>
                                <p>The emphasis on pure financial value and outcomes no longer reflects reality in an ever changing world – we believe  in the new economy the true value of a brand or corporate entity  is now a combination of its Financial Value (P/E) and it’s Social Value (S/E).</p>
                                <p>There has to date been a systematic failure which we aim to address using our expertise in intangible measurement and analysis, big data mining and qualitative data analysis – to create metrics which systematically and consistently can measure the direct ramifications of our actions, or non-actions. </p>

                            </div>


                            <div class="tab-pane" id="tab-3">
                                <p>Within the financial world, the Price/Earnings Ratio (P/E Ratio or PER) is the main single index evaluation technique of economic performance and health check. Used throughout the world, and reported daily on stock exchanges, it has become the universally adopted tool. In rough terms, the P/E measures the capitalization of a company (what it's worth) against the amount of profit it generates. We have developed the corollary to the P/E, the S/E Ratio (SER) which measures the Social Impact of an organisation against the monies invested to achieve it (the earnings diverted which otherwise would be profit).</p>

                                <p>A share price is a relatively weak artefact representing degrees of alignment between shareholders and the organisations. It is subject to numerous reported and unmeasured biases which mean it cannot in isolation reflect the true “value” of the corporate entity. Generally only the shareholders and management benefit, and all others are a slave to that goal. Using human dynamic and descriptive analytics we have devised academically rigorous and peer reviewed methodologies which extend beyond these simple financial metrics.</p>

                                <p>Think of yourself as a operator within a ever changing environment, the impacts you make upon the world around you will change constantly as the environment evolves. Your impact as a human being is not simply a constituent of your productivity or ability to make money.</p>
                                <p>The social impact interpretation is that of citizenship, that the total value of an organisation is a total of the financial and social values. Taking social value, one has to measure the stakeholder value of customers, suppliers, staff, statutory bodies, community and the environment. </p>
                                <p>Independently commissioned, the methodology has been developed by the Centre for Citizenship, Enterprise and Governance (cceg.org.uk) and its affiliated network of 30+ International Universities and Research Institutes to ensure honesty and integrity in the reporting process.</p>

                                <p>Seratio reports in future proof XBRL format, using the latest GRI-4 template (Global Reporting Initiative) and is compliant with IIRC (The International Integrated Reporting Council).</p>

                            </div>

                            <div class="tab-pane" id="tab-6">
                                <div class="plan-list">
                                    <ol>
                                        <li><a href="{{URL::to('https://procurement-forum.eu/')}}" target="_blank">1. January 2015 – chair EU Procurement group “Social Value and Transparency in Supply Chains”</a></li>
                                        <li><a href="#" target="_blank">2. December 2014 - commissioned to produce UK Modern Slavery Act 2014 metric</a></li>
                                        <li><a href="{{URL::to('http://www.seismicproject.eu/')}}" target="_blank">3.November 2014 - appointed Chair of EU SEiSMiC Social Value across 10 countries</a></li>
                                        <li><a href="{{URL::to('http://www.theinformationdaily.com/2014/11/19/answertime01')}}" target="_blank">4. November 2014 – video Question Time with Hazel Blears MP and Prof Ta’eed</a></li>
                                        <li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-professor-takes-part-in-a-panel-alongside-hazel-blears-mp-to-discuss-the-concept-of-social-value')}}" target="_blank">5.November 2014 – deliver our S/E social impact report for Loomba Foundation to Bombay Stock Exchange members by Dr Vince Cable MP, Business Secretary of State</a></li>
                                        <li><a href="{{URL::to('https://www.youtube.com/watch?v=WAyPxiWbOoc')}}" target="_blank">6a. October 2014 - release of national interviews on Social Value</a></li>
                                        <li><a href="{{URL::to('https://www.youtube.com/watch?v=lbw_GKy8cow&feature=youtu.be')}}" target="_blank">6b. October 2014 - release of national interviews on Social Value</a></li>
                                        <li><a href="{{URL::to('https://drive.google.com/folderview?id=0B51i5nTXo9qtV1ROTDk5QWR5cUk&usp=sharing')}}" target="_blank">7a.September 2014 - commissioned to launch 250 page "Social Value in Public Procurement" bible</a></li>
                                        <li><a href="{{URL::to('https://www.dropbox.com/sh/8zzxr4al853cdqe/AAAKDjiCwclOj6DLW5sc3toCa?dl=0')}}" target="_blank">7b.September 2014 - commissioned to launch 250 page "Social Value in Public Procurement" bible</a></li>
                                        <li><a href="{{URL::to('http://www.socialvalueportal.com/')}}" target="_blank">8a.September 2014 - commissioned to produce Social Value Portal with Hazel Blears MP</a></li>
                                        <li><a href="{{URL::to('http://www.zenit.org/en/articles/olinga-ta-eed-on-link-between-profit-motive-and-reduction-of-poverty')}}" target="_blank">8b.June 2014 - Speech to The Pope at The Vatican</a></li>
                                        <li><a href="{{URL::to('http://www.northampton.ac.uk/news/professor-olinga-ta-eed-hosts-united-nations-international-widows-day-at-the-house-of-lords')}}" target="_blank">9.June 2014 - 100 Indian CEO's attend House of Lords conference chaired by Prof Ta'eed</a></li>
                                        <li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-receives-unprecedented-feedback-for-inspirational-speech-at-institute-of-financial-services-event')}}" target="_blank">10. May 2014 - Annual Institute of Financial Service Lecture</a></li>
                                        <li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-collaborates-with-the-loomba-foundation-to-empower-245-million-widows')}}" target="_blank">11.  November 2013 - 450 attended London Guildhall event chaired by Prof Ta'eed including Deputy Prime Minister Nick Clegg, former First Lady Cherie Blair, Treasury Minister Danny Alexander</a></li>
                                        <li><a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank">8a.  October 2013 - launch licensees using automated platform - Brandanomics</a></li>
                                        <li><a href="{{URL::to('http://sii2000.com/')}}" target="_blank">8b. October 2013 - launch licensees using automated platform - SI2000</a></li>
                                        <li><a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank">8c. October 2013 - launch licensees using automated platform - Cultiv8 Solutions</a></li>
                                        <li><a href="{{URL::to('http://bigredsquare.com/')}}" target="_blank">8d. October 2013 - launch licensees using automated platform - Big Red Square</a></li>
                                        <li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-urges-individuals-worth-100-billion-collectively-to-consider-global-enterprise')}}" target="_blank">13. June 2013 - US$ 100 billion HNWI attend The Dorchester, London, chaired by Prof Ta'eed including Lakshmi Mittal (US$ 16 b), Hinduja Brothers (US$ 17 b)</a></li>
                                        <li><a href="#" target="_blank">14.  January 208-Q1 2013 - wiki university approach on S/E amongst c. 30 universities</a></li>
                                        <li><a href="#" target="_blank">15.  November 2011 - commissioned by UK Government's 'Big Society' to develop universal social impact metric </a></li>
                                    </ol>
                                </div>
                            </div>
                        </div><!-- /.tab-content -->

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End About Us Section -->

<!-- Start Citizenship Section -->
<div class="section-modal modal fade" id="citizen-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Citizenship Map</h3>

                    <p> The Social Earnings Ratio (S/E) is built on our current understanding of organisational structure - the multistakeholder environment, often called a Citizenship Map.
                        We have also developed a range of S/E prodigy metrics to reflect Total Value.

                    </p>                                        
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Key</h3>
                    <ul class="list-group column">
                        <h4><li class="list-group col-lg-6">1.Capitilization</li></h4>
                        <h4><li class="list-group col-lg-6">5.CO2</li></h4>
                        <h4><li class="list-group col-lg-6">2.Social Value</li></h4>
                        <h4><li class="list-group col-lg-6">6.Transparency in Supply Chains</li></h4>
                        <h4><li class="list-group col-lg-6">3.Pay Disparity</li></h4>
                        <h4><li class="list-group col-lg-6">7.Personal(Citizen) Value </li></h4>
                        <h4><li class="list-group col-lg-6">4.Tax Avoidance</li></h4>          
                    </ul>



                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">

                </br>

                {{ HTML::image('assets_frontend/images/citizen.png', '', array( 'width' => 600, 'height' => 600 )) }}
            </div>
        </div>
    </div>



</div>
</div>
<!-- End Citizenship Section -->

<!-- Start Social Value Ratio Section -->
<div class="section-modal modal fade" id="svalue-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Social Value</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">Named as “the most rapidly adopted social impact metric in 

                    the world” (The Vatican, 2014), seratio has become the leading 

                    metric in public sector procurement. We are helping all public 

                    sector agencies procure in a way that in compliant to local 

                    jurisdictions – implanting more social return on every contract
                </p>
                <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
            </div>
        </div>
    </div>

</div>
</div>
<!-- End Social Value Us Section -->

<!-- Start Modern Slavery Section -->
<div class="section-modal modal fade" id="mslavery-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Modern Slavery</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">The tip of this iceberg is trafficking, agricultural working,

                    domestics, etc but under the media glare is the Transparency 

                    in Supply Chains where most of the problem lies. But in the 

                    words of the great American abolitionist William Lloyd Garrison 

                    himself, seratio “will be as harsh as truth, and as uncompromising 

                    as justice ... in earnest ... will not equivocate ... will not excuse ... will not 

                    retreat a single inch — AND I WILL BE HEARD....
                </p>
                <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
            </div>
        </div>
    </div>

</div>
</div>
<!-- End Modern Slavery Section -->

<!-- Start Health & Wellbeing Section -->
<div class="section-modal modal fade" id="hw-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Health & Wellbeing</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">Happiness, Health and Wellbeing – often quoted as the most 

                    important characteristic of life itself. Your blood pressure, the 

                    amount of money in your bank, the number of times you get to 

                    see your loved ones? Are these really the only measurements 

                    of happiness that we have? At Seratio we posed the same 

                    question and are working tirelessly to articulate this most 

                    important index
                </p>
                <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
            </div>
        </div>
    </div>

</div>
</div>
<!-- End Health & Wellbeing Section -->

<!-- Start Domestic Violence Section -->
<div class="section-modal modal fade" id="dv-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Domestic Violence</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">Despite 6,000 years of living in organised societies humankind 

                    still faces an unprecedented challenge in the context of 

                    equality. Violence in particular and certain gender and ethnic 

                    groups has been widely broadcast by the media. Despite the 

                    best efforts of courageous campaigners who have fought 

                    against injustice, the inequalities continue often allied to 

                    aggression. We intend to empower this area with some tangible 

                    metrics to provide deep learning through an analytical platform 

                    which goes beyond exposure
                </p>
                <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
            </div>
        </div>
    </div>

</div>
</div>
<!-- End Domestic Violence Section -->

<!-- Start Personal Value Section -->
<div class="section-modal modal fade" id="per-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">

                </br>
                <p>
                   {{ HTML::image('assets_frontend/images/pv_pic.jpg', '', array( 'width' => 1200, 'height' => 550 )) }}
               </p>
               
               {{ Form::open(array('action' => 'SubscribeController@store', 'class'=>'form-group')) }}                  
               {{ Form::email('email', '', array('placeholder' => 'E-Mail', 'required')) }}

               {{ Form::submit('Subscribe', ['class' => 'btn btn-success']) }} 

               {{ Form::close() }}
           </div>
       </div>
   </div>

</div>
</div>
<!-- End Personal Value Section -->

<!-- Start Animal Welfare Section -->
<div class="section-modal modal fade" id="aw-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Animal Welfare</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">We intend to build a universal animal welfare platform with

                    detailed analytics and forecasting capabilities to monitor the 

                    most endangered species, those animals which are hunted or 

                    abused with real-time, social impact metrics monitoring supply 

                    chains which exploit or abuse animals around the globe. It will 

                    be the world’s only comprehensive monitoring and reporting 

                    platform
                </p>
                <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
            </div>
        </div>
    </div>

</div>
</div>
<!-- End Animal Welfare Section -->

<!-- Start Impact Investment Section -->
<div class="section-modal modal fade" id="ii-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Impact Investment</h3>
                </br>
                <p align="center">The Banking and Financial Services sectors are set for transformation as their role, industry structure and commercial environments become disrupted by social innovation and a greater awareness of societal change.
                    The major trends currently reshaping the global economy have been established by the increasing awareness an. 
                    This progressive transformation means that many businesses will be unrecognisable by the end of the decade and evolution of market leaders or constituents of many leading stock indices could shaped by this shift. 
                    Those organisations which remain at the very cusp of social innovation and have the appropriate tools and frameworks to create smart and agile strategies will inevitably leapfrog more lethargic competitors.  
                    What major corporations will have to ask themselves is will their existing business model still be relevant in the new global economy? How can they take advantage of the shake-up ahead? How can they measure, record or even utilise something that they cannot understand? 
                    The answer comes from a hybridised solution from SERATIO
                </br></br>
                We have developed the appropriate metrics to give corporations of any size the ability to investigate and forecast the potential return on investment by appropriately resourcing impact investments. 
                Further still, using the very latest sentiment analysis, scenario forecasting, benchmarking and deep machine learning we are the leading authority in measuring “the intangible agents of change”. 
                For every single financial metric and key performance indictor we have developed the analogous measurement methodology which translates and automates intangibles into a measurement that your firm can use to directly influence all corporate activity, from strategy to your bottom line. We have done this by combining the most powerful manual and digitally automated technologies – from mathematical modelling and formula creation, to the use of the semantic web, machine learning and artificial intelligence.
            </br></br>
            Founded in the UK, Seratio brings together to very best academic and business world talent. It is born out of the last financial crisis and has been used in many pioneering innovations in finance for impact, for example in the development of Social Impact Bonds as a structured finance product for social impact, the creation of socio-economic metrics for corporate stock indexes and in measuring intangible effects that your firm may have upon obscure but highly important societal problems such as slavery, animal welfare and violence. 
            It is the world's only scalable, verifiable, cost effective and automated metric – measuring any dimension of social impact every 10 seconds.
        </br></br>
        We have ensured the technology is 100% translatable and transferable – whether you use Microsoft Excel or the most complex Big Data or Artificial Intelligence system – even pen and paper can be automated and translated by SERATIO
    </p>
    {{ HTML::image('assets_frontend/images/ser.png') }} 
</br>
</br> 
<a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
</div>
</div>
</div>

</div>
</div>
<!-- End Impact Investment Section -->





<!-- Start S/E Ratio Section -->
<div class="section-modal modal fade" id="seratio-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>S/E Ratio</h3>

                </br>
                <p>The Social to Earnings ratio (S/E) behaves as a grandfather

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

                    third and community sectors.</p>
                </div>
            </div>

            <div class="row">

                <div class="col-md-8">
                    <div class="custom-tab">

                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="active"><a href="#tab-4" role="tab" data-toggle="tab">INTEGRATION MATTERS</a></li>
                            <li><a href="#tab-5" role="tab" data-toggle="tab">CUSTOMISATION, COLLABORATION, FORECASTING</a></li>

                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane active" id="tab-4">
                                <p>Our charting integrates the entire scope of social data, 

                                    supplemented with the most robust financial APIs to create a 

                                    holistic platform allowing you to create charts that consolidate 

                                    all relevant information. This means you can quickly validate 

                                    ideas, watch trends and generate value. Only on Seratio’s 

                                    platforms can you plot multiple instruments across every social 

                                    and financial asset class. Compare company fundamentals, 

                                    ratios and estimates with other companies, commodities, 

                                    currencies and economic data, then create composites for a 

                                    more comprehensive view of the market.</P>

                                    <p>Draw from almost 400 technical studies and indicators, both 

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
                                        <p>Charting on our platform is powerful and customisable, with

                                            numerous pre-packaged applications and shortcuts that allow 

                                            you to jump quickly to charts and studies important to you. 

                                            Start with a template, and then choose from a vast array of 

                                            customization tools to configure data and associated alerts. 

                                            Create your own view of the markets with our annotations 

                                            palette. You’re always ready to present ideas, with a few 

                                            clicks all it takes to export charts into presentations with all 

                                            annotations included.</P>
                                            <p>Communication and collaboration using charts is simple. 

                                                You can share and co-edit charts with clients and colleagues 

                                                throughout the community, in real time, through our reorting 

                                                engine. Compare ideas and build a common point of view.</P>
                                                <p>Design your own custom studies and share with colleagues and 

                                                    clients to generate profitable trade ideas. Use our forecasting 

                                                    tool to play out thousands of scenarios from a wide array 

                                                    of benchmarks to determine strategies and optimization 

                                                    techniques most profitable over time </p>

                                                </div>

                                            </div><!-- /.tab-content -->

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </br>




                        <div class="section-title text-center">
                            <h3>Information</h3>
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
                                        <ul>
                                            <li><a href="{{URL::to('http://www.zenit.org/en/articles/the-vatican-has-long-promoted-intangible-values-can-they-be-measured')}}" target="_blank">Zenit (5th January 2015)</a></li>
                                            <li><a href="{{URL::to('http://www.zenit.org/en/articles/olinga-ta-eed-on-link-between-profit-motive-and-reduction-of-poverty')}}" target="_blank">Interview (1st July 2014)</a></li>
                                            <li><a href="{{URL::to('http://ow.ly/BgAwB')}}" target="_blank">Vatican Speech Video</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="pricing-table">
                                    <div class="plan-name">
                                        <h3>Networks</h3>
                                    </div>
                                    
                                    <div class="plan-list">
                                        <ul>
                                            <li><a href="{{URL::to('http://ow.ly/Gpu7N')}}" target="_blank">EU SEiSMiC Social Value</a></li>
                                            <li><a href="{{URL::to('http://ow.ly/Hi4sd')}}" target="_blank">EU Procurement Social Value & Transparency in Supply Chains</a></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>

                            
                            <div class="col-md-3 col-sm-6">
                                <div class="pricing-table">
                                    <div class="plan-name">
                                        <h3>Pilots</h3>
                                    </div>

                                    <div class="plan-list">
                                        <ul>
                                            <li><a href="{{URL::to('http://ow.ly/Bgx2d')}}" target="_blank">Implementation</a></li>
                                            <li><a href="{{URL::to('http://ow.ly/BgxpJ')}}" target="_blank">Case Study pilot</a></li>
                                            <li><a href="{{URL::to('http://ow.ly/BgAOc')}}" target="_blank">Application 2% Law India</a></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="pricing-table">
                                    <div class="plan-name">
                                        <h3>Social Earnings Ratio</h3>
                                    </div>

                                    <div class="plan-list">
                                        <ul>
                                            <li><a href="{{URL::to('http://ow.ly/CKHCf')}}" target="_blank">International Research</a></li>
                                            <li><a href="{{URL::to('http://ow.ly/BgvR9')}}" target="_blank">Prezi introduction</a></li>
                                            <li><a href="{{URL::to('http://ow.ly/Bgw1S')}}" target="_blank">Timeglider history</a></li> 
                                            <li><a href="{{URL::to('https://www.seratio.org/')}}" target="_blank">Online course</a></li>
                                            <li><a href="{{URL::to('http://ow.ly/BgzZU')}}" target="_blank">Jorum</a></li>
                                        </ul>
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
                                    <ul>
                                     <li><a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank">Consumer brands</a> </li>
                                     <li><a href="{{URL::to('http://bigredsquare.com/')}}" target="_blank">Public sector</a> </li>
                                     <li><a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank">Birmingham</a></li> 
                                     <li><a href="{{URL::to('http://sii2000.com/')}}" target="_blank">Listed companies</a></li>
                                     <li><a href="{{URL::to('http://www.socialvalueportal.com/')}}" target="_blank">Social Value Portal</a></li>
                                 </ul>
                             </div>

                         </div>
                     </div>
                     <div class="col-md-3 col-sm-6">
                        <div class="pricing-table">
                            <div class="plan-name">
                                <h3>Social Value Act</h3>
                            </div>

                            <div class="plan-list">
                                <ul>
                                    <li><a href="{{URL::to('http://ow.ly/CbFUa')}}" target="_blank">Social Value in Public Procurement (googledrive)</a></li>
                                    <li><a href="{{URL::to('http://ow.ly/CChMi')}}" target="_blank">Social Value in Public Procurement (dropbox)</a></li>
                                    <li><a href="{{URL::to('http://ow.ly/Bsr9Y')}}" target="_blank">Infogram of report</a></li>
                                    <li><a href="{{URL::to('http://ow.ly/BALSM ')}}" target="_blank">Intro video (part 1)</a></li>
                                    <li><a href="{{URL::to('http://ow.ly/BqrbK')}}" target="_blank">Intro video (part 2)</a></li>
                                    <li><a href="{{URL::to('http://ow.ly/Hi23r')}}" target="_blank">Answer time with Hazel Blears MP</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="pricing-table">
                            <div class="plan-name">
                                <h3>Press Releases </h3>
                            </div>

                            <div class="plan-list">
                                <ul>
                                    <li><a href="{{URL::to('http://www.northampton.ac.uk/news/professor-olinga-ta-eed-hosts-united-nations-international-widows-day-at-the-house-of-lords')}}" target="_blank">June 2014 - 100 Indian CEO's attend House of Lords conference chaired by Prof Ta'eed </a></li>
                                    <li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-receives-unprecedented-feedback-for-inspirational-speech-at-institute-of-financial-services-event')}}" target="_blank">May 2014 - Annual Institute of Financial Service Lecture </a></li>
                                    <li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-collaborates-with-the-loomba-foundation-to-empower-245-million-widows')}}" target="_blank">November 2013 - 450 attended London Guildhall event chaired by Prof Ta'eed including Deputy Prime Minister Nick Clegg, former First Lady Cherie Blair, Treasury Minister Danny Alexander</a></li> 
                                    <li><a href="{{URL::to('http://www.northampton.ac.uk/news/university-of-northampton-professor-urges-individuals-worth-100-billion-collectively-to-consider-global-enterprise')}}" target="_blank">June 2013 - US$ 100 billion HNWI attend The Dorchester, London, chaired by Prof Ta'eed including Lakshmi Mittal (US$ 16 b), Hinduja Brothers (US$ 17 b)</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End S/E Ratio Section -->


    <!-- Start Partners Section -->
    <div class="section-modal modal fade" id="partners-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <div class="close-modal" data-dismiss="modal">
                <div class="lr">
                    <div class="rl">
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="section-title text-center">
                        <h3>Seratio Partners</h3>
                    </br>

                </div>
            </div>
            <div class="row">

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <a href="{{URL::to('http://www.brandanomics.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Brandanomics">{{ HTML::image("assets_frontend/images/logo/brandanomics-logo.png", "Brandanomics") }}</a>    
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <a href="{{URL::to('http://www.cultiv8solutions.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Cultiv8 Solutions">{{ HTML::image("assets_frontend/images/logo/cultiv8.png", "Cultiv8 Solutions") }}</a>    
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                 <div class="team-member">
                    <a href="{{URL::to('http://sii2000.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="SI2000">{{ HTML::image("assets_frontend/images/logo/si2000.png", "SI2000") }}</a>    
                </div>
            </div>



            <div class="col-md-3 col-sm-6">
             <div class="team-member">
               <a href="{{URL::to('http://www.unseenuk.org/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Slavery">{{ HTML::image("assets_frontend/images/logo/unseen.gif", "Slavery") }}</a>    
           </div>
       </div>

       <div class="col-md-3 col-sm-6">
        <div class="team-member">
            <a href="{{URL::to('http://www.seismicproject.eu/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="EU SEiSMiC Social Value">{{ HTML::image("assets_frontend/images/logo/seismic.png", "EU SEiSMiC Social Value") }}</a>    
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
     <div class="team-member">
        <a href="{{URL::to('http://www.cceg.org.uk/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="CCEG">{{ HTML::image("assets_frontend/images/logo/cceg.png", "CCEG") }}</a>    
    </div>
</div>

<div class="col-md-3 col-sm-6">
 <div class="team-member">
    <a href="{{URL::to('https://procurement-forum.eu/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Procurement FORUM">{{ HTML::image("assets_frontend/images/logo/pf.png", "Procurement FORUM") }}</a>    
</div>
</div>

<div class="col-md-3 col-sm-6">
    <div class="team-member">
        <a href="{{URL::to('http://www.semantrica.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="Semantrica">{{ HTML::image("assets_frontend/images/logo/sem.png", "Semantrica") }}</a>    
    </div>
</div>

<div class="col-md-3 col-sm-6">
 <div class="team-member">
    <a href="{{URL::to('http://socialvalueportal.com/')}}" target="_blank" data-toggle="tooltip" data-placement="top" title="The Social Value Portal">{{ HTML::image("assets_frontend/images/logo/svportal.png", "The Social Value Portal") }}</a>    
</div>
</div>



</div><!-- /.row -->
</div>

</div>
</div>
<!-- End Partners Section -->


<!-- Start Benchmark Section -->
<div class="section-modal modal fade" id="benchmark-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Introduction</h3>

                    <p> The Social Earnings Ratio came out of a leading team of academics that researched, re-modelled, and developed over a 3 year period (2011-2014) all the likely applications of a single universal non-financial metric. Working collaboratively now with over 40 universities in the world, we finally ended our testing period in Autumn 2014 and moved to implementation phase resulting in the seratio.com SaaS platform. Access to the Big Data we have harvested is by permission only, but many of our licensees across the world display parts of the data freely. Here we share with you a sample set of test data since 2011 to convey the exacting provenance of our research.

                    </p>                                        
                </div>
            </div>
        </div>

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

                {{ HTML::image('assets_frontend/images/se.jpg', '', array( 'width' => 900, 'height' => 2000 )) }}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="section-title text-center">
                <h3>Increase in Market Cap/NAV (%)</h3>

                {{ HTML::image('assets_frontend/images/ca.jpg', '', array( 'width' => 900, 'height' => 2000 )) }}


            </div>
        </div>
    </div>

</div>
</div>
<!-- End Benchmark Section -->

<!-- Start Consumer IndexSection -->
<div class="section-modal modal fade" id="consumer-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Consumer Index</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">Thus far consumer orientated markets have concentrated upon developing measurements that examine the simplistic financial characteristics of the items households purchase, be they tangible goods such as food items or services such as car insurance.  The financial and economic focus of this “commoditisation of goods or services” have increasingly become essential components of capitalist societies.
                    The major problem with current methodologies is that they do not give a full picture of the true value of the good or service the individual is purchasing. Take the standard Consumer Pricing Index (CPI) as a classic example. It is calculated by taking the expected or observed price changes for each item in the predetermined basket of goods and averaging them; then these goods are weighted according to their importance – an importance again predetermined by an economist’s model – not by you, the end user or consumer. Changes in CPI are used to assess price changes associated with the cost of living. These are very important because the corporations who make the goods or provide the service will adjust the pricing accordingly which affects you, the governments and public authorities of the world will also influence tax rates and assignment of political priorities based on the demand levels attributed to the CPI – which again directly affects you, the consumer.</br>

                </br>
                At Seratio we know the status quo in the industry of measuring and rating goods and services is not a reflection of the true value. We feel that as the agents of change the consumer should not be veiled by purely financial and economic measurements – they should have access to metrics and measurements that give them the detailed knowledge they need understand what they are buying and what affect that will have upon society at large. We combine the financial value with all intangible values attributed to the product or service you are about to purchase. We dare to ask questions that many corporations probably would not want you to know – as it may influence what you buy. Take the example of a T-shirt manufactured by a sweatshop in Asia or Africa – if you the consumer knew the true extent of social, political, economic and environmental damage that is done by you purchasing that item, you may think twice. At Seratio we go further – we attribute those measurements around you, we will be able to articulate the action of buying that item and benchmarking against your other purchasing habits, telling you what your consumer behaviour does to the society around you but also what good or bad you do around the world. It works two ways also – each and every corporation you interact with is measured in the same way – so now the consumer and the corporate are both equally responsible to make more informed choices.
            </p>
            <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
        </div>
    </div>
</div>

</div>
</div>
<!-- End Consumer Index Section -->

<!-- Start Happy Cities Section -->
<div class="section-modal modal fade" id="happy-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Happy Cities</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">We believe that the formation and investment of funds into social impact projects which foster the notion of the “happy city” not only is an opportunity for its inhabitants but also for corporations and public bodies which interact with those cities. Research from some of our partners in the world of academia clearly shows that the correlation between happiness and investment is particularly strong for young and disruptive SMEs which the Harvard business review terms “less codified decision making process” powered by the “younger and less experienced managers who are more likely to be influenced by sentiment.’” For us at Seratio the truth comes from sophisticated sentiment analysis – knowing what inhabitants of a city think and feel about their surroundings and articulating that value in terms of evidence based numbers. We also believe that we need to create a more fair and equal society using the very latest technology and the people of the world in a united fashion – a sentiment backed by research which shows that the  relationship between wealth, happiness and equality “was also stronger in places where happiness was spread more equally”. We have worked closely with many corporate partners and increasingly we are finding that firms seem to invest more in places where most people are relatively happy – helping the rich to become richer rather than focusing on areas of need. The solutions we have developed concentrate on these places with happiness “inequality, or large gaps in the distribution of well-being.” They show corporates where their social and financial investment can make the biggest REAL impacts and how they can articulate that return on investment to their stakeholders in terms of definitive value.

                </p>
                <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
            </div>
        </div>
    </div>

</div>
</div>
<!-- End Happy Cities Section -->

<!-- Start Happy Cities Section -->
<div class="section-modal modal fade" id="arts-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>The Arts</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">The Arts are what makes the human race thrive, from cultural development to the cohesion of entire communities an nations it serves as a bedrock to humanity and society on earth. Arts take many forms – from a historical to a cultural context, dance and music to theatre and the visual arts, the arts give humans a unique means of expression. Most importantly the arts have served as an effective mechanism for people to embed morality and social impacts capturing their passions and emotions whilst breaking down barriers, be they racial, political, cultural or financial. The true impact of the arts upon society has seldom been measured forma social perspective or a holistic value perspective. Its ability to look at the way we explore new ideas, subject matter, and cultures – and the direct correlations that has upon special good in both quantitative and qualitative ways has never been universally agreed. At Seratio we are not only developing these unique methods of measuring the impacts arts have – but we are turning our attention to the way in which investment in the arts has social returns in monetary values within communities and how it can also help the public sector authorities in all economies around the world, regardless of size or strength.
                </br></br>The Arts and its variety of offshoots communicates to us  and improves us in ways that help us understand more about each other and enhance our lives in ways we have not fully understood or explored. At Seratio we hope to become the forerunners to a new perspective on the impacts of arts in society – we staunchly believe that we must as a human race continue to find a place for arts programs and partnerships not only for what it teaches students about art, but for what it teaches us all about the world we live in.

            </p>
            <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
        </div>
    </div>
</div>

</div>
</div>
<!-- End Happy Cities Section -->

<!-- Start Hyper Locality Section -->
<div class="section-modal modal fade" id="hyper-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Hyper Locality</h3>
                </br>
                <p style="margin-left:10%; margin-right:10%;" align="">We all want to know more about the places we live, work or spend our social lives within. Understanding our environment, the complex interactions between people and physical assets such as parks, buildings and public spaces is not only an innate part of our human behaviour but also gives us wisdom on social norms and boundaries in the places we interact with. Ask yourself one very telling question – do you really know what is going on in your locality? Are you connected with your community and do you know the “word on the street”?

                    This complex and ever changing information is what hyperlocality looks at – it is the data that is created around a well-defined community or the interaction between communities and the physical landscape around them. The world is globalising at an alarming rate and technology has served to accelerate the interactions and interdependencies communities have between each other, be it economic or social, each interaction is a form of trade. Hyperlocality investigates the real concerns of the population in any given community by looking at the trends in data, the conversations taking place by participants in any given community, the boundaries of which are fluid and ever evolving.
                </br>
            </br>
            At Seratio we use hyperlocality to extract important intelligence from communities and to help external and internal agents of change build community capacity.
            We help target the most effective methods of community growth be it social or economic by robustly determining which methods implant real value and social improvement - going beyond the now outdated concept of social investment as a blind science.
        </br></br>
        We use the very latest technology, leveraging the power of the emergent ecology of data to exploit these channels in order to measure and define the data behind hyperlocal events. These includes but are not limited to user interactions, heat map GIS analysis, aggregators, publication mechanisms, social media and behaviours of agents within a community unit. We focus on what the individual does within a community and the social value they impart upon their surroundings as well as the collective impacts of an entire community. Things need to be made simple for a decision to be reached and actions to be taken - so we can articulate the outcome in one single number. our methods are used to inform public sector services, corporate agents and any other interested group who form part of that community – in a non-partisan and unbiased manner.

    </p>
    <a href="{{URL::route('sessions.login')}}" class="btn btn-primary btn-lg" title="Click here access the dashboard">Go To Dashboard</a>
</div>
</div>
</div>

</div>
</div>
<!-- End Happy Cities Section -->

<!-- Start Team Section -->
<div class="section-modal modal fade contact" id="team-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
            <div class="lr">
                <div class="rl">
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="section-title text-center">
                    <h3>Directors</h3>
                </br>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6">
                <div class="testimonial">
                    {{ HTML::image('assets_frontend/images/team/karen.JPG', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                    <h4>Karen Bryson MBA - COO</h4>
                    <div class="speech">
                        <p style="font-size:125%" align="justify">An experienced business strategist with 10 years’ senior level consultancy and portfolio with PwC, KPMG, EY 

                            and Atos. 

                            As an entrepreneur, Karen has been at the forefront of organisational and system change, successfully creating 

                            solutions, securing new markets, and developing durable approaches to complex service environments. 

                            With public sector experience and extensive professional networks at all levels, Karen has managed a successful 

                            independent practice since 2011 working directly with corporates, private and public sector organizations to 

                            develop alternative service models, solutions and pre-emptive action in the health and social care sectors

                            Karen has a daughter and son, rides, skis and climbs mountains for adrenaline kicks, and balances this with 

                            reading and music.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="testimonial">
                        {{ HTML::image('assets_frontend/images/team/barbara.jpg', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                        <h4>Barbara Mellish MBA, MIRM, ACIB - CEO</h4>
                        <div class="speech">
                            <p style="font-size:125%" align="justify">An experienced Director, Non-Exec and Advisor to Blue-Chip and private companies, public sector organisations and third sector businesses.
                                Barbara’s commercial acumen has been built from a successful career within financial services, specialising in risk management, corporate governance and compliance, including board appointments at Barclaycard and European boards and representation for the global brands of MasterCard and Visa.
                                Her private sector discipline and experience has been blended with executive roles in the not-for profit and public sectors. The most recent role being the Director of Payments Integrity and Security at the Payments Council which had responsibility for the reliability and cyber resilience of the UK’s banking payments systems.
                                Barbara has two teenage children and is a keen traveller, scuba diver & adrenalin sports fan.</p>
                            </div>
                        </div>
                    </div>
                </div><!--/.row -->

                <div class="row">
                   <div class="col-md-6">
                    <div class="testimonial">
                     {{ HTML::image('assets_frontend/images/team/olinga.png', '', array( 'width' => 500, 'height' => 50, 'class'=>'img-responsive' )) }}
                     <h4>Professor Olinga Ta’eed PhD FIoD - Chairman</h4>
                     <div class="speech">
                        <p style="font-size:125%" align="justify">Olinga is Director of the Centre for Citizenship, Enterprise and Governance and attributed with the creation of the Social Earnings Ratio (S/E). He is Professor of Social Enterprise at  University of Northampton, Visiting Professor in Capacity Development at Birmingham City University, Chair of EU SEiSMiC Social Value and Chair of EU PROCUREMENT Social Value & Transparency in Supply Chains. He is Executive Editor of Social Value & Intangibles Review.

                            Olinga retired from a successful private sector career at the age of 48 as “entrepreneur, investor, and social activist”. In the last 7 years he has developed his role of a carer including for emergency fostering on his small holding in Wales and he remains a registered adopter. He has homes in the UK and Italy.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="section-title text-center">
                    <h3>Team</h3>
                </br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="testimonial">
                    {{ HTML::image('assets_frontend/images/team/sajin.jpg', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                    <h4>Sajin Abdu B Tech, MBA - CTO</h4>
                    <div class="speech">
                        <p style="font-size:125%" align="justify">A dedicated professional with over five years of combined experience as a software developer, marketing supervisor and PMO in blue chip and private companies. His most recent role being the PMO of Tata Consultancy Services which had responsibility for project commercial management, Internal audits facilitator and presales proposals creation and estimation. Sajin is a qualified electronics and communications engineer and has completed his Master of Business Administration from University of Northampton.

                            He enjoys keeping up-to-date with the latest advances in technology and have remained amazed at the speed of computerised developments over the past few years. He is an avid traveller and enjoys music and good food.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="testimonial">
                        {{ HTML::image('assets_frontend/images/team/paul.png', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                        <h4>Paul Adam MBA - Head of Public Sector</h4>
                        <div class="speech">
                            <p style="font-size:125%" align="justify">Experienced entrepreneur and with a very varied background in the public, private and third sectors 

                                at director level. Paul currently lectures and advises students on entrepreneurship at University of 

                                Birmingham and Warwick Business School.  In addition his own businesses, his experience includes 

                                leading the Commercial Development Team at the Environment Agency and advising a range of 

                                companies, from a £1bn US bluechip seeking to enter the UK, to a small organic kosher chicken 

                                farmer.  

                                He has previously been a non-executive director for Riverside Housing, one of the largest RSLs in the 

                                UK and a panel member at the Fredericks Foundation which supports start-ups from disadvantaged 

                                backgrounds. He is currently working with St Basils in Birmingham to create a social enterprise.

                                He has 3 children (very soon to be 4) and 10 cats and in his snatches of spare time enjoys walking in 

                                the Peak District or sitting by a roaring fire with a good book and a large whisky.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="testimonial">
                            {{ HTML::image('assets_frontend/images/team/raisa.jpg', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                            <h4>Raisa Ambros MA - Editor at Social Value & Intangibles Review</h4>
                            <div class="speech">
                                <p style="font-size:125%" align="justify">Raisa is a TV presenter and a journalist. She is specialized in geopolitical reporting, 

                                    migration, intercultural and social policies both in print media and video. Her live 

                                    talk shows have focused in an interactive format on social issues of the foreign 

                                    communities in Italy. 

                                    With her language profficiency in Italian, Russian, Romanian, French and English 

                                    her role in CCEG includes co-ordination of all European activities. She is also 

                                    interested in European policies promoting the member countries and EU candidates 

                                    on the Eurocomunicazione.com platform. In her spare time she volunteers for the 

                                    NGO “Piuculture”, which operates the Infomigranti project teaching journalism to 

                                    immigrants. 

                                    She is also working on translation projects and developing her creative writing skills, 

                                    which she honed in screenwriting and narrative technique courses in Europe.

                                    Raisa is frequently invited as a speaker at conferences on integration and social 

                                    policies.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="testimonial">
                                {{ HTML::image('assets_frontend/images/team/joanne.jpg', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                                <h4>Joanne Evans MBA - Project Manager</h4>
                                <div class="speech">
                                    <p style="font-size:125%" align="justify">An experienced manager, change maker and social value specialist.

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

                                        Beetles, hand crafted arts, running, Reiki and veganism.</p>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                         <div class="col-md-6">
                            <div class="testimonial">
                                {{ HTML::image('assets_frontend/images/team/sevda.JPG', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                                <h4>Sevda Gungormus - Head of Finance</h4>
                                <div class="speech">
                                    <p style="font-size:125%" align="justify">Sevda is a trilingual finance and HR consummate professional who has worked with HNWI's and companies for 20 years. She has successfully managed start-ups to weekly transactions of UK£ 5m and knows how to scale and ensure sustainability through implementing strict process control. Her experience is cross-sectorial, from international media groups like CNN, through to large social housing providers in the UK Poplar HARCA.
                                        Sevda is a multicultural individual with home bases in the UK, France and Turkey.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="testimonial">
                                    {{ HTML::image('assets_frontend/images/team/ardrain.png', '', array( 'width' => 200, 'height' => 30, 'class'=>'img-responsive' )) }}
                                    <h4>Adrian Pryce MBA, ACIB, FHEA - Head of Capacity Development</h4>
                                    <div class="speech">
                                        <p style="font-size:125%" align="justify">An experienced educator in international business strategy and cross-cultural management and an active non-exec director and advisor to private companies and third sector organisations. 
                                            With a career spanning banking, travel & tourism and the food industry as well as academia, Adrian has a breadth of business development experience and a strong entrepreneurial flair. Fluent in Spanish after living in Spain, he has over 25 years international experience. He is a Rotarian, a non-executive director of a regional theatre and chairman of a homelessness charity and its social enterprise trading arm. 
                                            Adrian is married with three teenage children and is a keen cyclist for charity.</p>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                    <!-- End Team Section -->

                    <!-- Start Contact Section -->
                    <div class="section-modal modal fade contact" id="contact-modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-content">
                            <div class="close-modal" data-dismiss="modal">
                                <div class="lr">
                                    <div class="rl">
                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="section-title text-center">
                                        <h3>Contact With Us</h3>
                                    </br>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="footer-contact-info">
                                        <h4>Contact info</h4>
                                        <ul>
                                            <li><strong>E-mail :</strong> Olinga.Taeed@cceg.org.uk</li>
                                            <li><strong>Phone :</strong> +44 (0) 1604 892363</li>
                                            <li><strong>Mobile :</strong> +44 (0) 7798 602987</li>
                                            <li><strong>Fax:</strong>+44 (0) 1604 893537</li>
                                            <li><strong>Web :</strong> seratio.com</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="footer-social text-center">
                                        <ul>
                                            <li><a href="{{URL::to('https://twitter.com/theCCEG')}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="{{URL::to('https://www.facebook.com/TheCCEG')}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="{{URL::to('https://www.linkedin.com/company/centre-for-citizenship-enterprise-and-governance')}}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a href="{{URL::to('https://plus.google.com/+CcegOrgUk/')}}" target="_blank"><i class="fa fa-google-plus"></i></a></li>    
                                        </div>
                                    </br></br>
                                    <div class="footer-social text-center">
                                        <ul>
                                            <li><a href="{{URL::to('https://www.youtube.com/user/TheCCEG')}}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                                            <li><a href="{{URL::to('http://thecceg.blogspot.co.uk/')}}" target="_blank"><i class="fa fa-bitcoin"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="footer-contact-info">
                                        <h4>Address</h4>
                                        <ul>
                                            <li>Professor Olinga Ta’eed PhD FIoD</li>
                                            <li> Director </li>
                                            <li>Centre for Citizenship, Enterprise & Governance</li>
                                            <li>Northampton Business School, Park Campus, Boughton Green Road</li>
                                            <li>Northampton, NN2 7AL</li>
                                            <li>United Kingdom</li>
                                        </ul>
                                    </div>
                                </div>

                            </div><!--/.row -->
                            <div class="row" style="padding-top: 80px;">
                                <div class="col-md-8">
                                    <form name="sentMessage" id="contactForm" novalidate>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
                                                    <p class="help-block text-danger"></p>
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                                    <p class="help-block text-danger"></p>
                                                </div>
                                                <div class="form-group">
                                                    <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                                    <p class="help-block text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <textarea class="form-control" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                                    <p class="help-block text-danger"></p>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-lg-8 text-center">
                                                <div id="success"></div>
                                                <button type="submit" class="btn btn-primary">Send Message</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Contact Section --> 
                @stop

                @section('scripts')
                <script type="text/javascript">
                    var chart;

                    var chartData = [
                    {
                        "year": 2005,
                        "income": 23.5
                    },
                    {
                        "year": 2006,
                        "income": 26.2
                    },
                    {
                        "year": 2007,
                        "income": 30.1
                    },
                    {
                        "year": 2008,
                        "income": 29.5
                    },
                    {
                        "year": 2009,
                        "income": 24.6
                    }
                    ];


                    AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "year";
                // this single line makes the chart a bar chart,
                // try to set it to false - your bars will turn to columns
                chart.rotate = true;
                // the following two lines makes chart 3D
                chart.depth3D = 20;
                chart.angle = 30;

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridPosition = "start";
                categoryAxis.axisColor = "#DADADA";
                categoryAxis.fillAlpha = 1;
                categoryAxis.gridAlpha = 0;
                categoryAxis.fillColor = "#FAFAFA";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisColor = "#DADADA";
                valueAxis.title = "Income in millions, USD";
                valueAxis.gridAlpha = 0.1;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.title = "Income";
                graph.valueField = "income";
                graph.type = "column";
                graph.balloonText = "Income in [[category]]:[[value]]";
                graph.lineAlpha = 0;
                graph.fillColors = "#bf1c25";
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("chartdiv");
            });
</script>
@stop