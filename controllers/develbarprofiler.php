<?php

/**
 * Class DevelBarProfiler
 *
 * Profiler Controller for ajax requests
 *
 * This content is released under the MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    DevelBar
 * @author    Mohamed ES-SAHLI
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link    https://github.com/JCSama/CodeIgniter-develbar
 * @since    Version 0.1
 * @filesource
 */
class DevelBarProfiler extends CI_Controller
{

    /**
     * @param $profilerId
     * @return string
     */
    public function profil($profilerId)
    {
        $this->load->helper('url');

        if (ENVIRONMENT != 'development') {
            redirect();
        }

        $this->load->driver('cache', array('adapter' => 'file', 'key_prefix' => 'ci_toolbar_profiler_'));
        $profiler = $this->cache->get($profilerId);

        $this->load->helper(array('language', 'utility'));
        $this->load_lang_file();

        $data = array(
            'profiler' => $profiler
        );

        $this->load->view('develbar/profiler', $data);
    }

    /**
     * Load language file
     */
    private function load_lang_file()
    {
        $default_language = $this->config->config['language'];
        $lang_file = APPPATH . 'third_party/DevelBar/language/' . $default_language . '/develbar_lang.php';

        if (!file_exists($lang_file)) {
            $default_language = 'english';
        }

        $this->load->language('develbar', $default_language);
    }
}
