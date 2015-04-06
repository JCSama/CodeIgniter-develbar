# CodeIgniter Developer Toolbar

CodeIgniter Developer Toolbar is a third party library based on Profiler Library with additional functionality for debugging and optimization.

# Installation

CODEIGNITER Versoin 2.0.2+

Copy the files to the `application/third_party/DevelBar` folder.

Copy the file `MY_Loader.php` to the `application/core` folder.

# Usage

Open `application/config/config.php`

`$config['enable_hooks'] = TRUE;`

Open `application/config/autoload.php`

`$autoload['packages'] = array(APPPATH . 'third_party/DevelBar');`

Open `application/third_party/DevelBar/config/config.php`

`$config['enable_develbar'] = TRUE;`