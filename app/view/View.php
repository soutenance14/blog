<?php

Class View

{
    public static function renderViewFail(Exception $e)
    {
        return 'Pb render:' . $e->getMessage() . $e->getCode();
    }
}