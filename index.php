    <?php  

    //include library     
    require "twitteroAuth/autoload.php";
	use Abraham\TwitterOAuth\TwitterOAuth;  

    $twitteruser = ""; //user name you want to reference  
    $notweets = 2000; //how many tweets you want to retrieve  
    $consumerkey = "";  //Consumer Key (API Key)
    $consumersecret = "";   //Consumer Secret (API Secret)
    $accesstoken = "";   //Access Token 
    $accesstokensecret = "";   //Access Token Secret 

   // Connect to Api
   $connection= new TwitterOAuth($consumerkey,$consumersecret,$accesstoken,$accesstokensecret);
   $content=$connection->get("account/verify_credentials");

    // printing username on screen
    echo "Name : ".$content->name."<br>";
    echo "Twitter_username : <b>".$content->screen_name."<br></b>";
    echo "<hr><marquee><b>Recent Tweet Feed</marquee></b><hr>";

     
    // getting recent tweeets by user 'Naveen' on twitter
    $tweets = $connection->get('statuses/user_timeline', ['count' => 200, 'exclude_replies' => true, 'screen_name' => 'Naveen', 'include_rts' => false]);
    $totalTweets[] = $tweets;
    $page = 0;
    for ($count = 200; $count < 500; $count += 200) { 
        $max = count($totalTweets[$page]) - 1;
        $tweets = $connection->get('statuses/user_timeline', ['count' => 200, 'exclude_replies' => true, 'max_id' => $totalTweets[$page][$max]->id_str, 'screen_name' => 'Naveen', 'include_rts' => false]);
        $totalTweets[] = $tweets;
        $page += 1;
    }
    // printing recent tweets on screen
    $start = 1;
    foreach ($totalTweets as $page) {
        foreach ($page as $key) {
            echo $start . ':' . $key->text . '<br>';
            $start++;
        }
    }

 // posting tweet on user profile
    $post = $connection->post('statuses/update', array('status' => 'This tweet is from Twitter API for testing purpose.'));



