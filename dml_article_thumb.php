<?php
// vim: foldmethod=marker:

// run this file at the command line to produce a plugin for distribution:
// $ php dml_article_thumb.php > dml_article_thumb-0.1.txt

// Plugin name is optional.  If unset, it will be extracted from the current
// file name. Uncomment and edit this line to override:
# $plugin['name'] = 'abc_plugin';

$plugin['version']     = '0.6';
$plugin['author']      = 'Dan Lowe';
$plugin['author_uri']  = 'http://tangledhelix.com/';
$plugin['description'] = 'Returns a thumbnail for the article image';

// Plugin types:
// 0 = regular plugin; loaded on the public web side only
// 1 = admin plugin; loaded on both the public and admin side
// 2 = library; loaded only when include_plugin() or require_plugin() is called
$plugin['type'] = 0; 


@include_once('zem_tpl.php');

// {{{ plugin help

if (0) {
?>
# --- BEGIN PLUGIN HELP ---

<p><strong>txp:dml_article_thumb</strong></p>

<p>This plugin provides a function similar to
<code>&lt;txp:article_image&nbsp;/&gt;</code>
except it returns a thumbnail. I use it in excerpts for RSS, but
it should work anywhere. Make sure your article has an article image
ID (see the Advanced area in the write tab), then use:</p>

<p><code>&lt;txp:dml_article_thumb /&gt;</code></p>

# --- END PLUGIN HELP ---
<?php
}

// }}}

# --- BEGIN PLUGIN CODE ---

// {{{ dml_article_thumb()

function dml_article_thumb($atts)
{
    global $thisarticle, $img_dir;

    extract(lAtts(array(
        'style' => '',
        'align' => ''
    ),$atts));

    $theimage = ($thisarticle['article_image'])
                        ? $thisarticle['article_image']
                        : '';

    if ($theimage)
    {
        if (is_numeric($theimage))
        {
            $rs = safe_row('*', 'txp_image', "id='$theimage'");
            if ($rs)
            {
                extract($rs);
                $out = '<img src="'. hu . "$img_dir/${id}t$ext\"";

                if (!empty($alt))   $out .= ' alt="'   . $alt   . '"';
                if (!empty($style)) $out .= ' style="' . $style . '"';
                if (!empty($align)) $out .= ' align="' . $align . '"';

                $out .= ' />';

                return $out;
            }
        }
        else return '<img src="' . $theimage . '" alt="" />';
    }
}

// }}}

# --- END PLUGIN CODE ---

?>
