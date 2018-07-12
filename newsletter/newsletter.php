<?php
/**
 * The template for newsletter posts
 * 
 * @package WordPress
 * @subpackage Aaron_Salley_Design
 * @since Aaron Salley Design 2014 1.1
*/
?>
<html>
<head>
    <meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>" />
    
	<title><?php wp_title( '|', true, 'right' ); ?></title>
   	<style type="text/css">
    @import url(http://fonts.googleapis.com/css?family=Lato);
    /* NOTE: CSS should be inlined to avoid having it stripped in certain email clients like GMail. 
    MailChimp automatically inlines CSS for you or you can use this tool: http://beaker.mailchimp.com/inline-css. */
    
        /* Client-specific Styles */
        #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" button. */
        body{width:100% !important;} /* Force Hotmail to display emails at full width */
        body{-webkit-text-size-adjust:none;} /* Prevent Webkit platforms from changing default text sizes. */

        /* Reset Styles */
        body{margin:0; padding:0;}
        img{border:none; font-size:14px; font-weight:bold; height:auto; line-height:100%; outline:none; text-decoration:none; text-transform:capitalize;}
        #backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}

        /* Template Styles */
		h1 { font-weight:400; font-size:64px; font-family:"Lato"; text-align:center;	}
		a { color:inherit; text-decoration:none; }
		a:hover { color: #D15400; !important; -webkit-transition-property: color; -webkit-transition-duration: 1s; -webkit-transition-timing-function: linear; }
		body { 	color: #2C3E50; font-weight:300; font-family:"Lato"; }
		address { font-style:normal; }
		p { font-weight:300; font-size:14px; font-family:"Lato"; }
		.widget { display: inline-block; }
		.widget_nav_menu { float: right; position: relative; top: .75em; }
		.menu li { display: inline-block; padding-left: 1em; }
		.menu li a { background-image: url(http://design.aaronsalley.com/wp-content/themes/design2014.0.2/img/social_links_spry.png); background-repeat:no-repeat; display: block; font-weight:100; font-size:1px; line-height:40px; font-family:"Lato";height: 36px; overflow: hidden; text-indent: 40px;  width: 36px; }
		.menu li a:hover { background-image: url(http://design.aaronsalley.com/wp-content/themes/design2014.0.2/img/social_links_hover_spry.png); background-repeat:no-repeat; }
		.menu li.facebook a, .menu li.facebook a:hover { background-position: 0px 0px; }
		.menu li.twitter a, .menu li.twitter a:hover { background-position: -56px 0px; }
		.menu li.behance a, .menu li.behance a:hover { background-position: -113px 0px;	}
		.menu li.pinterest a, .menu li.pinterest a:hover { background-position: -170px 0px;	}
		.menu li.tumblr a, .menu li.tumblr a:hover { background-position: -227px 0px; }
	</style>
</head>

    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<center>
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable">
            	<tr>
                	<td align="center" valign="top">
                    	<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainer">
                        	<tr style="background-color:#CCC;border-bottom: 3px solid green;">
                            	<td align="center" valign="top">
                                    
                                    <!-- // Begin Template Header \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateHeader">
                                        <tr>
                                            <td><a href="<?php echo home_url(); ?>" style="font-weight:400;"><?php bloginfo( 'name' ); ?></a></td>
                                            <td style="color:#999;text-align:right;font-size:10px;">Is this email not displaying correctly?<br /><a href="<?php the_permalink(); ?>" target="_blank">View it in your browser</a>.</td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Header \\ -->
                                </td>
                            </tr>
                        	<tr style="background-color:white;">
                            	<td align="center" valign="top">
                                    <!-- // Begin Template Body \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateBody">
                                    	<tr>
                                            <td valign="top" class="bodyContent">
                                                <?php while ( have_posts() ) the_post();
                                                the_post_thumbnail();
                                                the_content(); ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Body \\ -->
                                </td>
                            </tr>
                        	<tr style="background-color:#2C3E50;">
                            	<td align="center" valign="top">
                                    
                                    <!-- // Begin Template Footer \\ -->
                                	<table border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter">
                                    	<tr>
                                            <td valign="middle" id="social" style="color:#EAEEEF;">
                                            	<?php dynamic_sidebar( 'sidebar-1' ); ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // End Template Footer \\ -->
                                </td>
                            </tr>
                        </table>
                        <br />
                    </td>
                </tr>
            </table>
        </center>
        <?php wp_footer(); ?>
    </body>
</html>