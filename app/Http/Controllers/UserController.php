<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserPdfMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function show(User $user)
    {
        // Retorna a view com o utilizador
        return view('users.show', [
            'user' => $user,
        ]);
    }

    // Listar os usuários
    public function index(Request $request)
    {
        // Recuperar os registros do banco dados
        // $users = User::orderByDesc('id')->paginate(10);
        $users = User::when(
            $request->filled('name'),
            fn($query) =>
            $query->whereLike('name', '%' . $request->name . '%')
        )
            ->when(
                $request->filled('email'),
                fn($query) =>
                $query->whereLike('email', '%' . $request->email . '%')
            )
            ->when(
                $request->filled('start_date_registration'),
                fn($query) =>
                $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
            )
            ->when(
                $request->filled('end_date_registration'),
                fn($query) =>
                $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
            )
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Carregar a VIEW
        return view('users.index', [
            'users' => $users,
            'name' => $request->name,
            'email' => $request->email,
            'start_date_registration' => $request->start_date_registration,
            'end_date_registration' => $request->end_date_registration,
        ]);
    }

    public function create()
    {
        //Caminho para a view de criação de usuário
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        try {
            // Criação do utilizador
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Redireciona com mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Utilizador criado com sucesso.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao criar o utilizador.');
        }
    }

    public function edit(User $user)
    {
        // Retorna a view de edição com o utilizador
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            // Atualiza o utilizador
            $user->update([
                'name' => $request->name,
                'role' => $request->role,
                'email' => $request->email,
            ]);

            // Redireciona com mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Utilizador atualizado com sucesso.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erro ao atualizar o utilizador.');
        }
    }

    public function destroy(User $user)
    {
        try {
            // Deleta o utilizador
            $user->delete();

            // Redireciona com mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Utilizador apagado com sucesso.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao apagar o utilizador.');
        }
    }

    public function generatePdf(User $user)
    {
        try {
            // Gera o PDF do utilizador
            $pdf = PDF::loadView('users.generate-pdf', ['user' => $user])->setPaper('a4', 'portrait');

            // Definir o caminho temporário para salvar o PDF
            $pdfPath = storage_path("app/public/view_user_{$user->id}.pdf");

            // Guarda o pdf localmente
            $pdf->save($pdfPath);

            // Envia o PDF por email
            Mail::to($user->email)->send(new UserPdfMail($pdfPath, $user));

            // Remover the PDF file after sending the email
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            // Redireciona com mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Email com o PDF do utilizador enviado com sucesso.');

        } catch (\Exception $e) {
            return redirect()->route('user.show', ['user' => $user->id])->with('error', 'Email com o PDF do utilizador não enviado.');
        }
    }

    public function generatePdfUsers(Request $request)
    {

        try {
            // Recuperar os registos da base dados
            $users = User::when(
                $request->filled('name'),
                fn($query) =>
                $query->whereLike('name', '%' . $request->name . '%')
            )
                ->when(
                    $request->filled('email'),
                    fn($query) =>
                    $query->whereLike('email', '%' . $request->email . '%')
                )
                ->when(
                    $request->filled('start_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '>=', Carbon::parse($request->start_date_registration))
                )
                ->when(
                    $request->filled('end_date_registration'),
                    fn($query) =>
                    $query->where('created_at', '<=', Carbon::parse($request->end_date_registration))
                )
                ->orderByDesc('name')
                ->get();

            // Somar total de registos
            $totalRecords = $users->count('id');

            // Verificar se a quantidade de registos ultrapassa o limite para gerar PDF
            $numberRecordsAllowed = 500;
            if ($totalRecords > $numberRecordsAllowed) {
                // Redirecionar o utilizador, enviar a mensagem de erro
                return redirect()->route('user.index', [
                    'name' => $request->name,
                    'email' => $request->email,
                    'start_date_registration' => $request->start_date_registration,
                    'end_date_registration' => $request->end_date_registration,
                ])->with('error', "Limite de registos ultrapassado para gerar PDF. O limite é de $numberRecordsAllowed registos!");
            }

            // Carregar a string com o HTML/conteúdo e determinar a orientação e o tamanho do ficheiro PDF
            $pdf = Pdf::loadView('users.generate-pdf-users', ['users' => $users])->setPaper('a4', 'portrait');

            // Fazer o download do ficheiro PDF
            return $pdf->download('listar_utilizadores.pdf');
        } catch (Exception $e) {

            // Redirecionar o utilizador, enviar a mensagem de erro
            return redirect()->route('user.index')->with('error', 'PDF não gerado!');
        }
    }
}
