<?php

Class AccessViolationException extends Exception
{
    // Redéfinissez l'exception ainsi le message n'est pas facultatif
  public function __construct($message, $code = 0, Throwable $previous = null) {

    // traitement personnalisé que vous voulez réaliser ...

    // assurez-vous que tout a été assigné proprement
    parent::__construct($message, $code, $previous);
  }
}