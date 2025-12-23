<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{
    HomeController,
    DashboardController,
    FilialeController,
    AgenceController,
    DepartmentController,
    EmployeeController,
    ClientController,
    UserController,
    PayrollController,
    LeaveController,
    LeaveTypeController,
    EmployeeInsuranceController,
    InvoiceController,
    MessageController,
    AssetController,
    TransactionController,
    ProductController,
    StockTransferController,
    ProjectController,
    TaskController,
    ClientPaymentController,
    Finance\ExpenseController,
    Finance\RevenueController,
    Finance\FinancialReportController,
    BudgetController,
    ProfileController,
    ContractController,
    PositionController,
    AttendanceController,
    BusinessContractController,
    SettingController,
    RoleController,
    PermissionController,
    UserPermissionController,
    SupplierController,
    StockController,
    ReportController,
    ReportScheduleController,
    ActivityController,
    DailyOperationController,
    EvaluationController,
    PurchaseRequestController,
    PurchaseOrderController,
    ReceptionController,
    SupplierContractController,
    EquipmentController,
    MaintenanceController,
    BreakdownController,
    InterventionController,
    VehicleController,
    MissionController,
    FuelRecordController,
    VehicleMaintenanceController,
    ItEquipmentController,
    SoftwareLicenseController,
    ItInterventionController,
};

use App\Http\Controllers\Admin\{
    DashboardController as AdminDashboardController,
    ActivityLogController,
    SystemSettingController as AdminSystemSettingController,
    BackupController,
    SystemNotificationController,
};

/*
|--------------------------------------------------------------------------
| Redirection racine vers le dashboard
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| Auth (login / logout)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Routes protégées (auth required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard principal & updates
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [HomeController::class, 'data'])->name('dashboard.data');

    // Guides d'administration
    Route::view('/help/admin-guide', 'help.admin-guide')->name('help.admin-guide');
    Route::view('/help/filiale-guide', 'help.filiale-guide')->name('help.filiale-guide');

    
    /*
    |--------------------------------------------------------------------------
    | Dashboards selon niveau (Maison mère / Filiale / Agence)
    --------------------------------------------------------------------------
    */
    Route::get('/dashboard/mere', [HomeController::class, 'index']);
    Route::get('/dashboard/filiale', [HomeController::class, 'index']);
    Route::get('/dashboard/agence', [HomeController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | RH (Super Admin, RH Manager)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Super Admin|RH Manager'])->group(function () {
        Route::resources([
            'employees'    => EmployeeController::class,
            'departments'  => DepartmentController::class,
            'filiales'     => FilialeController::class,
            'agences'      => AgenceController::class,
            'payrolls'     => PayrollController::class,
            'leaves'       => LeaveController::class,
            'employee_insurances'   => EmployeeInsuranceController::class,
            'contracts'    => ContractController::class,
            'positions'    => PositionController::class,
            'attendances'  => AttendanceController::class,
        ]);

        // Document download (private storage)
        Route::get('employees/{employee}/document', [EmployeeController::class, 'downloadDocument'])->name('employees.document');

        // Attachments routes for RH module
        Route::get('employees/{employee}/attachments/{index}/download', [EmployeeController::class, 'downloadAttachment'])->name('employees.attachments.download');
        Route::delete('employees/{employee}/attachments/{index}', [EmployeeController::class, 'deleteAttachment'])->name('employees.attachments.delete');
        
        Route::get('contracts/{contract}/attachments/{index}/download', [ContractController::class, 'downloadAttachment'])->name('contracts.attachments.download');
        Route::delete('contracts/{contract}/attachments/{index}', [ContractController::class, 'deleteAttachment'])->name('contracts.attachments.delete');
        
        Route::get('payrolls/{payroll}/attachments/{index}/download', [PayrollController::class, 'downloadAttachment'])->name('payrolls.attachments.download');
        Route::delete('payrolls/{payroll}/attachments/{index}', [PayrollController::class, 'deleteAttachment'])->name('payrolls.attachments.delete');
        
        Route::get('leaves/{leave}/attachments/{index}/download', [LeaveController::class, 'downloadAttachment'])->name('leaves.attachments.download');
        Route::delete('leaves/{leave}/attachments/{index}', [LeaveController::class, 'deleteAttachment'])->name('leaves.attachments.delete');

        Route::resource('leave-types', LeaveTypeController::class)->names('leave_types');
    });

    /*
    |--------------------------------------------------------------------------
    | Administration (Super Admin, RH Manager)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Super Admin|RH Manager'])->group(function () {
        Route::resource('users', UserController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Business / Opérations
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Super Admin|Chargé des Opérations|Operations Manager'])->group(function () {
        // Route personnalisée pour la planification des activités (AVANT resource)
        Route::get('activities/planning', [ActivityController::class, 'planning'])->name('activities.planning');
        Route::get('activities/planning/create', [ActivityController::class, 'planningCreate'])->name('activities.planning.create');
        Route::post('activities/planning/store', [ActivityController::class, 'planningStore'])->name('activities.planning.store');
        
        Route::resources([
            'clients'            => ClientController::class,
            'projects'           => ProjectController::class,
            'tasks'              => TaskController::class,
            'client_payments'    => ClientPaymentController::class,
            'stocks'             => StockController::class,
            'suppliers'          => SupplierController::class,
            'contracts_business' => BusinessContractController::class,
            'reports'            => ReportController::class,
            'report_schedules'   => ReportScheduleController::class,
            'activities'         => ActivityController::class,
            'daily_operations'   => DailyOperationController::class,
            'evaluations'        => EvaluationController::class,
            
            // ACHATS / APPROVISIONNEMENTS
            'purchase_requests'  => PurchaseRequestController::class,
            'purchase_orders'    => PurchaseOrderController::class,
            'receptions'         => ReceptionController::class,
            'supplier_contracts' => SupplierContractController::class,
            
            // MAINTENANCE & ÉQUIPEMENTS
            'equipment'          => EquipmentController::class,
            'maintenances'       => MaintenanceController::class,
            'breakdowns'         => BreakdownController::class,
            'interventions'      => InterventionController::class,
            
            // LOGISTIQUE & TRANSPORT
            'vehicles'           => VehicleController::class,
            'missions'           => MissionController::class,
            'fuel_records'       => FuelRecordController::class,
            'vehicle_maintenances' => VehicleMaintenanceController::class,
            
            // INFORMATIQUE
            'it_equipment'       => ItEquipmentController::class,
            'software_licenses'  => SoftwareLicenseController::class,
            'it_interventions'   => ItInterventionController::class,
        ]);

        // Routes additionnelles
        Route::get('/stocks/rapport/articles', [StockController::class, 'rapport'])->name('stocks.rapport');
        Route::get('/reports/dashboard', [ReportController::class, 'dashboard'])->name('reports.dashboard');
        Route::post('/reports/{report}/validate', [ReportController::class, 'validateReport'])->name('reports.validate');
        Route::get('/reports/{report}/attachments/{index}/download', [ReportController::class, 'downloadAttachment'])->name('reports.attachments.download');
        Route::delete('/reports/{report}/attachments/{index}', [ReportController::class, 'deleteAttachment'])->name('reports.attachments.delete');
        Route::get('/report-schedules/deadlines', [ReportScheduleController::class, 'deadlines'])->name('report_schedules.deadlines');
        
        // Achats routes
        Route::post('/purchase_requests/{purchase_request}/approve', [PurchaseRequestController::class, 'approve'])->name('purchase_requests.approve');
        Route::post('/purchase_requests/{purchase_request}/reject', [PurchaseRequestController::class, 'reject'])->name('purchase_requests.reject');
        
        // Attachments routes (download & delete)
        Route::get('/equipment/{equipment}/attachments/{index}/download', [EquipmentController::class, 'downloadAttachment'])->name('equipment.attachments.download');
        Route::delete('/equipment/{equipment}/attachments/{index}', [EquipmentController::class, 'deleteAttachment'])->name('equipment.attachments.delete');
        
        Route::get('/vehicles/{vehicle}/attachments/{index}/download', [VehicleController::class, 'downloadAttachment'])->name('vehicles.attachments.download');
        Route::delete('/vehicles/{vehicle}/attachments/{index}', [VehicleController::class, 'deleteAttachment'])->name('vehicles.attachments.delete');
        
        Route::get('/purchase_orders/{purchaseOrder}/attachments/{index}/download', [PurchaseOrderController::class, 'downloadAttachment'])->name('purchase_orders.attachments.download');
        Route::delete('/purchase_orders/{purchaseOrder}/attachments/{index}', [PurchaseOrderController::class, 'deleteAttachment'])->name('purchase_orders.attachments.delete');
        
        Route::get('/receptions/{reception}/attachments/{index}/download', [ReceptionController::class, 'downloadAttachment'])->name('receptions.attachments.download');
        Route::delete('/receptions/{reception}/attachments/{index}', [ReceptionController::class, 'deleteAttachment'])->name('receptions.attachments.delete');
        
        Route::get('/maintenances/{maintenance}/attachments/{index}/download', [MaintenanceController::class, 'downloadAttachment'])->name('maintenances.attachments.download');
        Route::delete('/maintenances/{maintenance}/attachments/{index}', [MaintenanceController::class, 'deleteAttachment'])->name('maintenances.attachments.delete');
        
        Route::get('/breakdowns/{breakdown}/attachments/{index}/download', [BreakdownController::class, 'downloadAttachment'])->name('breakdowns.attachments.download');
        Route::delete('/breakdowns/{breakdown}/attachments/{index}', [BreakdownController::class, 'deleteAttachment'])->name('breakdowns.attachments.delete');
        
        Route::get('/interventions/{intervention}/attachments/{index}/download', [InterventionController::class, 'downloadAttachment'])->name('interventions.attachments.download');
        Route::delete('/interventions/{intervention}/attachments/{index}', [InterventionController::class, 'deleteAttachment'])->name('interventions.attachments.delete');
        
        Route::get('/missions/{mission}/attachments/{index}/download', [MissionController::class, 'downloadAttachment'])->name('missions.attachments.download');
        Route::delete('/missions/{mission}/attachments/{index}', [MissionController::class, 'deleteAttachment'])->name('missions.attachments.delete');
        
        Route::get('/fuel_records/{fuelRecord}/attachments/{index}/download', [FuelRecordController::class, 'downloadAttachment'])->name('fuel_records.attachments.download');
        Route::delete('/fuel_records/{fuelRecord}/attachments/{index}', [FuelRecordController::class, 'deleteAttachment'])->name('fuel_records.attachments.delete');
        
        Route::get('/vehicle_maintenances/{vehicleMaintenance}/attachments/{index}/download', [VehicleMaintenanceController::class, 'downloadAttachment'])->name('vehicle_maintenances.attachments.download');
        Route::delete('/vehicle_maintenances/{vehicleMaintenance}/attachments/{index}', [VehicleMaintenanceController::class, 'deleteAttachment'])->name('vehicle_maintenances.attachments.delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Finance
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Super Admin|Admin Finance'])->group(function () {
        Route::resources([
            'transactions' => TransactionController::class,
            'budgets'      => BudgetController::class,
            'invoices'     => InvoiceController::class,
        ]);

        Route::prefix('finance')->name('finance.')->group(function () {
            Route::resource('reports', FinancialReportController::class);
        });

        Route::prefix('finance')->group(function () {
        Route::resource('expenses', App\Http\Controllers\Finance\ExpenseController::class);
        Route::resource('revenues', App\Http\Controllers\Finance\RevenueController::class);
        });

    });

    /*
    |--------------------------------------------------------------------------
    | Outils (accessible Àtous)
    |--------------------------------------------------------------------------
    */
    Route::resource('messages', MessageController::class);
    Route::post('messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');

    Route::resources([
        'assets'   => AssetController::class,
        'settings' => SettingController::class,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Profil utilisateur
    |--------------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/edit', [ProfileController::class, 'update'])->name('update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Super Admin seulement : Administration Avancée
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/cache/clear', [AdminDashboardController::class, 'clearCache'])->name('cache.clear');
        Route::post('/system/optimize', [AdminDashboardController::class, 'optimize'])->name('system.optimize');
        Route::get('/system/info', [AdminDashboardController::class, 'systemInfo'])->name('system.info');
        
        // Activity Logs
        Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show', 'destroy']);
        Route::post('activity-logs/clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');
        
        // System Settings
        Route::resource('system-settings', AdminSystemSettingController::class);
        Route::post('system-settings/maintenance/toggle', [AdminSystemSettingController::class, 'toggleMaintenance'])->name('system-settings.maintenance.toggle');
        
        // Backups
        Route::resource('backups', BackupController::class)->only(['index', 'create', 'destroy']);
        Route::get('backups/{backup}/download', [BackupController::class, 'download'])->name('backups.download');
        
        // System Notifications
        Route::resource('system-notifications', SystemNotificationController::class);
        Route::post('system-notifications/{systemNotification}/toggle', [SystemNotificationController::class, 'toggle'])->name('system-notifications.toggle');
        
        // Roles & Permissions (moved here)
        Route::resources([
            'roles'       => RoleController::class,
            'permissions' => PermissionController::class,
        ]);
    });

});





