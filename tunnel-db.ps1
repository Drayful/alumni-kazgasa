# SSH-туннель к БД на сервере (для локальной разработки)
# Укажите свои данные и сохраните скрипт:
$SSH_USER = "root"
$SSH_HOST = "10.10.10.10"

# Локальный порт и порт MySQL на сервере (при необходимости измените)
$LOCAL_PORT = 3306
$REMOTE_PORT = 3306

# Keepalive раз в 60 сек, чтобы соединение не обрывалось по таймауту
$SSH_OPTS = "-o ServerAliveInterval=60 -o ServerAliveCountMax=3"

param(
    [switch]$Reconnect,
    [switch]$Background
)

if ($Background) {
    $passArgs = @()
    if ($Reconnect) { $passArgs += "-Reconnect" }
    $argList = @("-NoExit", "-ExecutionPolicy", "Bypass", "-File", $PSCommandPath) + $passArgs
    Start-Process powershell.exe -ArgumentList $argList -WindowStyle Minimized
    Write-Host "Туннель запущен в отдельном свёрнутом окне. Не закрывайте то окно."
    exit
}

$sshCmd = "ssh -L ${LOCAL_PORT}:localhost:${REMOTE_PORT} $SSH_OPTS ${SSH_USER}@${SSH_HOST}"

if ($Reconnect) {
    Write-Host "Режим автопереподключения: при обрыве туннель перезапустится через 5 сек."
    Write-Host "Подключение: $SSH_USER@${SSH_HOST} (локально порт $LOCAL_PORT -> сервер $REMOTE_PORT)"
    while ($true) {
        Invoke-Expression $sshCmd
        Write-Host "Соединение разорвано. Переподключение через 5 сек..."
        Start-Sleep -Seconds 5
    }
} else {
    Write-Host "Туннель: локальный порт $LOCAL_PORT -> $SSH_USER@${SSH_HOST}:$REMOTE_PORT"
    Write-Host "Окно можно свернуть, но не закрывайте."
    Invoke-Expression $sshCmd
}
