<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Notification;
use Spatie\Permission\Models\Role;

class Notify
{
    public static function admins(string $title, string $message, ?string $url = null)
    {
        // ✅ Vérifie si le rôle 'Admin' existe
        if (Role::where('name', 'Admin')->exists()) {
            $admins = User::role('Admin')->get();
        }
        // ✅ Sinon, on prend les 'Super Admin' (ou un autre rôle existant)
        elseif (Role::where('name', 'Super Admin')->exists()) {
            $admins = User::role('Super Admin')->get();
        }
        // ✅ Sinon, on ne notifie personne (évite l’erreur)
        else {
            $admins = collect();
        }

        // ✅ Crée les notifications
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title'   => $title,
                'message' => $message,
                'url'     => $url,
            ]);
        }
    }
}




