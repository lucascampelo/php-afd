<?php

namespace AFD;

use AFD\Registro\Empregado;
use AFD\Registro\Ponto;
use ArrayIterator;
use ArrayObject;

class Arquivo extends ArrayObject
{
    protected $fileResource;

    protected $items = array();

    /**
     * Arquivo constructor.
     * @param Resource|string $file
     * @throws \Exception
     */
    public function __construct($file)
    {
        if (!is_resource($file) && !file_exists($file)) {
            throw new \Exception("Arquivo inválido");
        }

        if (file_exists($file)) {
            $resource = fopen($file, "r");
            $this->setFile($resource);
        }
    }

    protected function setFile($resource) {
        $this->fileResource = $resource;
    }

    public function getFile() {
        return $this->fileResource;
    }

    public function processar()
    {
        while (($linha = fgets($this->getFile())) !== false) {
            if ($registro = $this->fabricarRegistro($linha)) {
                $this->items[] = $registro;
            }
        }
    }

    protected function fabricarRegistro($linha) {
        $numberTipo = (int) substr($linha, 9, 1);
        $tiposDisponiveis = [
            Ponto::TIPO_REGISTRO     => 'AFD\Registro\Ponto',
            Empregado::TIPO_REGISTRO => 'AFD\Registro\Empregado'
        ];

        if (array_key_exists($numberTipo, $tiposDisponiveis)) {
            $tipoRegistro = $tiposDisponiveis[ $numberTipo ];
            return new $tipoRegistro( $linha );
        }

        return false;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function count()
    {
        return count($this->items);
    }

    public function filter(callable $callback)
    {
        $items = array();
        foreach($this->items as $item) {
            if ($callback($item)) {
                $items[] = $item;
            }
        }

        return new ArrayIterator($items);
    }

}
