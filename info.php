<?php
echo "<h2>Informações do PHP</h2>";
echo "Versão PHP: " . PHP_VERSION . "<br>";
echo "Sistema: " . PHP_OS . "<br>";

echo "<h3>Extensões carregadas:</h3>";
$extensions = get_loaded_extensions();
sort($extensions);
echo implode(', ', $extensions);

echo "<h3>Configuração do PHP:</h3>";
echo "Arquivo php.ini: " . php_ini_loaded_file() . "<br>";
echo "Diretório de extensões: " . ini_get('extension_dir') . "<br>";

echo "<h3>Permissões:</h3>";
echo "Pode escrever no diretório atual: " . (is_writable('.') ? '✅ Sim' : '❌ Não') . "<br>";
?>