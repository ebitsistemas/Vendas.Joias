<?php

namespace App\Http\Utilities;

use App\Models\FormaPagamento;
use App\Models\Venda;
use App\Models\VendaItem;
use App\Models\FaturaItem;
use App\Models\Configuracao;
use Fpdf\Fpdf;
use Illuminate\Support\Str;

class Impressao80mm
{
    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 80;
    const A4_WIDTH = 150;
    // tweak these values (in pixels)
    const MAX_WIDTH = 200;
    const MAX_HEIGHT = 80;

    public function __construct()
    {
        $this->helper = new Helper();
    }

    public function cupom(Configuracao $config, Venda $venda)
    {
        $heightPaper = 120;

        $itens = VendaItem::where('venda_id', $venda->id)->get();
        $faturas = FaturaItem::where('venda_id', $venda->id)->get();
        $heightPaper += (count($itens) * 4);
        $heightPaper += (count($faturas) * 4);

        $pdf = new Fpdf('P', 'mm', [80, $heightPaper]);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $width = 80;
        $height = 6;
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(94, 98, 120);
        /* LOGO */
        if (!empty($config->imagem)) {
            list($widthimg, $heightimg) = $this->resizeToFit('assets/images/logo.png');
            $pdf->Image(
                'assets/images/logo.png', (self::A4_HEIGHT - $widthimg) / 2,
                $height,
                $widthimg,
                $heightimg
            );
            $height += 24;
        }
        /* DADOS DO EMITENTE */
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($width, 1, utf8_decode($config->nome), 0, 0, 'C', true);

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','',8);
        if ($config->tipo_pessoa == 1) {
            $pdf->Cell($width, 1, utf8_decode("CPF: " . $this->helper->mascara('###.###.###-##', $config->documento)), 0, 0, 'C', true);
        } else {
            $pdf->Cell($width, 1, utf8_decode("CNPJ: ".$this->helper->mascara('##.###.###/####-##', $config->documento)." - IE: ".$config->inscricao_estadual), 0, 0, 'C', true);
        }

        $height += 3;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode($config->logradouro.", ".$config->numero), 0, 0, 'C', true);

        $height += 3;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->Cell($width, 1, utf8_decode($config->bairro." - ".$config->cidade." - ".$config->uf), 0, 0, 'C', true);

        $height += 3;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        /* # PEDIDO */
        $height += 3;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($width, 3, "PEDIDO: ".Str::padLeft($venda->id, 6, 0), 0, 0, 'C', true);

        $height += 5;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);


        /* DADOS DO CLIENTE */
        $height += 3;
        if ($venda->cliente != null) {
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell($width, 1, utf8_decode("CLIENTE: " . $venda->cliente->nome), 0, 0, 'L', true);

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            if ($venda->cliente->tipo_pessoa == 1) {
                $pdf->Cell($width, 1, utf8_decode("DOCUMENTO: " . $this->helper->mascara('###.###.###-##', $venda->cliente->documento)), 0, 0, 'L', true);
            } else {
                $pdf->Cell($width, 1, utf8_decode("DOCUMENTO: " . $this->helper->mascara('##.###.###/####-##', $venda->cliente->documento)), 0, 0, 'L', true);
            }

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->Cell($width, 1, utf8_decode($config->logradouro . ", " . $config->numero), 0, 0, 'L', true);

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->Cell($width, 1, utf8_decode($config->bairro . " - " . $config->cidade . " - " . $config->uf), 0, 0, 'L', true);

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->SetTextColor(100, 100, 100);
            $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);
            $height += 3;
        }

        /* # ITENS DO PEDIDO */
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','B',8);

        $pdf->setY($height); $pdf->setX(2);
        $pdf->Cell(12, 1, utf8_decode('DESCRIÇÃO'),0, 0, 'L', true);

        $pdf->setY($height); $pdf->setX(36);
        $pdf->Cell(36, 1, utf8_decode('VALOR.'),0, 0, 'L', true);

        $pdf->setY($height); $pdf->setX(50);
        $pdf->Cell(36, 1, utf8_decode('QTDE.'),0, 0, 'L', true);

        $pdf->setY($height); $pdf->setX(66);
        $pdf->Cell(13, 1, 'SUBTOTAL',0, 0, 'R', true);

        foreach ($itens as $item) {
            $height += 4;
            $quebraPalavra = substr($item->produto_nome, 0, 28);

            $pdf->setY($height); $pdf->setX(2);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(36, 1, utf8_decode($quebraPalavra), 0, 0, 'L', true);

            $pdf->setY($height); $pdf->setX(36);
            $pdf->Cell(12, 1, 'R$ ' . number_format($item->valor_unitario, 2, ',', '.'), 0, 0, 'R', true);

            $pdf->setY($height); $pdf->setX(50);
            $pdf->Cell(12, 1, number_format($item->quantidade, 2, ',', '.'), 0, 0, 'C', true);

            $pdf->setY($height); $pdf->setX(66);
            $pdf->Cell(13, 1, 'R$ ' . number_format($item->valor_total, 2, ',', '.'), 0, 0, 'R', true);
        }
        $height += 2;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(78, 1, Str::padBoth('', 16, '-'), 0, 0, 'R', true);
        $height += 3;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','B',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell(78, 1, 'R$ ' . number_format($venda->total_liquido, 2, ',', '.'), 0, 0, 'R', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        $height += 4;
        /* # PAGAMENTOS DO PEDIDO */
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(59, 1, utf8_decode('DESCRIÇÃO'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, 'VALOR', 0, 0, 'R', true);

        foreach ($venda->faturas as $fatura) {
            $formaPagamento = FormaPagamento::where('codigo', $fatura->forma_pagamento)->first();
            $height += 4;
            $pdf->setY($height); $pdf->setX(2);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(59, 1, utf8_decode(strtoupper($formaPagamento->nome)), 0, 0, 'L', true);
            $pdf->Cell(18, 1, 'R$ ' . number_format($fatura->valor_subtotal, 2, ',', '.'), 0, 0, 'R', true);
        }

        if (!empty($fatura->troco)) {
            $height += 4;
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(59, 1, utf8_decode('TROCO'), 0, 0, 'L', true);
            $pdf->Cell(18, 1, 'R$ ' . number_format($fatura->troco, 2, ',', '.'), 0, 0, 'R', true);
        }

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($width, 1, utf8_decode('NÃO É DOCUMENTO FISCAL'), 0, 0, 'C', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode("Data: ".date('d/m/Y H:i:s', strtotime($venda->data_venda))." - Vendedor: ".(isset($venda->vendedor->nome) ? $venda->vendedor->nome : 'Não Informado')), 0, 0, 'C', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode('DESENVOLVIDO POR EBIT SISTEMAS'), 0, 0, 'C', true);
        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode('(41) 99890-0800 - CASCAVEL/PR'), 0, 0, 'C', true);
        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode('WWW.EBITSISTEMAS.COM.BR'), 0, 0, 'C', true);

        ob_start();
        $pdf->output('I');
        $pdf = ob_get_clean();

        return response($pdf);
    }

    public function pagamento(Configuracao $config, Venda $venda, FaturaItem $fatura)
    {
        $heightPaper = 112;

        $itens = VendaItem::where('venda_id', $venda->id)->get();
        $heightPaper += (count($itens) * 4);

        $pdf = new Fpdf('P', 'mm', [80, $heightPaper]);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $width = 80;
        $height = 6;
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(94, 98, 120);
        /* LOGO */
        if (!empty($config->imagem)) {
            list($widthimg, $heightimg) = $this->resizeToFit('assets/images/logo.png');
            $pdf->Image(
                'assets/images/logo.png', (self::A4_HEIGHT - $widthimg) / 2,
                $height,
                $widthimg,
                $heightimg
            );
            $height += 24;
        }
        /* DADOS DO EMITENTE */
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($width, 1, utf8_decode($config->nome), 0, 0, 'C', true);

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','',8);
        if ($config->tipo_pessoa == 1 AND !empty($config->documento)) {
            $pdf->Cell($width, 1, utf8_decode("CPF: " . $this->helper->mascara('###.###.###-##', $config->documento)), 0, 0, 'C', true);
        } elseif ($config->tipo_pessoa == 2 AND !empty($config->documento)) {
            $pdf->Cell($width, 1, utf8_decode("CNPJ: ".$this->helper->mascara('##.###.###/####-##', $config->documento)." - IE: ".$config->inscricao_estadual), 0, 0, 'C', true);
        }

        $height += 3;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode($config->logradouro.", ".$config->numero), 0, 0, 'C', true);

        $height += 3;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->Cell($width, 1, utf8_decode($config->bairro." - ".$config->cidade." - ".$config->uf), 0, 0, 'C', true);

        $height += 3;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        /* # PEDIDO */
        $height += 3;
        $pdf->setY($height);
        $pdf->setX(0);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($width, 3, "COMPROVANTE DE PAGAMENTO", 0, 0, 'C', true);

        $height += 5;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);


        /* DADOS DO CLIENTE */
        $height += 3;
        if ($venda->cliente != null) {
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell($width, 1, utf8_decode("CLIENTE: " . $venda->cliente->nome), 0, 0, 'L', true);

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            if ($venda->cliente->tipo_pessoa == 1) {
                $pdf->Cell($width, 1, utf8_decode("DOCUMENTO: " . $this->helper->mascara('###.###.###-##', $venda->cliente->documento)), 0, 0, 'L', true);
            } else {
                $pdf->Cell($width, 1, utf8_decode("DOCUMENTO: " . $this->helper->mascara('##.###.###/####-##', $venda->cliente->documento)), 0, 0, 'L', true);
            }

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->Cell($width, 1, utf8_decode($config->logradouro . ", " . $config->numero), 0, 0, 'L', true);

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->Cell($width, 1, utf8_decode($config->bairro . " - " . $config->cidade . " - " . $config->uf), 0, 0, 'L', true);

            $height += 3;
            $pdf->setY($height);
            $pdf->setX(2);
            $pdf->SetTextColor(100, 100, 100);
            $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);
            $height += 3;
        }

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(59, 1, utf8_decode('PEDIDO:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, str($venda->id)->padLeft(6,0), 0, 0, 'R', true);

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(59, 1, utf8_decode('TOTAL DÉBITO:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, 'R$ ' . number_format($venda->total_liquido, 2, ',', '.'), 0, 0, 'R', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(59, 1, utf8_decode('PARCELA:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, str($fatura->numero_parcela)->padLeft(2,0).'/'.str($fatura->total_parcelas)->padLeft(2,0), 0, 0, 'R', true);

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(59, 1, utf8_decode('DATA DE VENCIMENTO:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, date('d/m/Y', strtotime($fatura->data_vencimento)), 0, 0, 'R', true);


        $height += 4;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(59, 1, utf8_decode('VALOR PAGO:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, 'R$ ' . number_format($fatura->valor_recebido, 2, ',', '.'), 0, 0, 'R', true);

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(59, 1, utf8_decode('DATA DO PAGAMENTO:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, (!empty($fatura->data_pagamento) ? date('d/m/Y', strtotime($fatura->data_pagamento)) : 'PENDENTE'), 0, 0, 'R', true);

        $formaPagamento = FormaPagamento::where('codigo', $fatura->forma_pagamento)->first();
        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(59, 1, utf8_decode('FORMA DE PAGAMENTO:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, strtoupper($formaPagamento->nome), 0, 0, 'R', true);

        $height += 4;
        $pdf->setY($height);
        $pdf->setX(2);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(59, 1, utf8_decode('SITUAÇÃO DO PAGAMENTO:'), 0, 0, 'L', true);
        $pdf->Cell(18, 1, strtoupper($fatura->situacaoFatura->nome), 0, 0, 'R', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        /*
        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','B',10);
        $pdf->Cell($width, 1, utf8_decode('NÃO É DOCUMENTO FISCAL'), 0, 0, 'C', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);*/

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode("EMITIDO EM: ".date('d/m/Y H:i:s', strtotime(now()))), 0, 0, 'C', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->Cell($width, 1, Str::padBoth('', $width, '-'), 0, 0, 'L', true);

        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode('DESENVOLVIDO POR EBIT SISTEMAS'), 0, 0, 'C', true);
        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode('(41) 99890-0800 - CASCAVEL/PR'), 0, 0, 'C', true);
        $height += 4;
        $pdf->setY($height); $pdf->setX(2);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell($width, 1, utf8_decode('WWW.EBITSISTEMAS.COM.BR'), 0, 0, 'C', true);

        ob_start();
        $pdf->output('I');
        $pdf = ob_get_clean();

        return response($pdf);
    }

    function pixelsToMM($val) {
        return $val * self::MM_IN_INCH / self::DPI;
    }

    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);

        $widthScale = self::MAX_WIDTH / $width;
        $heightScale = self::MAX_HEIGHT / $height;

        $scale = min($widthScale, $heightScale);

        return array(
            round($this->pixelsToMM($scale * $width)),
            round($this->pixelsToMM($scale * $height))
        );
    }
}