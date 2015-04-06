# CodeIgniter Developer Toolbar

CodeIgniter Developer Toolbar is a third party library based on Profiler Library with additional functionality for debugging and optimization.

# Installation

CodeIgniter Versoin 2.0.2+

Copy the files to the `application/third_party/DevelBar` folder.

Copy the file `MY_Loader.php` to the `application/core` folder.

# Usage

Open `application/config/autoload.php` :

`$autoload['packages'] = array(APPPATH . 'third_party/DevelBar');`

Open `application/config/config.php` :

`$config['enable_hooks'] = TRUE;`

Open `application/config/hooks.php` and add this line :

`$hook['display_override'][] = array(
	'class'  	=> 'Develbar',
    'function' 	=> 'debug',
    'filename' 	=> 'Develbar.php',
    'filepath' 	=> 'third_party/DevelBar/hooks'
);`

Open `application/third_party/DevelBar/config/config.php` :

`$config['enable_develbar'] = TRUE;`