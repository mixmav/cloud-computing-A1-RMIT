<?php

switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'loginpage.php';
        break;
	case '/registerpage';
        require 'registerpage.php';
        break;
	
	case '/login';
        require 'login.php';
        break;
	case '/register';
        require 'register.php';
        break;
	
	case '/logout';
        require 'logout.php';
        break;

	
	case '/forumpage';
        require 'forumpage.php';
        break;
	case '/forumpost';
        require 'forumpost.php';
        break;

	case '/user';
        require 'userpage.php';
        break;
	case '/update-password';
        require 'updatepassword.php';
        break;
	
	case '/editforummessagepage';
        require 'editforummessagepage.php';
        break;
	case '/editforummessagepost';
        require 'editforummessagepost.php';
        break;


	case '/create_users';
        require 'create_users.php';
        break;
    default:
        break;
}

?>