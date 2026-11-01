@echo off
rem WP-CLI wrapper using XAMPP PHP (set XAMPP env var if installed elsewhere)
if "%XAMPP%"=="" set "XAMPP=C:\xampp"
set "SSL_CERT_FILE=%~dp0cacert.pem"
"%XAMPP%\php\php.exe" -d memory_limit=512M -d curl.cainfo="%~dp0cacert.pem" -d openssl.cafile="%~dp0cacert.pem" "%~dp0wp-cli.phar" --require="%~dp0local-ssl.php" %*
