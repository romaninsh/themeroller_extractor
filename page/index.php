<?php
/**
 *
 * See: https://github.com/romaninsh/themeroller_extractor
 *
 */

namespace romaninsh\themeroller_extractor;

class page_index extends \Page
{
    
    // prefix used for LESS variable names
    public $prefix = 'jui-';
    
    // header used in generated LESS code
    public $header = "// ========================================================
//   JQuery UI theme settings / variables
// ========================================================
//   You can fill this by hand or use ATK addon:
//   https://github.com/romaninsh/themeroller_extractor
// 
//   It's advised to use some prefix for variables, because
// sadly LESS don't support variable namespacing yet.
// ========================================================
";

    function init()
    {
        parent::init();

        $f = $this->add('Form');
        $f->addField('line', 'themeroller_url');
        $f->addField('text', 'less')->setRows(12);
        $f->addSubmit('Convert');

        if ($f->isSubmitted()) {
            $x = $f->get('themeroller_url');
            $x = preg_replace('|.*http://jqueryui.com|', '', $x);
            $x = preg_replace('|^[^\?]*\?|', '', $x);
            $x = explode('&', $x);
            $x = preg_replace('/=([a-f0-9]{6})$/', '=#\1', $x);
            $x = preg_replace('/=([^#0-9].*)$/', '="\1"', $x);
            $x = preg_replace('/^/', '@'.$this->prefix, $x);
            $x = preg_replace('/=/', ': ', $x);

            $x = $this->header . "\n" . join(";\n", $x) . ";\n";

            $f->getElement('less')->js()->val($x)->execute();
        }
    }
}
