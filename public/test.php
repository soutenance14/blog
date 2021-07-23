<?php

$style='<style>
input:invalid {
    border: 2px dashed red;
  }
  
  input:valid {
    border: 1px solid black;
  }
</style>';

$form ='<form>

<input id="choose" name="i_like" required pattern="[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z.]{2,}">

<button>Soumettre</button>
</form>';
echo $style.$form;