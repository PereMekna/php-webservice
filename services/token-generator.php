<?php
class TokenGenerator {
  private $_length = 64;
        
  // Nous déclarons une méthode dont le seul but est d'afficher un texte.
  public function generate() {
    return substr(bin2hex(openssl_random_pseudo_bytes($this->_length)),0, $this->_length);
  }
}
?>