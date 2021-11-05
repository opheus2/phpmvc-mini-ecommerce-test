<?php 

namespace App\Core;

class View
{
    public string $title = '';
    public array $errors = [];

    public function renderView($view, array $params = [], array $errors = [])
    {
        $this->errors = $errors;
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        $layout = app()->layout;
        if (app()->controller) 
        {
            $layout = app()->getController()->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/Views/layouts/{$layout}.view.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) 
        {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/Views/{$view}.view.php";
        return ob_get_clean();
    }
    protected function hasErrors()
    {
        return !empty($this->errors);
    }
}
