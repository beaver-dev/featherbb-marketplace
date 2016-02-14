<?php namespace App\Core\Interfaces;

class Router extends SlimSugar
{

    public static function pathFor($name, array $data = [], array $queryParams = [])
    {
        return Container::get('router')->pathFor($name, $data, $queryParams);
    }

    public static function redirect($uri, $message = null, $status = 301)
    {
        if (is_string($message))
            $message = array('info', $message);
        // Add a flash message if needed
        if (is_array($message))
            Container::get('flash')->addMessage($message[0], $message[1]);

        return Response::withStatus($status)->withHeader('Location', $uri);
    }

    public static function paginate($num_pages, $cur_page, $link, $args = null)
    {
        $pages = array();

        if ($num_pages <= 1) {
            $pages = array('<strong class="item1">1</strong>');
        } else {
            // Add a previous page link
            if ($num_pages > 1 && $cur_page > 1) {
                $pages[] = '<a rel="prev"'.(empty($pages) ? ' class="item1"' : '').' href="'.self::get_sublink($link, 'page-$1', ($cur_page - 1), $args).'">&laquo;</a>';
            }

            if ($cur_page > 3) {
                $pages[] = '<a'.(empty($pages) ? ' class="item1"' : '').' href="'.$link.'">1</a>';

                if ($cur_page > 5) {
                    $pages[] = '<span class="spacer">...</span>';
                }
            }

            // Don't ask me how the following works. It just does, OK? :-)
            for ($current = ($cur_page == 5) ? $cur_page - 3 : $cur_page - 2, $stop = ($cur_page + 4 == $num_pages) ? $cur_page + 4 : $cur_page + 3; $current < $stop; ++$current) {
                if ($current < 1 || $current > $num_pages) {
                    continue;
                } elseif ($current != $cur_page) {
                    $pages[] = '<a'.(empty($pages) ? ' class="item1"' : '').' href="'.str_replace('#', '', self::get_sublink($link, 'page-$1', $current, $args)).'">'.$current.'</a>';
                } else {
                    $pages[] = '<strong'.(empty($pages) ? ' class="item1"' : '').'>'.$current.'</strong>';
                }
            }

            if ($cur_page <= ($num_pages-3)) {
                if ($cur_page != ($num_pages-3) && $cur_page != ($num_pages-4)) {
                    $pages[] = '<span class="spacer">...</span>';
                }

                $pages[] = '<a'.(empty($pages) ? ' class="item1"' : '').' href="'.self::get_sublink($link, 'page-$1', $num_pages, $args).'">'.$num_pages.'</a>';
            }

            // Add a next page link
            if ($num_pages > 1 && $cur_page < $num_pages) {
                $pages[] = '<a rel="next"'.(empty($pages) ? ' class="item1"' : '').' href="'.self::get_sublink($link, 'page-$1', ($cur_page + 1), $args).'">&raquo;</a>';
            }
        }

        return implode(' ', $pages);
    }

    //
    // Generate a hyperlink with parameters and anchor and a subsection such as a subpage
    // Inspired by (c) Panther <http://www.pantherforum.org/>
    //
    private static function get_sublink($link, $sublink, $subarg, $args = null)
    {
        $base_url = self::base();

        if ($sublink == 'page-$1' && $subarg == 1) {
            return self::get($link, $args);
        }

        $gen_link = $link;
        if (!is_array($args) && $args != null) {
            $gen_link = str_replace('$1', $args, $link);
        } else {
            for ($i = 0; isset($args[$i]); ++$i) {
                $gen_link = str_replace('$'.($i + 1), $args[$i], $gen_link);
            }
        }

        $gen_link = $base_url.'/'.str_replace('#', str_replace('$1', str_replace('$1', $subarg, $sublink), '$1'), $gen_link);

        return $gen_link;
    }

    //
    // Generate link to another page on the forum
    // Inspired by (c) Panther <http://www.pantherforum.org/>
    //
    public static function get($link, $args = null)
    {
        $base_url = self::base();

        $gen_link = $link;
        if ($args == null) {
            $gen_link = $base_url.'/'.$link;
        } elseif (!is_array($args)) {
            $gen_link = $base_url.'/'.str_replace('$1', $args, $link);
        } else {
            for ($i = 0; isset($args[$i]); ++$i) {
                $gen_link = str_replace('$'.($i + 1), $args[$i], $gen_link);
            }
            $gen_link = $base_url.'/'.$gen_link;
        }

        return $gen_link;
    }

    //
    // Fetch the base_url, optionally support HTTPS and HTTP
    //
    public static function base()
    {
        return Request::getUri()->getBasePath();
    }
}
