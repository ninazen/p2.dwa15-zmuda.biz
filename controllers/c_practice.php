<?php
class practice_controller extends base_controller {
	
	public function test_db() {
		/*
		$q = 'INSERT INTO users
		SET first_name = "ALbert",
		last_name = "Einstein"';
		*/

		/*
		$q = 'UPDATE users
		SET email = "ALbert@aol.com"
		WHERE last_name = "Einstein"';
		
		echo $q;
		DB::instance(DB_NAME) -> query($q);
		*/
		
		$new_user = Array (
			'first_name' => 'Al',
			'last_name' => 'Jolson',
			'email' => 'ajolson@music.com',
		);
		echo $new_user;

		DB::instance(DB_NAME) -> insert('users',$new_user);

	}

	// c_users.php
  	public function profile($user_name = NULL) {

        // Set up the view and pass in the data
        $content = View::instance('v_users_profile');
        $this->template->title = "Profile";
        $this->template->content = $content;
        $content->user_name = $user_name;

        // Set up CSS
        $client_files_head = Array(
            '//css/profile.css',     //create this file later
            '//css/master.css's
            );

        $this->template->client_files_head = Utils::load_client_files($client_files_head);
        
        // Set up JS
        $client_files_body = Array(
            '//css/profile.js',      //create this file later
            '//css/master.js'
            );
        
        $this->template->client_files_head = Utils::load_client_files($client_files_head);

        //Display the view
        echo $this->template;

        #$view = View::instance('_v_template');
        #$view = View::instance('v_users_profile');
        #$view->user_name = $user_name;
        #echo $view;
 
        /*
        if($user_name == NULL) {
            echo "No user specified";
        }
        else {
            echo "This is the profile for ".$user_name;
        }
        */

	}

	public function test1() {
		// not needed because of autoloading
		//require(CORED_PATH.'/libraries/Image.php');
		require_once(DOC_ROOT."/core/libraries/Image.php");
		echo DOC_ROOT."/core/libraries/Image.php";
	    /*
        Instantiate an Image object using the "new" keyword
        Whatever params we use when instantiating are passed to __construct 
        */
        $imageObj = new Image('http://placekitten.com/1000/1000');
		$imageObj->resize(100,100);
		$imageObj->display();
	}

	public function test2() {
		echo Time::now();
	}
	
}

    /*-------------------------------------------------------------------------------------------------
      Clear all posts
        
        NOTE: Only the Administrator (user_id=0) can erase the entire post table.
        Individual users can only do a local erase which will appear to clear the table.

        However, we cannot truly erase the posts, as other users may want to view them.
        What we essentially do is hide all posts that were created prior to the 
        last cleared time from that individual user's view.

    -------------------------------------------------------------------------------------------------*/
    public function clear() {
                
        # For admins (user_id = 0)
        if ($this->user->'user_id' == 0):

            # Clear out all contents of the Posts DB 
            #    (but don't DELETE the table structure)
            DB::instance(DB_NAME)->query('TRUNCATE TABLE posts');            

        # For everyone who is not an admin
        else:

            # Hide all contents of the Posts DB prior to the current time
            # by setting the clear time in the user's profile

            # Set up a query to update the clear time in the user's profile
	        $_POST['cleared'] = Time::now();
	    	$condition = 'WHERE user_id = $this->user->user_id';

 	       	# Update the user's clear field in the users table
        	DB::instance(DB_NAME)->update('users', $_POST, $condition);

        endif;

        # Redisplay the posts listing
        Router::redirect('/posts/');
            
    }



    public function clear() {
                
        # Clear out the contents of the post DB (but don't DELETE the table structure)
        DB::instance(DB_NAME)->query('TRUNCATE TABLE posts');            

        # Redirect to the posts viewing page
        Router::redirect('/posts/');
            
    }
