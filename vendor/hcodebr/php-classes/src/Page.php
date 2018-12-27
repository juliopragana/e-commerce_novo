<?php

namespace Hcode;

use Rain\Tpl;


class Page{

    private $tpl;
    private $options = [];
    private $defaults = [
        "header"=>true,
        "footer"=>true,
        "data"=>[]
    ];

    //função que carrega a página do header
    public function __construct($opts = array(), $tpl_dir = "/views/"){

        $this->options = array_merge($this->defaults, $opts);
        
        $config = array(
            "tpl_dir"       =>  $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
            "debug"         => false // set to false to improve the speed
        );

        Tpl::configure( $config );   

        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);

        if($this->options["header"] === true){
            $this->tpl->draw("header");
        }
    }

    //função que seta os dados da página
    private function setData($data = array())
	{
		foreach ($data as $key => $value) {
			# code...
			$this->tpl->assign($key, $value);
		}
	}


    public function setTpl($name, $data = array(), $returnHTML = false){
        
        $this->setData($data);
	    return $this->tpl->draw($name, $returnHTML);
    }

    //função que carrega o footer
    public function __destruct(){

        if($this->options["footer"] === true){
        $this->tpl->draw("footer");
        }
    }

}

?>