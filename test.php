<?php

// $a = md5(bin2hex(openssl_random_pseudo_bytes(6)));

// echo $a;

$form ='<form>
<label for="choose">Préférez-vous la banane ou la cerise ?</label>
<input id="choose" name="i_like" required>
<button>Soumettre</button>
</form>';
echo $form;