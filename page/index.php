<?php
namespace romaninsh\themeroller_extractor;
class page_index extends \Page {
    function init(){
        parent::init();

        $f=$this->add('Form');
        $f->addField('line','themeroller_url');
        $f->addField('text','less');
        $f->addSubmit('Convert');

        if($f->isSubmitted()){
            $x=$f->get('themeroller_url');
            $x=preg_replace('|.*http://jqueryui.com|','',$x);
            $x=preg_replace('|^[^\?]*\?|','',$x);
            $x=explode('&',$x);
            $x=preg_replace('/=([a-f0-9]{6})$/','=#\1',$x);
            $x=preg_replace('/=([^#0-9].*)$/','="\1"',$x);
            $x=preg_replace('/^/','@',$x);
            $x=preg_replace('/=/',': ',$x);

            $x=join(";\n",$x).";\n";

            $f->getElement('less')->js()->val($x)->execute();
        }
    }
}
