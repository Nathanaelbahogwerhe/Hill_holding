@echo off
echo ================================================
echo   MIGRATION DU MODULE FINANCE - HILL HOLDING
echo ================================================
echo.

cd /d "c:\laragon\www\hill_holding"

echo [1/4] Migration de la structure des expenses (ajout category, renommage title->description)...
php artisan migrate --path=database/migrations/2025_12_21_150000_update_expenses_table_structure.php
echo.

echo [2/4] Migration de la structure des revenues (renommage title->description)...
php artisan migrate --path=database/migrations/2025_12_21_150001_update_revenues_table_structure.php
echo.

echo [3/4] Verification des migrations existantes...
php artisan migrate:status
echo.

echo ================================================
echo   MIGRATIONS TERMINEES !
echo ================================================
echo.
echo Verifications a faire:
echo   1. Tester la creation d'une depense avec categorie
echo   2. Tester la creation d'un revenu
echo   3. Verifier que les budgets se mettent a jour automatiquement
echo   4. Tester l'upload de documents dans expenses et revenues
echo.
pause
