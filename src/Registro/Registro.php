<?php


namespace AFD\Registro;


abstract class Registro
{

    /**
     * @var string
     */
    protected $linha;

    /**
     * NSR - Número Sequêncial de Registro
     * @var $NSR
     * @type number
     */
    protected $NSR;

    /**
     * Tipo de Registro
     * @var $tipo
     * @type number
     */
    protected $tipo;

    /**
     * Data e Hora do Registro
     * @var $dataHora
     * @type \DateTimeImmutable
     */
    protected $dataHora;

    /**
     * Registro constructor.
     * @param string $linha Linha do Arquivo-Fonte de Dados
     */
    public function __construct($linha) {
        $this->linha = $linha;
        $this->processar();
    }

    /**
     * @return \DateTime
     */
    public function getDataHora()
    {
        return $this->dataHora;
    }

    /**
     * @param number $dia
     * @param number $mes
     * @param number $ano
     * @param number $hora
     * @param number $minuto
     * @return Registro
     */
    public function setDataHora($dia, $mes, $ano, $hora, $minuto)
    {
        $dataHoraTimestamp = mktime($hora, $minuto, 0, $mes, $dia, $ano);
        $dataHora = new \DateTime("now");
        $dataHora->setTimestamp($dataHoraTimestamp);
        $this->dataHora = \DateTimeImmutable::createFromMutable($dataHora);
        return $this;
    }

    /**
     * @return string
     */
    public function getLinha()
    {
        return $this->linha;
    }

    /**
     * @param string $linha
     * @return Registro
     */
    public function setLinha($linha)
    {
        $this->linha = $linha;
        return $this;
    }

    /**
     * @return number
     */
    public function getNSR()
    {
        return $this->NSR;
    }

    /**
     * @param number $NSR
     * @return Registro
     */
    public function setNSR($NSR)
    {
        $this->NSR = $NSR;
        return $this;
    }

    /**
     * @return number
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param number $tipo
     * @return Registro
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    protected function processar() {
        // Sobreescrever na classe filha
    }
}