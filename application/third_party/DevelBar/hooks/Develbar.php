<?php defined('BASEPATH') or die('No direct script access.');


/**
 * Class DevelBar
 *
 * @package    DevelBar
 * @author     Mohamed ES-SAHLI
 * @link       http://codeigniter.com
 * @since      Version 0.1
 */
class DevelBar
{

    /**
     * DevelBar version
     */
    const VERSION = '0.1';

    /**
     * @var object
     */
    private $CI;

    /**
     * @var string
     */
    private $view_folder = 'develbar/';

    /**
     * @var string
     */
    private $assets_folder = '';

    /**
     * @var array
     */
    private $views = array();

    /**
     * List of helpers
     *
     * @var array
     */
    private $helpers = array(
        'utility',
        'language',
        'url',
        'text'
    );


    /**
     * List of profiler sections available to show
     */
    private $default_options = array(
        'enable_develbar' => false,
        'check_update' => false,
        'develbar_sections' => array(
            'Benchmarks' => true,
            'Memory Usage' => true,
            'Request' => true,
            'Database' => true,
            'Hooks' => true,
            'Libraries' => true,
            'Helpers' => true,
            'Views' => true,
            'Config' => true,
            'Session' => true,
        ),
    );

    public function __construct()
    {
        log_message('debug', 'DevelBar Class Initialized !');

        if (version_compare(CI_VERSION, '2.0.2', '<='))
            die('Version of CI not supported by DevelBar,
                Please check ' . anchor($this->CI->config->item('ci_website')) . ' for update.');

        $this->initialize();
    }

    /**
     * Initialize DevelBar library
     */
    private function initialize()
    {
        $this->CI =& get_instance();
        $this->CI->load->config('develbar', true);
        $this->CI->load->helpers($this->helpers);
        $this->CI->load->language('develbar');

        // Initialize default options
        $config = $this->CI->config->config['develbar'];
        $this->default_options = array_merge($this->default_options, $config);
        $this->assets_folder = APPPATH . 'third_party/DevelBar/assets/';

    }

    /**
     * Start Debug Mode
     */
    public function debug()
    {

        if ($this->CI->input->is_cli_request() || $this->CI->input->is_ajax_request()) {
            $this->CI->output->_display();

            return;
        }

        if ($this->default_options['enable_develbar'] == true) {
            foreach ($this->default_options['develbar_sections'] as $section => $enabled) {
                if ($enabled) {
                    $section = strtolower(str_replace(' ', '_', $section));
                    $this->views[$section] = call_user_func(array($this, $section . '_section'));
                }
            }

            $output = $this->CI->output->get_output();
            $output = preg_replace('|</body>.*?</html>|is', '', $output, -1, $count) . $this->develbar_output();

            if ($count > 0)
                $output .= '</body></html>';

            $this->CI->output->_display($output);
        }

    }

    /**
     * Generate The Developer's Toolbar output.
     *
     * @return mixed
     */
    private function develbar_output()
    {
        $data = array(
            'ci_version' => CI_VERSION,
            'develBar_version' => self::VERSION,
            'sections' => $this->default_options['develbar_sections'],
            'ci_new_version' => $this->default_options['check_update'] == true ? check_for_new_version() : false,
            'css' => $this->CI->load->file($this->assets_folder . 'css/develbar.css', true),
            'logo' => image_base64_encode($this->assets_folder . 'images/ci.png'),
            'views' => $this->views,
        );

        return $this->CI->load->view($this->view_folder . 'develbar', $data, true);
    }

    /**
     * Benchmarks section
     *
     * This function cycles through the entire array of mark points and
     * matches any two points that are named identically (ending in "_start"
     * and "_end" respectively).  It then compiles the execution times for
     * all points and returns it as an array
     *
     * @return    array
     */

    protected function benchmarks_section()
    {
        $data['icon'] = image_base64_encode($this->assets_folder . 'images/timer.png');

        $data['benshmarks']['total_time'] = array(
            'profile' => 'Total Execution Time',
            'elapsed_time' => $this->CI->benchmark->elapsed_time()
        );

        foreach ($this->CI->benchmark->marker as $marker => $time) {
            if (preg_match("/(.+?)_end/i", $marker, $matches)) {
                $start = $matches[1] . '_start';
                $end = $matches[1] . '_end';
                if (isset($this->CI->benchmark->marker[$end]) AND
                    isset($this->CI->benchmark->marker[$start])
                ) {

                    $profile = ucwords(str_replace(array('_', '-'), ' ', $matches[1]));
                    $data['benshmarks']['profiles'][] = array(
                        'profile' => $profile,
                        'elapsed_time' => $this->CI->benchmark->elapsed_time($start, $end),
                    );

                }
            }
        }

        return $this->CI->load->view($this->view_folder . 'benchmarks', $data, true);
    }

    /**
     * Display total used memory
     *
     * @return mixed
     */
    protected function memory_usage_section()
    {
        $data = array(
            'icon' => image_base64_encode($this->assets_folder . 'images/memory.png'),
            'memory' => $this->CI->benchmark->memory_usage(),
        );

        return $this->CI->load->view($this->view_folder . 'memory_usage', $data, true);
    }

    /**
     * Show the controller and function that were called
     *
     * @return mixed
     */
    protected function request_section()
    {
        $data = array(
            'icon' => image_base64_encode($this->assets_folder . 'images/setting.png'),
            'method' => ($method = $this->CI->input->method()),
            'controller' => $this->CI->router->fetch_class(),
            'action' => $this->CI->router->fetch_method(),
            'parameters' => $this->CI->input->{$method}(),
        );

        return $this->CI->load->view($this->view_folder . 'request', $data, true);
    }

    /**
     * Compile Queries
     *
     * @return mixed
     */
    protected function database_section()
    {
        $dbs = $data = array();
        $cobjects = get_object_vars($this->CI);
        $db_server = array();

        foreach ($cobjects as $name => $cobject) {
            if (is_object($cobject)) {
                if ($cobject instanceof CI_DB) {
                    $dbs[get_class($this->CI) . ':$' . $name] = $cobject;
                    $db_server[$cobject->hostname] = $cobject->hostname;
                } elseif ($cobject instanceof CI_Model) {
                    foreach (get_object_vars($cobject) as $mname => $mobject) {
                        if ($mobject instanceof CI_DB) {
                            $dbs[get_class($cobject) . ':$' . $mname] = $mobject;
                            $db_server[$cobject->hostname] = $cobject->hostname;
                        }
                    }
                }
            }

        }

        $data = array(
            'icon' => image_base64_encode($this->assets_folder . 'images/database.png'),
            'dbs' => $dbs,
            'db_server' => $db_server,
        );

        return $this->CI->load->view($this->view_folder . 'database', $data, true);
    }

    /**
     * Retrieve activated Hooks
     *
     * @return    array
     */
    protected function hooks_section()
    {
        $total_hooks = 0;
        $hooks = array();

        foreach ($this->CI->hooks->hooks as $hook_point => $_hooks) {
            if (!isset($_hooks[0]))
                $_hooks = array($_hooks);

            foreach ($_hooks as $hook) {
                if (class_exists($hook['class'])) {
                    $hooks[$hook_point][] = $hook;
                    $total_hooks++;
                }
            }

        }

        $data = array(
            'icon' => $data['icon'] = image_base64_encode($this->assets_folder . 'images/hook.png'),
            'loaded_hooks' => $hooks,
            'total_hooks' => $total_hooks,
        );

        return $this->CI->load->view($this->view_folder . 'hooks', $data, true);
    }

    /**
     * Lists of loaded libraries
     *
     * @return mixed
     */
    protected function libraries_section()
    {
        $loaded_libraries =& is_loaded();
        $data = array(
            'icon' => $data['icon'] = image_base64_encode($this->assets_folder . 'images/library.png'),
            'loaded_libraries' => $loaded_libraries,
        );

        return $this->CI->load->view($this->view_folder . 'libraries', $data, true);
    }

    /**
     * Lists of loaded helpers
     *
     * @return mixed
     */
    protected function helpers_section()
    {
        $data = array(
            'icon' => $data['icon'] = image_base64_encode($this->assets_folder . 'images/helper.png'),
            'helpers' => $this->CI->load->get_helpers(),
        );

        return $this->CI->load->view($this->view_folder . 'helpers', $data, true);
    }

    /**
     * Lists of loaded Models
     *
     * @return mixed
     */
    protected function models_section()
    {
        $data = array(
            'icon' => $data['icon'] = image_base64_encode($this->assets_folder . 'images/model.png'),
            'models' => $this->CI->load->get_models(),
        );

        return $this->CI->load->view($this->view_folder . 'models', $data, true);
    }

    /**
     * Lists of loaded helpers
     *
     * @return mixed
     */
    protected function views_section()
    {
        $views = $this->CI->load->get_views();
        $base_path = substr(str_replace(SYSDIR, '', BASEPATH), 0, -1);

        $_views = array();

        foreach ($views as $path => &$view) {
            if (strpos($view, 'develbar') !== false) {
                continue;
            }

            $path = str_replace($base_path, '', $path);
            $_views[$path] = $view;

        }

        $data = array(
            'icon' => $data['icon'] = image_base64_encode($this->assets_folder . 'images/view.png'),
            'views' => $_views,
        );

        return $this->CI->load->view($this->view_folder . 'views', $data, true);
    }

    /**
     * Lists developer config variables
     *
     * @return mixed
     */
    protected function config_section()
    {
        $data = array(
            'icon' => $data['icon'] = image_base64_encode($this->assets_folder . 'images/config.png'),
            'configuration' => $this->CI->config->config
        );

        return $this->CI->load->view($this->view_folder . 'config', $data, true);
    }

    /**
     * Compile session userdata
     *
     * @return  mixed
     */
    protected function session_section()
    {
        $data = array(
            'icon' => $data['icon'] = image_base64_encode($this->assets_folder . 'images/session.png'),
            'session' => $this->CI->session->userdata()
        );

        return $this->CI->load->view($this->view_folder . 'session', $data, true);
    }
}