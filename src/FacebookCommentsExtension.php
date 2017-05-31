<?php
// Facebook Comments Extension for Bolt

namespace Bolt\Extension\Bolt\FacebookComments;

use Bolt\Asset\Snippet\Snippet;
use Bolt\Asset\Target;
use Bolt\Extension\SimpleExtension;

class FacebookCommentsExtension extends SimpleExtension
{
    protected $isSnippetAdded = false;

    /**
     * Return the available Twig Functions
     *
     * @return array
     */
    protected function registerTwigFunctions()
    {
        return [
            'facebookcomments'     => 'facebookComments',
            'facebookcommentslink' => 'facebookCommentsLink',
        ];
    }


    /**
     * Callback for snippet 'facebookscript'.
     *
     * @return string
     */
    function facebookScript()
    {
        if (!$this->isSnippetAdded) {
            $script
                   = <<< EOM
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
EOM;
            $app   = $this->getContainer();
            $asset = new Snippet();
            $asset->setCallback($script)
                  ->setLocation(Target::END_OF_BODY);
            $app['asset.queue.snippet']->add($asset);
            $this->isSnippetAdded = true;
        }

    }


    /**
     * Callback for Twig function 'facebookcomments'.
     */
    function facebookComments($link = '')
    {

        $this->facebookScript();

        $config = $this->getConfig();
        $app    = $this->getContainer();
        if (!$link) {
            $link = $app['resources']->getUrl('canonicalurl');
        } else {
            $link =$app['resources']->getUrl('hosturl').$link;
        }

        $html
              = <<< EOM
        <div class="fb-comments" id="fb_comments" data-href="%url%" data-numposts="%num_posts%" data-width="%width%" data-colorscheme="%colorscheme%" data-order-by="%order_by%"></div>
EOM;
        $html = str_replace("%num_posts%", $config['num_posts'], $html);
        $html = str_replace("%width%", $config['width'], $html);
        $html = str_replace("%colorscheme%", $config['colorscheme'], $html);
        $html = str_replace("%order_by%", $config['order_by'], $html);
        $html = str_replace("%url%", $link, $html);

        return new \Twig_Markup($html, 'UTF-8');
    }

    function facebookCommentsLink($link = "")
    {
        $this->facebookScript();

        $app = $this->getContainer();
        if (!$link) {
            $link = $app['resources']->getUrl('canonicalurl');
        } else {
            $link =$app['resources']->getUrl('hosturl').$link;
        }

        $html
              = <<< EOM
        <a href="%url%#fb_comments"><span class="fb-comments-count" data-href="%url%"></span> Comments</a>
EOM;
        $html = str_replace("%url%", $link, $html);

        return new \Twig_Markup($html, 'UTF-8');
    }

    protected function getDefaultConfig()
    {
        return [
            'width'       => '470',
            'num_posts'   => '1',
            'colorscheme' => 'light',
            'order_by'    => 'social',
        ];
    }


}