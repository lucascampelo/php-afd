<?php

namespace AFD\Registro;

/**
 * Class Empregado
 * @package AFD\Registro
 *
 * Esta classe representa o registro de inclusão, alteração ou exclusão de empregado da MT do REP
 *
 * @see http://www.normaslegais.com.br/legislacao/portaria1510_2009.htm
 */
class Empregado extends Registro
{
    const TIPO_REGISTRO = 5;

    /**
     * Expressão regular da linha para este tipo de registro
     * @type string
     */
    const regex = "/^(?P<NSR>[0-9]{9})(?P<tipo>5)(?P<data>(?P<data_dia>[0-9]{2})(?P<data_mes>[0-9]{2})(?P<data_ano>[0-9]{4}))(?P<horario>(?P<horario_hora>[0-9]{2})(?P<horario_minuto>[0-9]{2}))(?P<operacao>[AEI])(?P<PIS>[0-9]{12})(?P<nome>[a-zA-Z0-9\ \.\,]+[a-zA-Z])/";

    /**
     * Tipo de Operação:
     * - I - Inclusão
     * - A - Alteração
     * - E - Exclusão
     * @var $operacao
     * @type string
     */
    protected $operacao;

    /**
     * PIS do Empregado
     * @var $PIS
     * @type string
     */
    protected $PIS;

    /**
     * Nome do Empregado
     * @var $nome
     * @type string
     */
    protected $nome;

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Empregado
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperacao()
    {
        return $this->operacao;
    }

    /**
     * @param string $operacao
     * @return Empregado
     */
    public function setOperacao($operacao)
    {
        $this->operacao = $operacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getPIS()
    {
        return $this->PIS;
    }

    /**
     * @param string $PIS
     * @return Empregado
     */
    public function setPIS($PIS)
    {
        $this->PIS = $PIS;
        return $this;
    }

    protected function processar()
    {
        $matchResult = preg_match(self::regex, $this->linha, $matches);

        if ($matchResult === false) {
            throw new \Exception("Não foi possível processar o registro");
        }

        if ($matchResult === 0) {
            return;
        }

        $this->setNSR($matches["NSR"]);
        $this->setTipo($matches["tipo"]);
        $this->setDataHora($matches["data_dia"], $matches["data_mes"], $matches["data_ano"], $matches["horario_hora"], $matches["horario_minuto"]);
        $this->setOperacao($matches["operacao"]);
        $this->setPIS($matches["PIS"]);
        $this->setNome($matches["nome"]);
    }
}