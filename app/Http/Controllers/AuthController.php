<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public  function index()
    {
        return view('auth.login');
    }

    // Validar os dados do utilizador no login
    public function loginProcess(AuthLoginRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Validar o utilizador e a senha com as informações da base de dados
            $authenticated = Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Verificar se o utilizador foi autenticado
            if (!$authenticated) {
                // Redirecionar o usuário, enviar a mensagem de erro
                return back()->withInput()->with('error', 'E-mail ou senha inválido!');
            }

            // Redirecionar o utilizador
            return redirect()->route('user.index');
        } catch (Exception $e) {
            // Redirecionar o utilizador, enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail ou senha inválido!');
        }
    }

    // Deslogar o utilizador
    public function logout()
    {

        // Deslogar o utilizador
        Auth::logout();

        // Redirecionar o utilizador, enviar a mensagem de sucesso
        return redirect()->route('login')->with('success', 'Logout com sucesso!');
    }
}
