<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoReal - HTML5 Real Estate Template</title>

    <meta name="description" content="EcoReal - HTML5 Bootstrap Site Template">
    <meta name="keywords" content="real estate template, bootstrap real estate template, EcoReal">
    <meta name="author" content="Ecology Theme">

    <link href='link/css.css' rel='stylesheet' type='text/css'>
    <link href='link/css_1.css' rel='stylesheet' type='text/css'>

    <!-- =========================
        FAV AND TOUCH ICONS  
    ============================== -->
    <link rel="icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

    <!-- =========================
        STYLESHEETS   
    ============================== -->
	
    <link href="link/css/bootstrap.min.css" rel="stylesheet">
	<link href="link/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="link/css/animate.css" rel="stylesheet" />
    <link href="link/css/style.css" rel="stylesheet" type="text/css" />
    <link href="link/css/responsive.css" rel="stylesheet" type="text/css" />
    
    <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="link/css/owl.carousel.css">
    
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<!-- =========================
    HEADER SECTION
============================== -->
<header>
    <div class="container">
		<div class="row header">
			<div class="col-lg-3 col-md-3 col-sm-12">
				<div class="logo">
					<a href="#"><img src="images/logo.png" alt="Logo"></a>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 header-call clearfix">
			    <p>
                    <i class="fa fa-phone pull-left"></i>
                    <span class="phone">123-456-7890</span><br/>
                    <span class="info">info@example.com</span>
				</p>
			</div>
			<div class="col-md-3 col-lg-3 col-sm-4 header-place clearfix"> 
				<p>                
    				<i class="fa fa-home pull-left"></i>
                    <span class="address-title">777 Seventh Avenue</span><br/>
                    <span class="address-desc">Downtown NY 01234</span>
				</p> 
			</div>
			<div class="col-md-3 col-lg-3 col-sm-4 header-social">
                <ul class="list-unstyled list-inline">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                </ul>
			</div>
		</div>
    </div>
</header>
<!-- =========================
   NAVIGATION SECTION
============================== -->
<!-- Navigation -->
<nav class="navbar navbar-default" id="my-navbar">
	<div class="container">
	    <div class="row">
            <div class="col-lg-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> 
                </div>
                <div class="collapse navbar-collapse main-nav" id="navbar-collapse">
                    <ul class="nav navbar-nav main-menu">
                        <li class="active"><a href="index.html">Home</a></li>
                        <li><a href="#">Pages</a>
							<ul class="list-unstyled sub-menu">
								<li><a href="sample-page.html">Sample Page</a></li>
								<li><a href="single-property.html">Single Property Page</a></li>
							</ul>
						</li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="blog-right-sidebar.html">Blog</a>
                            <ul class="list-unstyled sub-menu">
                                <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
                                <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
                                <li><a href="blog-full-width.html">Blog Full Width</a></li>
                            </ul>
                        </li>
                        <li><a href="gallery.html">Gallery</a></li>
                        <li><a href="#contact-agent">Appointment</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                    <a href="" data-toggle="modal" data-target="#myModal" class="navbar-right">Schedule Visit</a>
					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
					  <div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Appointment Form</h4>
						  </div>
						  <div class="modal-body">
							<form action="#" method="POST">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Enter Name">
								</div>
								<div class="form-group">
									<input type="email" class="form-control" placeholder="Enter Email">
								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Appontment Date">
								</div>
								<div class="form-group">
									<textarea name="message" class="form-control" placeholder="Enter Message"></textarea>
								</div>
								<button type="submit" class="btn btn-primary">Send Message</button>
							</form>
						  </div>
						  <div class="modal-footer">
						  </div>
						</div>
					  </div>
					</div><!-- End Modal -->
                </div>
            </div>
        </div> 
	</div><!-- end conainer -->
</nav><!-- end navbar -->
	
<!-- =========================
   INTRO Carousel
============================== -->
<section class="intro-carousel wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0s">
    <div class="container-fluid padding-fix">
        <div id="intro-carousel-inner" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="images/slide01.jpg" alt="First slide"/>
                    <div class="container bottom-intro">
                        <div class="row">
                            <div class="col-md-4 duplex fadincss">
                                <span><a href="">Miami City 589</a></span>
                                <span>777 Seventh Avenue<br />Downtown New York<br /> NY 01234 </span>
                            </div>
                            <div class="col-md-3 bedrooms fadincss">
                                <p><span class="room-inner-details">9,350</span> Area Sq.Ft</p>
                                <p><span class="room-inner-details">4</span> Bedrooms</p>
                                <p><span class="room-inner-details">4</span> Bathrooms</p>
                                <p><span class="room-inner-details">2</span> Garages</p>
                            </div>
                            <div class="col-md-3 price fadincss">
                                <p>$2,000,00</p>
                            </div>
                            <div class="col-md-2 details fadincss">
                                <a href="#">View Details</a>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="images/slide02.jpg" alt="Second slide"/>
                    <div class="container bottom-intro">
                        <div class="row">
                            <div class="col-md-4 duplex fadincss">
                                <span><a href="">Hiron New York 38</a></span>
                                <span>777 Seventh Avenue<br />Downtown New York<br /> NY 01234 </span>
                            </div>
                            <div class="col-md-3 bedrooms fadincss">
                                <p><span class="room-inner-details">9,560</span> Area Sq.Ft</p>
                                <p><span class="room-inner-details">3</span> Bedrooms</p>
                                <p><span class="room-inner-details">2</span> Bathrooms</p>
                            </div>
                            <div class="col-md-3 price fadincss">
                                <p>$1,350,00</p>
                            </div>
                            <div class="col-md-2 details fadincss">
                                <a href="#">View Details</a>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="images/slide05.jpg" alt="Third slide"/>
                    <div class="container bottom-intro">
                        <div class="row">
                            <div class="col-md-4 duplex fadincss">
                                <span><a href="">Florida Nw 326</a></span>
                                <span>777 Seventh Avenue<br />Downtown New York<br /> NY 01234 </span>
                            </div>
                            <div class="col-md-3 bedrooms fadincss">
                                <p><span class="room-inner-details">8,420</span> Area Sq.Ft</p>
                                <p><span class="room-inner-details">4</span> Bedrooms</p>
                                <p><span class="room-inner-details">2</span> Bathrooms</p>
                            </div>
                            <div class="col-md-3 price fadincss">
                                <p>$3,880,00</p>
                            </div>
                            <div class="col-md-2 details fadincss">
                                <a href="#">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="images/slide04.jpg" alt="Fourth slide"/>
                    <div class="container bottom-intro">
                        <div class="row">
                            <div class="col-md-4 duplex fadincss">
                                <span><a href="">San Francisco SW</a></span>
                                <span>777 Seventh Avenue<br />Downtown New York<br /> NY 01234 </span>
                            </div>
                            <div class="col-md-3 bedrooms fadincss">
                                <p><span class="room-inner-details">12,560</span> Area Sq.Ft</p>
                                <p><span class="room-inner-details">5</span> Bedrooms</p>
                                <p><span class="room-inner-details">3</span> Bathrooms</p>
                            </div>
                            <div class="col-md-3 price fadincss">
                                <p>$4,350,00</p>
                            </div>
                            <div class="col-md-2 details fadincss">
                                <a href="#">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="images/slide03.jpg" alt="Fifth slide"/>
                    <div class="container bottom-intro">
                        <div class="row">
                            <div class="col-md-4 duplex fadincss">
                                <span><a href="">Los Angeles 896</a></span>
                                <span>777 Seventh Avenue<br />Downtown New York<br /> NY 01234 </span>
                            </div>
                            <div class="col-md-3 bedrooms fadincss">
                                <p><span class="room-inner-details">7,560</span> Area Sq.Ft</p>
                                <p><span class="room-inner-details">3</span> Bedrooms</p>
                                <p><span class="room-inner-details">1</span> Bathrooms</p>
                            </div>
                            <div class="col-md-3 price fadincss">
                                <p>$1,900,00</p>
                            </div>
                            <div class="col-md-2 details fadincss">
                                <a href="#">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#intro-carousel-inner" data-slide="prev"><span><i class="fa fa-angle-left"></i></span></a>
            <a class="right carousel-control" href="#intro-carousel-inner" data-slide="next"><span><i class="fa fa-angle-right"></i></span></a>
        </div>

    </div>
</section>

<!-- =========================
    ABOUT
============================== -->
<section class="about">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<h1 class="section-heading wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">About <span>Property</span></h1>
			<p class="section-desc wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu magna metus. Donec sed erat non ipsum tincidunt pharetra ipsum tincidunt pharetra
			</p>
			</div><!-- end .col-md-12 -->
		</div><!-- end .row --> 
	</div><!-- end .container -->
</section><!-- END .about -->
<!-- =========================
   PROPERTY 
============================== -->
<section class="property">
	<div class="container-fluid property">
		<div class="row">
			<div class="col-md-3 col-sm-6 padding-fix">
				<div class="drawing-room wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.2s">
				    <img src="images/drawing_room.png" alt="" class="img-responsive">
					<div class="property-bottom">
						<p>Drawing Room</p>
					</div><!-- end .property-bottom -->
				</div><!-- end .drawing-room -->
			</div><!-- end .col-md-3 -->
			<div class="col-md-3 col-sm-6 padding-fix">
				<div class="dining-room wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.4s">
				    <img src="images/dining_room.png" alt="" class="img-responsive">
					<div class="property-bottom">
						<p>Dining Room</p>
					</div><!-- end .property-bottom -->
				</div><!-- end .dining-room -->
			</div><!-- end .col-md-3 -->
			<div class="col-md-3 col-sm-6 padding-fix">
				<div class="bed-room wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.6s">
				    <img src="images/bedroom.png" alt="" class="img-responsive">
					<div class="property-bottom">
						<p>Bed Room</p>
					</div><!-- end .property-bottom -->
				</div><!-- end .bed-room -->
			</div><!-- end .col-md-3 -->
			<div class="col-md-3 col-sm-6 padding-fix">
				<div class="kitchen-room wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.8s">
				    <img src="images/kitchen.png" alt="" class="img-responsive">
					<div class="property-bottom">
						<p>Kitchen</p>
					</div><!-- end .property-bottom -->
				</div><!-- end .kitchen-room -->
			</div><!-- end .col-md-3 -->
		</div><!-- end .row -->
	</div><!-- end container -->
</section><!-- end property section -->
<!-- =========================
    about bottom
============================== -->
<section class="about-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-sm-4 property-pros wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.2s">
				<div class="fig">
					<i class="fa fa-calendar-plus-o"></i>
				</div><!-- end .fig -->
                <span>Year of Build</span>
				<span class="fign">2009</span>		
			</div><!-- end .col-md-2 -->
			<div class="col-md-2 col-sm-4 property-pros wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.4s">
				<div class="fig">
					<i class="fa fa-bed"></i>
				</div><!-- end .fig -->
                <span>Bedrooms</span>
				<span class="fign">5</span> 
			</div><!-- end .col-md-2 -->
			<div class="col-md-2 col-sm-4 property-pros wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.6s">
				<div class="fig">
					<i class="fa fa-tint"></i>
				</div><!-- end .fig -->
                <span>Bathrooms</span>
				<span class="fign">2</span> 
			</div><!-- end .col-md-2 -->
			<div class="col-md-2 col-sm-4 property-pros wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.8s">
				<div class="fig">
					<i class="fa fa-object-group"></i>
				</div><!-- end .fig -->
                <span>Squere Feet</span>
				<span class="fign">3450</span> 
			</div><!-- end .col-md-2 -->
			<div class="col-md-2 col-sm-4 property-pros wow fadeIn" data-wow-duration="1.5s" data-wow-delay="1s">
				<div class="fig">
					<i class="fa fa-institution"></i>
				</div><!-- end .fig -->
                <span>Kitchen</span>
				<span class="fign">1</span> 
			</div><!-- end .col-md-2 -->
			<div class="col-md-2 col-sm-4 property-pros wow fadeIn" data-wow-duration="1.5s" data-wow-delay="1s">
				<div class="fig">
					<i class="fa fa-car"></i>
				</div><!-- end .fig -->
                <span>Car Parking</span>
				<span class="fign">3</span>  
			</div> <!-- end .col-md-2 -->
		</div><!-- end .row -->
	</div><!-- end .container -->
</section><!-- end .about-bottom section -->
<!-- =========================
    PROPERTY DETAIALS
============================== -->
<section class="property-details">
	<div class="container">
		<div class="row">
			<div class="col-md-6 wow slideInLeft" data-wow-duration="1.5s" data-wow-delay="0.2s">
                   <div class="property-detail">
                        <h2>Property Details</h2>
                        <div id="content">
                            <ul id="tabs" class="" data-tabs="tabs">
                                <li class="active"><a href="#1" data-toggle="tab">Interior Details</a></li>
                                <li><a href="#2" data-toggle="tab">Room Dimension</a></li>
                                <li><a href="#3" data-toggle="tab">Interior Details</a></li>
                            </ul>
                            <div id="my-tab-content" class="tab-content">
                                <div class="tab-pane active" id="1">
                                    <p>It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point </p>
                                    <div class="row"> 
                                        <div class="col-md-4 col-sm-4 water-strg">
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                        </div><!-- end .col-md-4 -->
                                        <div class="col-md-4 col-sm-4 water-strg">
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                        </div><!-- end .col-md-4 --> 
                                        <div class="col-md-4 col-sm-4 water-strg">
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                            <span><i class="fa fa-check"></i> <strong>Water Strg:</strong> 5000/ltr</span> 
                                        </div><!-- end .col-md-4 --> 
                                    </div> <!-- end .row -->
                                </div>
                                <div class="tab-pane" id="2">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point </p>
                                </div>
                                <div class="tab-pane" id="3">
                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
                                    <br />
                                    The point It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- end .property-details -->	
			</div><!-- end .col-md-6 -->
			<div class="col-md-6 property-pic wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay="0.4s">
			    <img src="images/property-details-pic.jpg" class="img-responsive" alt="">
			</div><!-- end .col-md-6 -->
		</div><!-- end .row -->
	</div><!-- end .container-fluid -->
</section><!-- end .property-details section -->
<!-- =========================
    Photo Gallery
============================== -->
<section class="photo-gallery">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1 class="section-heading wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">Photo <span>Gallery</span></h1>
				<p class="section-desc wow fadeInUp">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu magna metus. Donec sed erat non ipsum tincidunt pharetra ipsum tincidunt pharetra
				</p>
			</div><!-- end .col-md-12 -->
		</div><!-- end .row -->
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
				<div class="controls">
                        <button class="filter" data-filter="all">All</button>
                        <button class="filter" data-filter=".bedroom">Bedroom</button>
                        <button class="filter" data-filter=".bathroom">Bathroom</button>
                        <button class="filter" data-filter=".kitchen">Kitchen</button>
                        <button class="filter" data-filter=".garage">Garage</button>
                        <button class="filter" data-filter=".basement">Basement</button>
                </div>
                <div id="container-mix" class="container-mix grid-effect">
                    <div class="mix bedroom col-md-4 col-sm-6 padding-fix" data-myorder="1">
                        <figure class="effect-zoe">
							<img src="images/image1.png" alt="img25"/>
							<figcaption>
								<a href=""><h3>EcoReal Home</h3></a>
							</figcaption>			
						</figure>
                    </div>
                    <div class="mix bathroom col-md-4 col-sm-6 padding-fix" data-myorder="2">
                        <figure class="effect-zoe">
							<img src="images/image2.png" alt="img25"/>
							<figcaption>
								<a href=""><h3>Single Family Home</h3></a>
							</figcaption>			
						</figure>
                    </div>
                    <div class="mix kitchen col-md-4 col-sm-6 padding-fix" data-myorder="3">
                        <figure class="effect-zoe">
							<img src="images/image6.png" alt="img25"/>
							<figcaption>
								<a href=""><h3>Multifamily</h3></a>
							</figcaption>			
						</figure>
                    </div>
                    <div class="mix garage col-md-4 col-sm-6 padding-fix" data-myorder="4">
                        <figure class="effect-zoe">
							<img src="images/image4.png" alt="img25"/>
							<figcaption>
								<a href=""><h3>Luxury Family Home</h3></a>
							</figcaption>			
						</figure>
                    </div>
                    <div class="mix basement col-md-4 col-sm-6 padding-fix" data-myorder="5">
                        <figure class="effect-zoe">
							<img src="images/image5.png" alt="img25"/>
							<figcaption>
								<a href=""><h3>Goodwin Avenue</h3></a>
							</figcaption>			
						</figure>
                    </div>
                    <div class="mix bedroom col-md-4 col-sm-6 padding-fix" data-myorder="6">
                        <figure class="effect-zoe">
							<img src="images/image3.png" alt="img25"/>
							<figcaption>
								<a href=""><h3>Burnside Court</h3></a>
							</figcaption>			
						</figure>
                    </div>
                </div>
			</div><!-- end .col-md-12 -->
		</div><!-- end .row --> 
	</div><!-- end .container -->
	<!-- Navigation --> 
</section><!-- END .about --> 

<!-- =========================
    Nearby Place
============================== -->
<section class="nearby-place">
	<div class="container">
		<div class="row">
			<div class="col-md-12"> 
				<div class="nearby">
					<h1 class="section-heading wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">Nearby <span>Place</span></h1>
					<p class="section-desc wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu magna metus. Donec sed erat non ipsum tincidunt pharetra ipsum tincidunt pharetra</p> 
				</div>
			</div><!-- end .col-md-12 -->
		</div><!-- end .row --> 
	</div><!-- end .container -->
</section><!-- END .about -->
<!-- =========================
    Nearby Place location
============================== -->
<section class="nearby-places">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 location wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.2s">
                <i class="fa fa-book"></i>
                <div class="club">
                    <span class="school">School</span>
                    <span class="school-name">New York Art School</span>
                    <span class="school-distance">1 km</span>
                </div>
            </div><!-- end .col-md-3 -->
            <div class="col-md-3 col-sm-6 location wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.4s">
                <i class="fa fa-flag-o"></i>
                <div class="club">
                    <span class="school">Golf Club</span>
                    <span class="golf">NYC Golf Club</span>
                    <span class="golf-distance">2 km</span>
                </div>
            </div><!-- end .col-md-3 -->
            <div class="col-md-3 col-sm-6 location wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.6s">
                <i class="fa fa-hospital-o"></i>
                <div class="club">
                    <span class="school">Hospital</span>
                    <span class="hopital">NYC Hostpital Center</span>
                    <span class="hopital-distance">4 km</span>
                </div>
            </div><!-- end .col-md-3 -->
            <div class="col-md-3 col-sm-6 location wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.8s">
                <i class="fa fa-coffee"></i>
                <div class="club">
                    <span class="school">Resturent</span>
                    <span class="resturent">NYC Spicy Resturent</span>
                    <span class="resturent-distance">6 km</span>
                </div>
            </div><!-- end .col-md-3 --> 
        </div><!-- end .row -->
    </div><!--end .container -->
</section> 
<!-- =========================
    Google Map 
============================== -->
<section class="google-map">
    <div class="container-fluid padding-fix wow zoomIn" data-wow-duration="1.5s" data-wow-delay="0.5s">
        <div class="row">
            <div class="col-md-12">
                <div id="property-map"></div>
            </div><!-- end .col-md-12 -->
        </div><!-- end .row -->
    </div><!-- end .container-fluid -->
</section>
<!-- =========================
   Latest Property
============================== -->
<section class="latest-property">
	<div class="container">
		<div class="row">
			<div class="col-md-12"> 
				<div class="property">
					<h1 class="section-heading wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">Latest <span>Properties</span></h1>
					<p class="section-desc wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis eu magna metus. Donec sed erat non ipsum tincidunt pharetra ipsum tincidunt pharetra</p> 
				</div>
			</div><!-- end .col-md-12 -->
		</div><!-- end .row --> 
	</div><!-- end .container -->
</section><!-- END .latest-property -->
<!-- =========================
   Latest Property
============================== -->
<section class="property-lists">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
                <div class="latest-pic1"> 
                </div><!-- end .latest-pic -->
                <div class="latest-pic-bottom">
                    <div class="pic-address">125 Park Aveneu 77, Alabama <span>$2,50,000</span></div><!-- end .pic-address -->
                    <div class="description-wrap">
                        <div class="pic-description">
                            <h3><a href="">Black Orchid Villa</a></h3>
                            <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical.
                        </div><!-- end .pic-description -->
                        <div class="pic-mesure">
                            <span><i class="fa fa-object-group"></i> 800 sq ft</span>
                            <span><i class="fa fa-bed"></i> 2 Badrooms</span>
                            <span><i class="fa fa-retweet"></i> 2 Baths</span> 
                        </div><!-- end .pic-mesure -->
                    </div><!-- end .desctription-wrapper -->
                </div> <!-- end .latest-pic-bottom -->       
            </div><!-- end .col-md-4 -->
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
                <div class="latest-pic2"> 
                </div><!-- end .latest-pic -->
                <div class="latest-pic-bottom">
                    <div class="pic-address">125 Park Aveneu 77, Alabama <span>$2,50,000</span></div><!-- end .pic-address --> 
                    <div class="description-wrap">
                        <div class="pic-description">
                            <h3><a href="">Black Orchid Villa</a></h3>
                            <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical.
                        </div><!-- end .pic-description -->
                        <div class="pic-mesure">
                            <span><i class="fa fa-object-group"></i> 1200 sq ft</span>
                            <span><i class="fa fa-bed"></i> 2 Badrooms</span>
                            <span><i class="fa fa-retweet"></i> 1 Baths</span> 
                        </div><!-- end .pic-mesure -->
                    </div><!-- end .desctription-wrapper -->
                </div> <!-- end .latest-pic-bottom -->       
            </div><!-- end .col-md-4 -->
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
                <div class="latest-pic3"> 
                </div><!-- end .latest-pic -->
                <div class="latest-pic-bottom">
                    <div class="pic-address">125 Park Aveneu 77, Alabama <span>$2,50,000</span></div><!-- end .pic-address --> 
                    <div class="description-wrap">
                        <div class="pic-description">
                            <h3><a href="">Black Orchid Villa</a></h3>
                            <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical.
                        </div><!-- end .pic-description -->
                        <div class="pic-mesure">
                            <span><i class="fa fa-object-group"></i> 1400 sq ft</span>
                            <span><i class="fa fa-bed"></i> 2 Badrooms</span>
                            <span><i class="fa fa-retweet"></i> 2 Baths</span> 
                        </div><!-- end .pic-mesure -->
                    </div><!-- end .desctription-wrapper -->
                </div> <!-- end .latest-pic-bottom -->       
            </div><!-- end .col-md-4 --> 
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
                <div class="latest-pic4"> 
                </div><!-- end .latest-pic -->
                <div class="latest-pic-bottom">
                    <div class="pic-address">125 Park Aveneu 77, Alabama <span>$2,50,000</span></div><!-- end .pic-address --> 
                    <div class="description-wrap">
                        <div class="pic-description">
                            <h3><a href="">Black Orchid Villa</a></h3>
                            <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical.
                        </div><!-- end .pic-description -->
                        <div class="pic-mesure">
                            <span><i class="fa fa-object-group"></i> 2200 sq ft</span>
                            <span><i class="fa fa-bed"></i> 4 Badrooms</span>
                            <span><i class="fa fa-retweet"></i> 3 Baths</span> 
                        </div><!-- end .pic-mesure -->
                    </div><!-- end .desctription-wrapper -->
                </div> <!-- end .latest-pic-bottom -->       
            </div><!-- end .col-md-4 -->
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
                <div class="latest-pic5"> 
                </div><!-- end .latest-pic -->
                <div class="latest-pic-bottom">
                    <div class="pic-address">125 Park Aveneu 77, Alabama <span>$2,50,000</span></div><!-- end .pic-address --> 
                    <div class="description-wrap">
                        <div class="pic-description">
                            <h3><a href="">Black Orchid Villa</a></h3>
                            <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical.
                        </div><!-- end .pic-description -->
                        <div class="pic-mesure">
                            <span><i class="fa fa-object-group"></i> 1800 sq ft</span>
                            <span><i class="fa fa-bed"></i> 4 Badrooms</span>
                            <span><i class="fa fa-retweet"></i> 3 Baths</span>  
                        </div><!-- end .pic-mesure -->
                    </div><!-- end .desctription-wrapper -->
                </div> <!-- end .latest-pic-bottom -->       
            </div><!-- end .col-md-4 -->
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
                <div class="latest-pic6"> 
                </div><!-- end .latest-pic -->
                <div class="latest-pic-bottom">
                    <div class="pic-address">125 Park Aveneu 77, Alabama <span>$2,50,000</span></div><!-- end .pic-address --> 
                    <div class="description-wrap">
                        <div class="pic-description">
                            <h3><a href="">Black Orchid Villa</a></h3>
                            <p>Lorem Ipsum is not simply random text. It has roots in a piece of classical.
                        </div><!-- end .pic-description -->
                        <div class="pic-mesure">
                            <span><i class="fa fa-object-group"></i> 1500 sq ft</span>
                            <span><i class="fa fa-bed"></i> 3 Badrooms</span>
                            <span><i class="fa fa-retweet"></i> 2 Baths</span> 
                        </div><!-- end .pic-mesure -->
                    </div><!-- end .desctription-wrapper -->
                </div> <!-- end .latest-pic-bottom -->       
            </div><!-- end .col-md-4 --> 
        </div><!-- end .row -->  
    </div><!-- end .container --> 
</section>
<!-- =========================
    contract
============================== -->
<section class="contract-section" id="contact-agent">
    <div class="container">
        <div class="contract-border">
            <div class="contract">
                <div class="row">
                    <div class="col-md-4 col-sm-12 contract-left wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">
                        <h2>Contract Agent</h2>
                        <form action="">
                            <p><input type="text" placeholder="NAME" name="name"></p>
                            <p><input type="email" placeholder="E-mail" name="email"></p>
                            <p><textarea Placeholder="MASSAGE" name="message"></textarea></p>
                            <p><input class="submit" type="submit" value="SEND" name="submit"></p>
                        </form>
                    </div><!-- end .col-md-4 -->
                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.4s">
                        <div class="contract-right">
                            <h2>John Doe</h2>
                            <h3>Senior Agent of ECOREAL</h3>
                            <p>Lorem ipsum dolor sit amet,  dolor sit amet,  dolorsian adipiscing elit. Duis eu magna metus. Donec sed erat nonconsectetur adipiscing elit. Duis eu magna</p>
                            <span>+0123-456-789 <i class="fa fa-phone"></i></span>
                            <span>email@yourdomain.com <i class="fa fa-envelope"></i></span>
                            <div class="contract-social header-social">
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div><!-- end .contract-social -->
                        </div>
                    </div><!-- end .col-md-5 -->
                    <div class="col-md-4 contract-pic col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.6s">
                        <img src="images/women-agent.png" alt="" />
                    </div><!-- end .col-md-4 -->  
    
                </div><!-- end .row -->
            </div><!-- end .col-md-8 -->
        </div><!-- end .row -->
    </div><!-- end .container-fluid -->
</section>
<!-- =========================
    Sell Property
============================== -->
<section class="sell-property">
    <div class="banner-overlay">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.4s">
                    <div class="call-us">
                        <h3>Do you want ot sell your property</h3>
                        <span>Call us and list your property here</span>
                    </div><!-- end .call-us -->
                </div><!-- end .col-md-6 -->
                <div class="col-md-6 col-sm-6 sell-contact wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.6s">
                    <span>+0123-456-789</span><a href="#">Just Contact us</a>
                </div><!-- end .col-md-6 -->
            </div>
        </div>
	</div>
</section>
<!-- =========================
   Blog
============================== -->
<section class="our-blog">
	<div class="container">
		<div class="row">
			<div class="col-md-12"> 
				<div class="blog">
					<h1 class="section-heading wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">Our <span>Blog</span></h1>
				</div>
			</div><!-- end .col-md-12 -->
		</div><!-- end .row --> 
	</div><!-- end .container -->
</section><!-- END .latest-property -->
<div class="container">
	<div class="row blog-row-one">
		<div class="col-md-6 wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.3s">
			<div class="blog-pic"> 
				<div class="blog-content">
					<span class="blog-admin">Admin</span>
					<span class="blog-date">20/02/2015</span>
					<h4>It's much cheaper to by than to rent</h4>
					<p>
						It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
					</p>
					<a href="#">Read More</a>
				</div><!-- end .blog-content -->
			</div><!-- end .blog-pic -->
		</div><!-- end .col-md-6 -->
		<div class="col-md-6 wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.6s">
			<div class="blog-pic2"> 
				<div class="blog-content">
					<span class="blog-admin">Admin</span>
					<span class="blog-date">20/02/2015</span>
					<h4>It's much cheaper to by than to rent</h4>
					<p>
						It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
					</p>
					<a href="#">Read More</a>
				</div><!-- end .blog-content -->
			</div><!-- end .blog-pic -->
		</div><!-- end .col-md-6 --> 
	</div><!-- end .row --> 
</div><!-- end .container -->
<div class="container">
	<div class="row">
		<div class="col-md-6 wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.3s">
			<div class="blog-pic4"> 
				<div class="blog-content3">
					<span class="blog-admin3">Admin</span>
					<span class="blog-date3">20/02/2015</span>
					<h4>It's much cheaper to by than to rent</h4>
					<p>
						It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
					</p>
					<a href="#">Read More</a>
				</div><!-- end .blog-content -->
			</div><!-- end .blog-pic -->
		</div><!-- end .col-md-6 -->
		<div class="col-md-6 wow fadeIn" data-wow-duration="1.5s" data-wow-delay="0.6s">
			<div class="blog-pic3"> 
				<div class="blog-content3">
					<span class="blog-admin3">Admin</span>
					<span class="blog-date3">20/02/2015</span>
					<h4>It's much cheaper to by than to rent</h4>
					<p>
						It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. 
					</p>
					<a href="#">Read More</a>
				</div><!-- end .blog-content -->
			</div><!-- end .blog-pic -->
		</div><!-- end .col-md-6 --> 
	</div><!-- end .row --> 
</div><!-- end .container -->
<!-- =========================
    Testimonials
============================== -->
<section class="testimonials"> 
	<div class="container">
		<div class="row">
			<div class="col-md-12"> 
				<div class="testimonials-title">
					<h1 class="section-heading wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0s">Testi<span>Monials</span></h1>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="container-fluid padding-fix">
	<div class="row">
	    <div id="testimonial-carousel" class="testimonial-carousel wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.5s">
            <div class="col-md-4 width-fix">
                <div class="testimonial-comment">
                    <p>It is a long established fact that a reader will be dis-tracted by the readable content of a page when looking at its layout. The poing of using lorem ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content, making it look like readable English.</p>
                </div>
                <div class="testimonial-author">
                    <img src="images/testimonial-author.jpg" alt="" class="img-circle">
                    <p>
                        <span class="tauthor-name">Ben Kingsly</span>
                        <span class="tauthor-role">CEO - Royals Group</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4 width-fix">
                <div class="testimonial-comment">
                    <p>It is a long established fact that a reader will be dis-tracted by the readable content of a page when looking at its layout. The poing of using lorem ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content, making it look like readable English.</p>
                </div>
                <div class="testimonial-author">
                    <img src="images/testimonial-author.jpg" alt="" class="img-circle">
                    <p>
                        <span class="tauthor-name">Ben Kingsly</span>
                        <span class="tauthor-role">CEO - Royals Group</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4 width-fix">
                <div class="testimonial-comment">
                    <p>It is a long established fact that a reader will be dis-tracted by the readable content of a page when looking at its layout. The poing of using lorem ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content, making it look like readable English.</p>
                </div>
                <div class="testimonial-author">
                    <img src="images/testimonial-author.jpg" alt="" class="img-circle">
                    <p>
                        <span class="tauthor-name">Ben Kingsly</span>
                        <span class="tauthor-role">CEO - Royals Group</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4 width-fix">
                <div class="testimonial-comment">
                    <p>It is a long established fact that a reader will be dis-tracted by the readable content of a page when looking at its layout. The poing of using lorem ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content, making it look like readable English.</p>
                </div>
                <div class="testimonial-author">
                    <img src="images/testimonial-author.jpg" alt="" class="img-circle">
                    <p>
                        <span class="tauthor-name">Ben Kingsly</span>
                        <span class="tauthor-role">CEO - Royals Group</span>
                    </p>
                </div>
            </div>
            <div class="col-md-4 width-fix">
                <div class="testimonial-comment">
                    <p>It is a long established fact that a reader will be dis-tracted by the readable content of a page when looking at its layout. The poing of using lorem ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content, making it look like readable English.</p>
                </div>
                <div class="testimonial-author">
                    <img src="images/testimonial-author.jpg" alt="" class="img-circle">
                    <p>
                        <span class="tauthor-name">Ben Kingsly</span>
                        <span class="tauthor-role">CEO - Royals Group</span>
                    </p>
                    <div class="clear"></div>
                </div>
            </div>
			<div class="col-md-4 width-fix">
                <div class="testimonial-comment">
                    <p>It is a long established fact that a reader will be dis-tracted by the readable content of a page when looking at its layout. The poing of using lorem ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content, making it look like readable English.</p>
                </div>
                <div class="testimonial-author">
                    <img src="images/testimonial-author.jpg" alt="" class="img-circle">
                    <p>
                        <span class="tauthor-name">Ben Kingsly</span>
                        <span class="tauthor-role">CEO - Royals Group</span>
                    </p>
                    <div class="clear"></div>
                </div>
            </div>
			<div class="col-md-4 width-fix">
                <div class="testimonial-comment">
                    <p>It is a long established fact that a reader will be dis-tracted by the readable content of a page when looking at its layout. The poing of using lorem ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content, making it look like readable English.</p>
                </div>
                <div class="testimonial-author">
                    <img src="images/testimonial-author.jpg" alt="" class="img-circle">
                    <p>
                        <span class="tauthor-name">Ben Kingsly</span>
                        <span class="tauthor-role">CEO - Royals Group</span>
                    </p>
                    <div class="clear"></div>
                </div>
            </div>
	    </div>
    </div>
</div>

<!-- =========================
FOOTER
============================== -->
<footer class="footer">
<div class="footer-overlay">
    <div class="container">
		<div class="row subscribe">
			<form id="mc-form"> 
				<div class="col-md-5 newsletter"> 
					<span>Subscribe to our newsletter</span> 
				</div><!-- end .col-md-5 -->
				<div class="col-md-5 subscribe-email">
					<input type="email" placeholder="Email Address" id="mc-email">
				</div><!-- end .col-md-5 -->
				<div class="col-md-2">
					<input type="submit" value="Subscribe"> 
				</div><!-- end .col-md-2 -->
			</form>				
		</div><!-- end .row -->
		<div class="footer-middle">
				<div class="row">
					<div class="col-md-3 col-sm-6">
						<div class="footer-widget about-us">
							<h3>About us</h3>
							<p>Proin sed accumsan justo Morbi nec convallis dui in rhoncus sem Duis nec ipsum sagittis mattis turpis quis, luctus urna Fusce gravida dictum lectus ut interdum.</p>
						</div><!-- end .about-us -->
						<div class="social-widget-links">  
							<ul class="list-unstyled list-inline">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul> 
						</div>
					</div><!-- end .col-md-3 -->
					<div class="col-md-3 col-sm-6">
						<div class="footer-widget twitter-widget">
							<h3>Latest Tweets</h3>
							<p class="clearfix">
								<span class="twittes-icon pull-left"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></span>
								<span class="twittes">Proin sed accumsan justo Morbi nec convallis dui in <a href="#">http://yourtwitternamehere/ourtwitternamehere</a> 1 hours ago</span>
							</p>
							<p class="clearfix">
								<span class="twittes-icon pull-left"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i>
								</span><span class="twittes">Proin sed accumsan justo Morbi nec convallis dui in <a href="#">http://yourtwitternamehere/ourtwitternamehere</a> 1 hours ago</span>
							</p>
						</div><!-- end .about-us -->
					</div><!-- end .col-md-3 -->
					<div class="col-md-3  col-sm-6">
						<div class="footer-widget latest-news">
							<h3>Your Blog</h3>
                            <p class="pic1"><img src="images/post1.png" alt="" class="img-responsive pull-left" /> <a href="">sed do eiusmod tem incididunt ut labore</a> <span>Jan 9, 2016</span></p>
							<p class="pic2"><img src="images/post2.png" alt="" class="img-responsive pull-left" /> <a href="">sed do eiusmod tem incididunt ut labore</a> <span>Jan 9, 2016</span></p>
							<p class="pic3"><img src="images/post3.png" alt="" class="img-responsive pull-left" /> <a href="">sed do eiusmod tem incididunt ut labore</a> <span>Jan 9, 2016</span></p>
						</div><!-- end .about-us -->
					</div><!-- end .col-md-3 -->
					<div class="col-md-3 col-sm-6">
						<div class="footer-widget contact-info">
							<h3>Contact Info</h3>
							<div class="contact-info">
								<p class="clearfix">
									<span class="contact-icon pull-left"><i class="fa fa-map-marker fa-2x"></i></span>
									<span class="contact-details">777 seventh avenue,Downtown New York,NY 01234</span>
									
								</p>
								<p class="clearfix">
									<span class="contact-icon pull-left"><i class="fa fa-envelope fa-2x"></i></span>
									<span class="contact-details">email@yourdomain.com</span>
								</p>
								<p class="clearfix">
									<span class="contact-icon pull-left"><i class="fa fa-phone fa-2x"></i></span>
									<span class="contact-details">0123-456-7890</span>
								</p>
								<p class="clearfix">
									<span class="contact-icon pull-left"><i class="fa fa-globe fa-2x"></i></span>
									<span class="contact-details">www.yourwebsite.com</span>
								</p>
							</div>
						</div>
					</div>
				</div>
		</div><!-- end .footer-middle -->
	</div>
	<section class="footer-below">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 copy-right">
					<p>Copyright &copy; 2016 <a href="http://ecologytheme.com">Ecology Theme</a> All rights reserved</p>
				</div><!-- end .col-md-6 -->
				<div class="col-md-6 col-sm-6 payment">
				    <ul class="list-unstyled list-inline">
				        <li><span>We Accept:</span></li>
				        <li><i class="fa fa-cc-paypal" aria-hidden="true"></i></li>
				        <li><i class="fa fa-cc-stripe" aria-hidden="true"></i></li>
				        <li><i class="fa fa-cc-visa" aria-hidden="true"></i></li>
				        <li><i class="fa fa-cc-mastercard" aria-hidden="true"></i></li>
                    </ul>
				</div><!-- end .col-md-6 -->
			</div><!-- end .row -->
		</div><!-- end .containter -->
	</section>
</div>
</footer><!-- /END FOOTER SECTION -->

<!-- =========================
    SCRIPTS 
============================== -->
	<script src="script/js/jquery.js"></script>
	<script src="script/js/bootstrap.min.js"></script>
	<script src="script/js/jquery.mixitup.js"></script>
	<script src="script/js/main.js"></script>
	<!-- Owl Carousel JS-->
    <script src="script/js/owl.carousel.js"></script>
    <!-- Google Map -->
    <script src='script/maps/api/js.js'></script> 
	<script src="script/js/google-map.js"></script>
	<script src="script/js/wow.min.js"></script>
	
	<!-- AjaxChimp JS -->
    <script src="script/js/jquery.ajaxchimp.js"></script>
	
</body>
</html>
