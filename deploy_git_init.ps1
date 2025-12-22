# Script d'initialisation Git pour Hill Holding
# À exécuter UNE SEULE FOIS après avoir créé votre repo GitHub/GitLab

Write-Host "🚀 Initialisation Git pour Hill Holding" -ForegroundColor Cyan
Write-Host ""

# Vérifier si Git est installé
try {
    $gitVersion = git --version
    Write-Host "✅ Git installé: $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "❌ Git n'est pas installé ou pas dans le PATH" -ForegroundColor Red
    Write-Host "Installez Git depuis: https://git-scm.com/download/win" -ForegroundColor Yellow
    exit 1
}

Write-Host ""
Write-Host "📝 Avant de continuer, créez votre repo sur GitHub/GitLab:" -ForegroundColor Yellow
Write-Host "   1. Allez sur https://github.com/new" -ForegroundColor White
Write-Host "   2. Nom du repo: hill_holding (ou autre)" -ForegroundColor White
Write-Host "   3. Peut être privé ou public" -ForegroundColor White
Write-Host "   4. NE cochez PAS 'Initialize with README'" -ForegroundColor White
Write-Host "   5. Copiez l'URL du repo (ex: https://github.com/username/hill_holding.git)" -ForegroundColor White
Write-Host ""

$repoUrl = Read-Host "Entrez l'URL de votre repo Git"

if ([string]::IsNullOrWhiteSpace($repoUrl)) {
    Write-Host "❌ URL du repo requise" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "🔧 Initialisation du dépôt Git..." -ForegroundColor Cyan

# Initialiser Git si pas déjà fait
if (-not (Test-Path .git)) {
    git init
    Write-Host "✅ Repository Git initialisé" -ForegroundColor Green
} else {
    Write-Host "ℹ️ Repository Git déjà initialisé" -ForegroundColor Blue
}

# Ajouter tous les fichiers
Write-Host "📦 Ajout des fichiers..." -ForegroundColor Cyan
git add .

# Premier commit
Write-Host "💾 Création du commit..." -ForegroundColor Cyan
git commit -m "Initial commit - Hill Holding Laravel Project

- Multi-tenant system
- 95 migrations, 60+ tables
- 6 modules: RH, Finance, Projects, Logistics, IT, System
- 6 roles, 55 permissions
- Production ready
"

# Renommer branche en main
git branch -M main

# Ajouter le remote
Write-Host "🔗 Liaison avec le repo distant..." -ForegroundColor Cyan
git remote add origin $repoUrl

# Push
Write-Host "⬆️ Push vers GitHub/GitLab..." -ForegroundColor Cyan
Write-Host ""

try {
    git push -u origin main
    Write-Host ""
    Write-Host "✅ ✅ ✅ SUCCÈS ! ✅ ✅ ✅" -ForegroundColor Green
    Write-Host ""
    Write-Host "Votre code est maintenant sur: $repoUrl" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "🎯 PROCHAINE ÉTAPE:" -ForegroundColor Yellow
    Write-Host "   Allez sur votre VPS et exécutez les commandes du guide DEPLOIEMENT_VPS_HESTIA.md" -ForegroundColor White
    Write-Host ""
} catch {
    Write-Host ""
    Write-Host "⚠️ Erreur lors du push" -ForegroundColor Red
    Write-Host ""
    Write-Host "Si le repo est privé, utilisez un Personal Access Token:" -ForegroundColor Yellow
    Write-Host "1. GitHub: Settings → Developer settings → Personal access tokens → Generate new token" -ForegroundColor White
    Write-Host "2. Utilisez: git push https://TOKEN@github.com/username/repo.git main" -ForegroundColor White
    Write-Host ""
    Write-Host "Ou configurez SSH: https://docs.github.com/en/authentication/connecting-to-github-with-ssh" -ForegroundColor White
}
