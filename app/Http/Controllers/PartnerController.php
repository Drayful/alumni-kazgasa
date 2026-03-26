<?php

namespace App\Http\Controllers;

use App\Models\PartnerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PartnerController extends Controller
{
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
        ]);

        $app = PartnerApplication::create([
            'name' => $validated['name'],
            'company' => $validated['company'],
            'contact' => $validated['contact'],
            'status' => 'new',
            // ip можно добавить, если хотите
        ]);

        // Уведомление администратору (если почта настроена — отправим, иначе просто залогируем)
        try {
            Mail::raw(
                "Новая заявка партнёрства\n\nИмя: {$app->name}\nКомпания: {$app->company}\nКонтакт: {$app->contact}",
                function ($m) {
                    $m->to('l.lau@kazgasa.kz')->subject('Заявка партнёрства KazGASA Alumni');
                }
            );
        } catch (\Throwable $e) {
            Log::warning('Partner apply: mail send failed', ['error' => $e->getMessage()]);
        }

        return redirect()->back()->with('partner_sent', true);
    }
}

