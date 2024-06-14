namespace App\Http\Controllers;

use App\Models\Trecho;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

class TrechoController extends Controller
{
    public function create()
    {
        $ufs = UF::all();
        $rodovias = Rodovia::all();
        return Inertia::render('Trechos/Create', [
            'ufs' => $ufs,
            'rodovias' => $rodovias
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'data_referencia' => 'required|date',
            'uf_id' => 'required|exists:ufs,id',
            'rodovia_id' => 'required|exists:rodovias,id',
            'tipo' => 'required|string',
            'quilometragem_inicial' => 'required|numeric',
            'quilometragem_final' => 'required|numeric',
        ]);

        $response = Http::get('https://servicos.dnit.gov.br/sgplan/apigeo/rotas/espacializarlinha', [
            'br' => $data['rodovia_id'],
            'tipo' => $data['tipo'],
            'uf' => $data['uf_id'],
            'cd_tipo' => null,
            'data' => $data['data_referencia'],
            'kmi' => $data['quilometragem_inicial'],
            'kmf' => $data['quilometragem_final'],
        ]);

        $data['geo'] = $response->json();

        Trecho::create($data);

        return redirect()->back()->with('message', 'Trecho criado com sucesso!');
    }
}
