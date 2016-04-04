<?php
// Facebook Comments Extension for Bolt

namespace Bolt\Extension\Bolt\FacebookComments;

use Bolt\Asset\Snippet\Snippet;
use Bolt\Asset\Target;
use Bolt\Extension\SimpleExtension;

class FacebookCommentsExtension extends SimpleExtension
{
    /**
     * Return the available Twig Functions
     * @return array
     */
    protected function registerTwigFunctions()
    {
        return [
            'facebookcomments' => 'facebookComments',
        ];
    }


    /**
     * Callback for snippet 'facebookscript'.
     *
     * @return string
     */
    function facebookScript()
    {
        $script = <<< EOM
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
EOM;
        $app = $this->getContainer();
        $asset = new Snippet();
        $asset->setCallback($script)
            ->setLocation(Target::END_OF_BODY);
        $app['asset.queue.snippet']->add($asset);
    }


    /**
     * Callback for Twig function 'facebookcomments'.
     */
    function facebookComments($title="")
    {
        $this->facebookScript();

        $config = $this->getConfig();
        $app = $this->getContainer();

        $html = <<< EOM
        <div class="fb-comments" data-href="%url%" data-num-posts="1" data-width="%width%"></div>
EOM;
        $html = str_replace("%width%", $config['width'], $html);
        $html = str_replace("%url%", $app['resources']->getUrl('canonicalurl'), $html);

        return new \Twig_Markup($html, 'UTF-8');
    }

    protected function getDefaultConfig()
    {
        return ['width' => '470'];
    }


}


