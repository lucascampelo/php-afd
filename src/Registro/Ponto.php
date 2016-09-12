<?php

namespace AFD\Registro;

class Ponto extends Registro
{
    const TIPO_REGISTRO = 3;

    /**
     * Expressão regular da linha para este tipo de registro
     * @type string
     */
    const regex = "/^(?P<NSR>[0-9]{9})(?P<tipo>3)(?P<data>(?P<data_dia>[0-9]{2})(?P<data_mes>[0-9]{2})(?P<data_ano>[0-9]{4}))(?P<horario>(?P<horario_hora>[0-9]{2})(?P<horario_minuto>[0-9]{2}))(?P<PIS>[0-9]{12})/";

    /**
     * PIS do Empregado
     * @var $PIS
     * @type string
     */
    protected $PIS;

    /**
     * @return string
     */
    public function getPIS()
    {
        return $this->PIS;
    }

    /**
     * @param string $PIS
     * @return Ponto
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
            echo "deu rui";
            return;
        }

        $this->setNSR($matches["NSR"]);
        $this->setTipo($matches["tipo"]);
        $this->setDataHora($matches["data_dia"], $matches["data_mes"], $matches["data_ano"], $matches["horario_hora"], $matches["horario_minuto"]);
        $this->setPIS($matches["PIS"]);
    }
}