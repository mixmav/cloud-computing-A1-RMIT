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

	case '/forum';
        require 'forumpage.php';
        break;



	case '/create_users';
        require 'create_users.php';
        break;
    default:
        break;
}

?>