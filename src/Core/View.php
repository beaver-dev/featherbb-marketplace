<?php namespace App\Core;

/**
* Slim Framework (http://slimframework.com)
*
* @link      https://github.com/slimphp/PHP-View
* @copyright Copyright (c) 2011-2015 Josh Lockhart
* @license   https://github.com/slimphp/PHP-View/blob/master/LICENSE.md (MIT License)
*/

/**
* Php View
*
* Render PHP view scripts into a PSR-7 Response object
*/
class View
{
    /**
    * @var string
    */
    protected $templatesDirectory;
    protected $templates;
    protected $data;
    protected $validation = array(
        'page_number' => 'intval',
        'active_page' => 'strval',
        'is_indexed' => 'boolval',
        'admin_console' => 'boolval',
        'has_reports' => 'boolval',
        'paging_links' => 'strval',
        'footer_style' => 'strval',
        'fid' => 'intval',
        'pid' => 'intval',
        'tid' => 'intval');
    /**
    * SlimRenderer constructor.
    *
    * @param string $templatesDirectory
    */
    public function __construct()
    {
        // $defaultData = $this->getDefaultData();
        // $defaultData = Container::get('hooks')->fire('view.defaultData', $defaultData);
        // $this->data = $defaultData;
        $this->data = [];
        $this->templatesDirectory = Config::get('renderer')['template_path'];
        $this->templates = [];
    }

    /********************************************************************************
    * Resolve template paths
    *******************************************************************************/

    /**
    * Set the base directory that contains view templates
    * @param   string $directory
    * @throws  \InvalidArgumentException If directory is not a directory
    */
    public function setTemplatesDirectory($directory)
    {
        $this->templatesDirectory = rtrim($directory, DIRECTORY_SEPARATOR);
    }

    /**
    * Get templates base directory
    * @return string
    */
    public function getTemplatesDirectory()
    {
        return $this->templatesDirectory;
    }

    /**
    * Get fully qualified path to template file using templates base directory
    * @param  string $file The template file pathname relative to templates base directory
    * @return string
    */
    public function getTemplatePathname($file)
    {
        $pathname = $this->getTemplatesDirectory() . DIRECTORY_SEPARATOR . ltrim($file, DIRECTORY_SEPARATOR);
        if (!is_file($pathname)) {
            $pathname = Config::get('forum')['FEATHER_ROOT'] . 'featherbb/View/' . ltrim($file, DIRECTORY_SEPARATOR); // Fallback on default view
            if (!is_file($pathname)) {
                throw new \RuntimeException("View cannot add template `$file` to stack because the template does not exist");
            }
        }
        return (string) $pathname;
    }

    public function addTemplate($tpl, $priority = 10)
    {
        $tpl = (array) $tpl;
        foreach ($tpl as $key => $tpl_file) {
            $this->templates[(int) $priority][] = $this->getTemplatePathname((string) $tpl_file);
        }
        return $this;
    }

    public function getTemplates()
    {
        $output = array();
        if (count($this->templates) > 1) {
            ksort($this->templates);
        }
        foreach ($this->templates as $priority) {
            if (!empty($priority)) {
                foreach ($priority as $tpl) {
                    $output[] = $tpl;
                }
            }
        }
        return $output;
    }



    /********************************************************************************
    * Rendering
    *******************************************************************************/

    public function display($nested = true)
    {
        // if ($this->app->user) {
        //     $this->setStyle($this->app->user->style);
        // }
        return $this->fetch($nested);
    }

    protected function fetch($nested = true)
    {
        $data = $this->data;
        // $data = array();
        // Force flash messages
        // if (isset($this->app->environment['slim.flash'])) {
        //     $this->data->set('flash', $this->app->environment['slim.flash']);
        // }
        // $data = array_merge($this->getDefaultPageInfo(), $this->page->all(), $this->data->all(), (array) $data);
        // $data['assets'] = $this->getAssets();
        return $this->render($data, $nested);
    }

    public function render(array $data = [], $nested = true)
    {
        // Set data to display in page
        if (isset($data['template'])) {
            throw new \InvalidArgumentException("Duplicate template key found");
        }
        $data = Container::get('hooks')->fire('view.alter_data', $data);

        extract($data);
        ob_start();
        // Include view files
        if ($nested) {
            include $this->getTemplatePathname('header.php');
        }
        foreach ($this->getTemplates() as $tpl) {
            include $tpl;
        }
        if ($nested) {
            include $this->getTemplatePathname('footer.php');
        }

        $output = ob_get_clean();
        $response = Response::getBody()->write($output);

        return $response;
    }

    /********************************************************************************
    * Getters and setters
    *******************************************************************************/

    public function setStyle($style)
    {
        if (!is_dir($this->app->forum_env['FEATHER_ROOT'].'style/themes/'.$style.'/')) {
            throw new \InvalidArgumentException('The style '.$style.' doesn\'t exist');
        }
        $this->data['style'] = (string) $style;
        $this->setTemplatesDirectory($this->app->forum_env['FEATHER_ROOT'].'style/themes/'.$style.'/view');
        return $this;
    }

    public function getStyle()
    {
        return $this->data['style'];
    }

    public function setPageInfo(array $data)
    {
        foreach ($data as $key => $value) {
            list($key, $value) = $this->validate($key, $value);
            $this->data[$key] = $value;
        }
        return $this;
    }

    protected function validate($key, $value)
    {
        $key = (string) $key;
        if (isset($this->validation[$key])) {
            if (function_exists($this->validation[$key])) {
                $value = $this->validation[$key]($value);
            }
        }
        return array($key, $value);
    }

    public function addAsset($type, $asset, $params = array())
    {
        $type = (string) $type;
        if (!in_array($type, array('js', 'css', 'feed', 'canonical', 'prev', 'next'))) {
            throw new \Exception('Invalid asset type : ' . $type);
        }
        if (in_array($type, array('js', 'css')) && !is_file($this->app->forum_env['FEATHER_ROOT'].$asset)) {
            throw new \Exception('The asset file ' . $asset . ' does not exist');
        }

        $params = array_merge(static::getDefaultParams($type), $params);
        if (isset($params['title'])) {
            $params['title'] = Utils::escape($params['title']);
        }
        $this->assets[$type][] = array(
            'file' => (string) $asset,
            'params' => $params
        );
    }

    public function getAssets()
    {
        return $this->assets;
    }

    public function addBreadcrumb($params = array(), $nested = true)
    {
        $breadcrumbs = [];

        foreach ($params as $uri => $text) {
            $breadcrumbs[$uri] = $text;
        }
        // if ($nested == true) {
        //     $breadcrumbs = array_merge([Router::pathFor('home') => 'Home'], $breadcrumbs);
        // }
        $this->setPageInfo(['breadcrumbs' => $breadcrumbs]);
        return $this;
    }

    /**
    * Output rendered template
    *
    * @param ResponseInterface $response
    * @param  string $template Template pathname relative to templates directory
    * @param  array $data Associative array of template variables
    * @return ResponseInterface
    */
}
