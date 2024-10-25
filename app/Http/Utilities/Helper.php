<?php

namespace App\Http\Utilities;

use App\Models\Configuracao;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Helper
{
    // RETORNA O TOKEN DO FORMULÁRIO
    public function token()
    {
        date_default_timezone_set('America/Sao_Paulo');
        //return base64_encode(rand(1000, 9999) . session()->get('usuario_id') . date('yHmids') . rand(1000, 9999));
        return uuid_create();
    }

    public function percentColor($value)
    {
        if ($value >= 90) {
            return 'bd-red-500';
        } else if ($value >= 80) {
            return 'bd-red-400';
        } else if ($value >= 70) {
            return 'bd-orange-500';
        } else if ($value >= 60) {
            return 'bd-orange-400';
        } else if ($value >= 50) {
            return 'bd-yellow-500';
        } else if ($value >= 40) {
            return 'bd-yellow-400';
        } else if ($value >= 30) {
            return 'bd-blue-500';
        } else if ($value >= 20) {
            return 'bd-blue-400';
        } else if ($value >= 10) {
            return 'bd-green-500';
        } else if ($value >= 0) {
            return 'bd-green-400';
        }
    }

    /*
     * Retorna o maior valor passado no array
     * @param | array | $dado
     */
    public function getMaior($dados)
    {
        $anterior   = 0;
        foreach ($dados as $key => $dado) {
            $tamanho    = strlen($dado);
            if ($tamanho > $anterior) {
                $anterior = $tamanho;
            }
        }
        return $anterior;
    }

    public function getOrigem($ean)
    {
        $origem = null;
        if (!empty($ean) AND !is_object($ean)) {
            $string = strval($ean);
            $pre = substr($string, 0, 3);

            if ($pre == '789' or $pre == '790') {
                $origem = 0;
            }
        }

        return $origem;
    }

    // GERADOR DE CÓDIGOS ALEATÓRIO
    public function getCode($length, $upper = true, $low = true, $num = true, $esp = false){
        $token = "";
        $codeAlphabet = '';
        if ($upper) {
            $codeAlphabet .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        }
        if ($low) {
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        }
        if ($num) {
            $codeAlphabet .= "0123456789";
        }
        if ($esp) {
            $codeAlphabet .= "*-@#()=[]{}";
        }
        $max = strlen($codeAlphabet);

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return $token;
    }

    public function tipoOfx($tipo)
    {
        switch ($tipo) {
            case 'CREDIT':
                return 'Crédito';
                break;
            case 'DEBIT':
                return 'Débito';
                break;
            case 'PAYMENT':
                return 'Pagamento';
                break;
            default:
                return 'Outros';
                break;
        }
    }

    // RETORNA A DATA NO PADRÃO BRASILEIRO
    public function data($data, $formato = 'd/m/Y')
    {
        if($data == '0000-00-00') {
            return '';
        }elseif (!empty($data)) {
            return date($formato, strtotime($data));
        } else {
            return '';
        }
    }

    public function diferencaData($data, $compara = null)
    {
        if ($compara == null) {
            $compara = date('Y-m-d H:i:s');
        }

        $dateStart = date_create($data);
        $dateNow = date_create($compara);
        $dateDiff = date_diff($dateStart, $dateNow);

        return $dateDiff->format("%a");
    }

    // RETORNA O VALOR MASCARADO
    public function mascara($mascara, $string)
    {
        if (empty($string)) {
            return '';
        } else {
            $string = @str_replace(" ", "", $string);

            for ($i = 0; $i < strlen($string); $i++) {
                $mascara[strpos($mascara, "#")] = $string[$i];
            }

            return $mascara;
        }
    }

    public function maskMoney($valor, $decimal = 2)
    {
        $valor = (float) $valor;
        return number_format($valor, $decimal,",",".");
    }

    public function str($valor, $caracteres = 6, $direcao = STR_PAD_LEFT)
    {
        return str_pad($valor, $caracteres,0,$direcao);
    }

    public function alignText($string, $caracteres, $direcao = 'E')
    {
        $string = strtoupper($string);
        $string = substr($string, 0, 48);

        if ($direcao == 'C'){
            return str_pad($string, $caracteres, " ", STR_PAD_BOTH);
        } elseif ($direcao == 'D') {
            return str_pad($string, $caracteres, " ", STR_PAD_LEFT);
        } else {
            $string = substr($string, 0, $caracteres);
            return str_pad($string, $caracteres, " ", STR_PAD_RIGHT);
        }
    }

    public function getDataExtenso($mes)
    {
        $meses = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
            4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
            10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];

        return $meses[$mes];
    }

    public function urlOpen($url)
    {
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
            echo "\n<br />";
            $contents = '';
        } else {
            curl_close($ch);
        }

        if (!is_string($contents) || !strlen($contents)) {
            echo "Failed to get contents.";
            $contents = '';
        }

        return $contents;
    }

    public function destacaTexto($pesquisa, $descricao)
    {
        $nome = $this->removerCaracterEspecialMenosEspaco($descricao);
        $itemPesquisado = $this->removerCaracterEspecialMenosEspaco($pesquisa);
        $pos = stripos($nome, $itemPesquisado);

        preg_match_all('/./u', $descricao, $descricao02);

        $count = 0;
        $textoDestaque = "";
        foreach ($descricao02[0] as $item) {
            if ($count == ($pos)) {
                $textoDestaque .= '<span>';
            }
            if ($count == ($pos + strlen($itemPesquisado))) {
                $textoDestaque .= '</span>';
            }
            $textoDestaque .= $item;
            $count++;
        }

        return $textoDestaque;
    }

    // RETORNA STRING SEM OS CARACTERES ESPECIAIS
    public function removerEspecial($string)
    {
        $de     = array('ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','Ä','Ã','À','Á','Â','Ê','Ë','È','É','Ï','Ì','Í','Ö','Õ','Ò','Ó','Ô','Ü','Ù','Ú','Û','ñ','Ñ','ç','Ç',' ','.','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º');
        $por    = array('a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U','n','n','c','C','','','','','','','','','','','','','','','','','','','','','','','','');

        return @str_replace($de, $por, $string);
    }


    public function removerCaracterEspecialMenosEspaco($string)
    {
        $de     = array('ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','Ä','Ã','À','Á','Â','Ê','Ë','È','É','Ï','Ì','Í','Ö','Õ','Ò','Ó','Ô','Ü','Ù','Ú','Û','ñ','Ñ','ç','Ç','.','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º');
        $por    = array('a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','A','A','E','E','E','E','I','I','I','O','O','O','O','O','U','U','U','U','n','n','c','C','','','','','','','','','','','','','','','','','','','','','','','');

        return @str_replace($de, $por, $string);
    }
}
