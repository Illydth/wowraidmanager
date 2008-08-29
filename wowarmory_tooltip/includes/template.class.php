<?
class template{
    var $Template;
    var $Tabela, $Num, $Loop, $vars = array();
    
    function template($dir, $arquivo){
    $conteudo = file_get_contents($dir.$arquivo);
    @preg_match_all("|\{include=(.*)}|U",$conteudo,$inc);
    $inc = $inc[1];
    foreach($inc as $fic) {
        $a = file_get_contents($dir.$fic);
        $conteudo = str_replace("{include=".$fic."}",$a,$conteudo);
    }
    $this->Template = $conteudo;
    }
    
    function ver($debug = false){
         
        $this->limpaLoopVazio();
        @preg_match_all("|\{(.*)\}|U", $this->Template,$inc);
        $inc = $inc[1];
        foreach($inc as $fic){    
            $fic = explode(".", $fic);
            if(!isset($this->vars[$fic[0]]) && $debug == true){
                $this->Template = str_replace("{".$fic[0]."}","[TEMPLATE: var not found $fic[0]]",$this->Template);
            } else {    
            if(is_array($this->vars[$fic[0]])){
                $this->Template = str_replace("{".$fic[0].".".$fic[1]."}",$this->vars[$fic[0]][$fic[1]],$this->Template);
            } else {
                $this->Template = str_replace("{".$fic[0]."}",$this->vars[$fic[0]],$this->Template);
            }
            }     
        }    
        print $this->Template;
    }

    function atribuir($var, $conteudo){
        $this->vars[$var] = $conteudo;
    }    
    
    function loop( $lugar, $valores ){
        $this->Loop = $lugar;
        if( strstr($this->Template,"[-$lugar-]") ){
            $this->Template = str_replace( "[-$lugar-]" , $this->Tabela."[-$lugar-]" , $this->Template );
        }else{
            $partes = explode("<!--".$lugar."-->",$this->Template);
            $partes2 = explode( "<!--/".$lugar."-->" , $partes[1] );
            $this->Tabela = $partes2[0];
            $this->Template = str_replace( "<!--$lugar-->".$this->Tabela."<!--/$lugar-->" , $this->Tabela."[-$lugar-]" , $this->Template);
        }
        foreach($valores as $chave=>$valor){
            $this->Template = str_replace('{'.$chave.'}',$valor,$this->Template);
        }
    }
    
    function fechaLoop(){
        $this->Template = str_replace( "[-".$this->Loop."-]", "", $this->Template);
    }

    function limpaLoopVazio() {
        @preg_match_all("|\<!--(.*)\-->|U", $this->Template,$inc);
        $inc = $inc[1];
        if(is_array($inc)){
        	foreach($inc as $fic){
            		$fic = explode(".", $fic);
            		$partes = explode("<!--".$fic[0]."-->",$this->Template);
            		$partes2 = explode( "<!--/".$fic[0]."-->" , $partes[1] );
            		$this->Tabela = $partes2[0];
            		$this->Template = str_replace( "<!--$fic[0]-->".$this->Tabela."<!--/$fic[0]-->" , " " , $this->Template);
        	}
        }
    }
}
?>
