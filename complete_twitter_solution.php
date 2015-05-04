<?php

/**

 * @package complete-twitter-solution 

*/

/*

Plugin Name: Complete Twitter Solution 

Plugin URI: http://www.audaciotech.com

Description: Thanks for installing Complete Twitter Solution - Unique Twitter Display Widget for Wordpress.

Version: 1.0

Author: Audacio Tech IT

Author URI: http://www.audaciotech.com

*/



class ComTtwitterSolution extends WP_Widget{

    public function __construct() {

        $params = array(

            'description' => 'Thanks for installing Complete Twitter Solution - Unique Twitter Display Widget for Wordpress.',

            'name' => 'Complete Twitter Solution  '

        );

        parent::__construct('ComTtwitterSolution','',$params);


function twitter_scripts() {
    
      wp_register_style( 'myStyleSheet', plugins_url('assets/twitterstyle.css', __FILE__) );
      wp_enqueue_style( 'myStyleSheet');
}

add_action( 'wp_enqueue_scripts', 'twitter_scripts' );



 require_once( plugin_dir_path( __FILE__ ) . 'TwitterAPIExchange.php');


    }


 
    

    public function form($instance) {

        extract($instance);

        

        ?>

<!-- here will put all widget configuration -->

<p>

    <label for="<?php echo $this->get_field_id('tUsername');?>">User Name : </label>

    <input

	class="widefat"

	id="<?php echo $this->get_field_id('tUsername');?>"

	name="<?php echo $this->get_field_name('tUsername');?>"

        value="<?php echo !empty($tUsername) ? $tUsername : "twitter"; ?>" />

</p>

<p>

    <label for="<?php echo $this->get_field_id('width');?>">Width : </label>

    <input

	class="widefat"

	id="<?php echo $this->get_field_id('width');?>"

	name="<?php echo $this->get_field_name('width');?>"

        value="<?php echo !empty($width) ? $width : "300"; ?>" />

</p>

<p>

    <label for="<?php echo $this->get_field_id('consumerKey');?>">Consumer Key : </label>

    <input

	class="widefat"

	id="<?php echo $this->get_field_id('consumerKey');?>"

	name="<?php echo $this->get_field_name('consumerKey');?>"

        value="<?php echo !empty($consumerKey) ? $consumerKey : ""; ?>" />

</p>

<p>

    <label for="<?php echo $this->get_field_id('consumerSecret');?>">Consumer Secret : </label>

    <input

	class="widefat"

	id="<?php echo $this->get_field_id('consumerSecret');?>"

	name="<?php echo $this->get_field_name('consumerSecret');?>"

        value="<?php echo !empty($consumerSecret) ? $consumerSecret : ""; ?>" />

</p>

<p>

    <label for="<?php echo $this->get_field_id('accessToken');?>">Access Token : </label>

    <input

	class="widefat"

	id="<?php echo $this->get_field_id('accessToken');?>"

	name="<?php echo $this->get_field_name('accessToken');?>"

        value="<?php echo !empty($accessToken) ? $accessToken : " "; ?>" />

</p>

<p>

    <label for="<?php echo $this->get_field_id('Token');?>">Access Token Secret : </label>

    <input

	class="widefat"

	id="<?php echo $this->get_field_id('accessTokenSecret');?>"

	name="<?php echo $this->get_field_name('accessTokenSecret');?>"

        value="<?php echo !empty($accessTokenSecret) ? $accessTokenSecret : ""; ?>" />

</p>







<p>

    <label for="<?php echo $this->get_field_id( 'header' ); ?>">Show Header:</label> 

    <select id="<?php echo $this->get_field_id( 'header' ); ?>"

        name="<?php echo $this->get_field_name( 'header' ); ?>"

        class="widefat" style="width:100%;">

            <option value="true" <?php if ($header == 'true') echo 'selected="true"'; ?> >Yes</option>

            <option value="false" <?php if ($header == 'false') echo 'selected="false"'; ?> >No</option>	

    </select>

</p>

<p>

    <label for="<?php echo $this->get_field_id( 'footer' ); ?>">Show Footer:</label> 

    <select id="<?php echo $this->get_field_id( 'footer' ); ?>"

        name="<?php echo $this->get_field_name( 'footer' ); ?>"

        class="widefat" style="width:100%;">

            <option value="true" <?php if ($footer == 'true') echo 'selected="true"'; ?> >Yes</option>

            <option value="false" <?php if ($footer == 'false') echo 'selected="false"'; ?> >No</option>	

    </select>

</p>




<p>

    <label for="<?php echo $this->get_field_id('connections');?>">No of Connections: </label>

    <input

	class="widefat"

	id="<?php echo $this->get_field_id('connections');?>"

	name="<?php echo $this->get_field_name('connections');?>"

        value="<?php echo !empty($connections) ? $connections : "15"; ?>" />

</p>








<?php

    }

    

    public function widget($args, $instance) {

        extract($args);

        extract($instance);

        $title = apply_filters('widget_title', $title);

        $description = apply_filters('widget_description', $description);

	    if(empty($title)) $title = "Complete Twitter Solution  ";

        if(empty($tUsername)) $tUsername = "twitter";

        if(empty($width)) $width = "300";

        if(empty($consumerKey)) $consumerKey = "";

         if(empty($consumerSecret)) $consumerSecret = "";

           if(empty($accessToken)) $accessToken = "";

        if(empty($accessTokenSecret)) $accessTokenSecret = "";


        if(empty($connections)) $connections ="15";

        if(empty($header)) $header = "true";

   


        echo $before_widget;

            echo $before_title . $title . $after_title;

            

            ?>



<?php




$settings = array(

        'oauth_access_token' => trim($accessToken),
        'oauth_access_token_secret' => trim($accessTokenSecret),
        'consumer_key' => trim($consumerKey),
        'consumer_secret' => trim($consumerSecret)

);



$urlUserInformation = "https://api.twitter.com/1.1/users/show.json";
$url = "https://api.twitter.com/1.1/followers/list.json";
$requestMethod = "GET";
$getFollowers = "?cursor=-1&screen_name=$tUsername&skip_status=true&include_user_entities=false";
$twitter = new TwitterAPIExchange($settings);
$stringUserInfo = json_decode($twitter->setGetfield($getFollowers)
->buildOauth($urlUserInformation, $requestMethod)
->performRequest(),$assoc = TRUE);
$string_follow = json_decode($twitter->setGetfield($getFollowers)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);

$followers = $stringUserInfo['followers_count'];



?>



	<div id="advanced_twitter_followers_widget" style=" max-width: <?php echo $width; ?>px; background: #ffffff;">
		<div id="twitterWidget" class="twitterFollowers">
			<div class="likebox-border">
				<div id="likebox">
				<?php if($header == "true"){ ?>
					<div class="findus" style=" background: #cccccc; color: #ffffff; ">Follow Us On Twitter</div>
				<?php }?>
					<div class="floatelement">
						<div class="thumb-img"><a href="//twitter.com/<?php echo $stringUserInfo['screen_name']; ?>" target="_blank"><img src="<?php echo $stringUserInfo['profile_image_url']; ?>"></a></div>
						<div class="right-text"><p class="title"><a href="//twitter.com/<?php echo $stringUserInfo['screen_name']; ?>" target="_blank"><?php echo $stringUserInfo['name']; ?></a></p>
						<a class="follow-btn" href="//twitter.com/<?php echo $stringUserInfo['screen_name']; ?>" target="_blank"><span></span> Follow</a></div>						
						<div class="clr"></div>
					</div>

        
				
                
 <div class="wrap">

        <?php

        /*URL - Twitter Timeline*/

    $url_user = "https://api.twitter.com/1.1/statuses/user_timeline.json";

    $requestMethod = "GET";

    $getfield = '?screen_name='.$tUsername.'&count='.$count;

     

    $twitter = new TwitterAPIExchange($settings);

    $string = json_decode($twitter->setGetfield($getfield)

    ->buildOauth($url_user, $requestMethod)

    ->performRequest(),$assoc = TRUE);



function addLink($string)

    {

        $pattern = '/((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/i';

        $replacement = '<a class="tweet_url" target="_blank" href="$1">$1</a>';

        $string = preg_replace($pattern, $replacement, $string);

        return $string;

    }

    //output start from here

echo '<div id="advancedTwitterDisplayWidget">';

echo '<ul class="social">';

foreach($string as $items)

    {

        echo '<li>';    

        echo '<span class="image-div">

            <a href="https://twitter.com/'.$items['user']['screen_name'].'">                

                <img src="'.$items['user']['profile_image_url_https'].'"images/twitter-feed-icon.png" width="42" height="42" alt="twitter icon" style="border-radius:'.$image_radius.'px;" />

            </a>

        </span>';   

        echo '<span class="text-div" style="width:'.trim($width-100).'px;">

            <strong><a href="https://twitter.com/'.$items['user']['screen_name'].'" >'.$items['user']['name'].'</a></strong> 

                <small><a href="https://twitter.com/'.$items['user']['screen_name'].'" >@'.$items['user']['screen_name'].'</a></small>

                <p><span class="tweet-time"><a href="https://twitter.com/'.$items['user']['screen_name'].'/status/'.$items['id_str'].'"></a></span><br/>'.addLink($items['text']).'</p>

        </span>';

        echo '</li>';

    }

    echo '</ul>';

    echo '</div>';
       ?>
    </div>


    

                    <div class="imagelisting">

                        <p><?php echo $followers; ?> peoples are following <strong><a href="//twitter.com/<?php echo $stringUserInfo['screen_name']; ?>" target="_blank"><?php echo $stringUserInfo['screen_name']; ?></a></strong> @twitter</p>

                        <ul>

                            <?php

                            foreach($string_follow as $item){

                            

$length = count($item);

if($length<$connections){

$t = $length;}

else{$t = $connections+1;

}

for($i=0;$i<$t-1;$i++){

$followImg = $item[$i]['profile_image_url'];

$followURL = $item[$i]['screen_name'];

$followTitle = $item[$i]['name'];

echo "<li><a href='//twitter.com/$followURL' target='_blank'><img src='$followImg' title='$followTitle'></a></li>";

}

}?> 

                            <div class="clr"></div>

                        </ul>

                        <?php if($footer=="true"){ ?>

                        <p class="icon">follow us on twitter</p>

                        <?php } ?>

                    </div>

                </div>

            </div>

            </div>

    </div>
    



  

<?php

        echo $after_widget;

    }

}



add_action('widgets_init','register_ComTtwitterSolution');

function register_ComTtwitterSolution(){

    register_widget('ComTtwitterSolution');

}