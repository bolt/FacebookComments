<?php
// Facebook Like Extension for Bolt

namespace Bolt\Extension\Bolt\FacebookComments;

use Bolt\Extensions\Snippets\Location as SnippetLocation;

class Extension extends \Bolt\BaseExtension
{
    public function getName()
    {
        return "Facebook Comments";
    }

    function initialize()
    {
        // Nothing here.. Note: This extension defines the snippets and functions in getSnippets() and getFunctions()
    }

    /**
     * Return the available Snippets
     * @return array
     */
    function getSnippets()
    {
        return array(
            array(SnippetLocation::END_OF_BODY, 'facebookScript')
        );
    }

    /**
     * Return the available Twig Functions
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('facebookcomments', array($this, 'facebookComments'))
        );
    }



    /**
     * Callback for snippet 'facebookscript'.
     *
     * @return string
     */
    function facebookScript()
    {

        $html = <<< EOM
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
EOM;
        return $html;

    }


    /**
     * Callback for Twig function 'facebookcomments'.
     */
    function facebookComments($title="")
    {

        if (empty($this->config['width'])) { $this->config['width'] = "470"; }

        $html = <<< EOM
        <div class="fb-comments" data-href="%url%" data-num-posts="1" data-width="%width%"></div>
EOM;

        $html = str_replace("%width%", $this->config['width'], $html);
        $html = str_replace("%url%", $this->app['paths']['canonicalurl'], $html);

        return new \Twig_Markup($html, 'UTF-8');

    }




}


