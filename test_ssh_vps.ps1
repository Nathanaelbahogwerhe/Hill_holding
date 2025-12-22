# Script de test de connexion SSH au VPS Hostinger
# Informations VPS Hill Holding

Write-Host "🔐 Test de connexion SSH - VPS Hostinger" -ForegroundColor Cyan
Write-Host ""
Write-Host "📋 Informations VPS:" -ForegroundColor Yellow
Write-Host "   Hostname: srv1191613.hstgr.cloud" -ForegroundColor White
Write-Host "   IP:       72.60.100.232" -ForegroundColor White
Write-Host "   User:     root" -ForegroundColor White
Write-Host "   OS:       Ubuntu 24.04 + HestiaCP" -ForegroundColor White
Write-Host "   Location: Mumbai, India" -ForegroundColor White
Write-Host ""

Write-Host "🔧 Commandes de connexion SSH:" -ForegroundColor Cyan
Write-Host ""
Write-Host "Option 1 (via IP):" -ForegroundColor Green
Write-Host "   ssh root@72.60.100.232" -ForegroundColor White
Write-Host ""
Write-Host "Option 2 (via hostname):" -ForegroundColor Green
Write-Host "   ssh root@srv1191613.hstgr.cloud" -ForegroundColor White
Write-Host ""

$choice = Read-Host "Tester la connexion maintenant? (o/n)"

if ($choice -eq "o" -or $choice -eq "O") {
    Write-Host ""
    Write-Host "🚀 Tentative de connexion..." -ForegroundColor Cyan
    Write-Host ""
    
    # Tester avec ssh (si disponible)
    try {
        ssh root@72.60.100.232
    } catch {
        Write-Host ""
        Write-Host "⚠️ SSH non disponible dans PowerShell" -ForegroundColor Yellow
        Write-Host ""
        Write-Host "Solutions:" -ForegroundColor Cyan
        Write-Host "1. Utilisez Git Bash (installé avec Git)" -ForegroundColor White
        Write-Host "2. Utilisez PuTTY: https://www.putty.org/" -ForegroundColor White
        Write-Host "3. Utilisez Windows Terminal avec OpenSSH" -ForegroundColor White
        Write-Host ""
        Write-Host "Ou copiez cette commande:" -ForegroundColor Yellow
        Write-Host "ssh root@72.60.100.232" -ForegroundColor Green
    }
} else {
    Write-Host ""
    Write-Host "📝 Commandes utiles une fois connecté en SSH:" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "# Vérifier PHP" -ForegroundColor Cyan
    Write-Host "php -v" -ForegroundColor White
    Write-Host ""
    Write-Host "# Vérifier Composer" -ForegroundColor Cyan
    Write-Host "composer --version" -ForegroundColor White
    Write-Host ""
    Write-Host "# Vérifier Git" -ForegroundColor Cyan
    Write-Host "git --version" -ForegroundColor White
    Write-Host ""
    Write-Host "# Vérifier MySQL" -ForegroundColor Cyan
    Write-Host "mysql --version" -ForegroundColor White
    Write-Host ""
    Write-Host "# Accéder à HestiaCP" -ForegroundColor Cyan
    Write-Host "https://72.60.100.232:8083" -ForegroundColor Green
    Write-Host ""
}

Write-Host ""
Write-Host "📚 Guide complet: DEPLOIEMENT_VPS_HESTIA.md" -ForegroundColor Cyan
