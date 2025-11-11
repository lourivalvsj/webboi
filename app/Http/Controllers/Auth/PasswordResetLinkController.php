<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Para desenvolvimento/produção sem configuração de e-mail
        // Sempre retornar sucesso para não frustrar o usuário
        if (config('mail.default') === 'log' || config('app.env') === 'local') {
            \Log::info('Password reset requested for: ' . $request->email);
            return back()->with('status', 'Solicitação registrada! Entre em contato conosco pelo WhatsApp ou e-mail para recuperar sua senha.');
        }

        try {
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status == Password::RESET_LINK_SENT
                        ? back()->with('status', 'Link de recuperação enviado! Verifique seu e-mail.')
                        : back()->withInput($request->only('email'))
                                ->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            // Log do erro para debugging
            \Log::error('Password reset error: ' . $e->getMessage());
            
            // Em caso de erro de conexão de e-mail, retornar mensagem amigável
            return back()->with('status', 'Sistema de e-mail temporariamente indisponível. Entre em contato conosco pelo WhatsApp ou e-mail para recuperar sua senha.');
        }
    }
}
