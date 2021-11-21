<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Services\ClienteService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClienteController extends Controller
{
 
    protected ClienteService $clienteService;

    public function __construct(ClienteService $clienteService)
    {
       $this->clienteService = $clienteService;        
    }

    public function index(Request $request)
    {   
        $result = ['status' => Response::HTTP_OK];
        $paginate = $request->get('per_page', '12');
        $order = $request->get('order', 'DESC');
        $column = $request->get('orderColumn', 'id');
        try {
            $cliente = $this->clienteService->getResultadoPaginado($paginate, $column,  $order) ;
            
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($cliente, $result['status']);
    }
    public function store(ClienteRequest $request)
    {
        $result = ['status' => Response::HTTP_CREATED];
        try {
            $cliente = $this->clienteService->save($request->validated()); 
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($cliente, $result['status']);    
       
    }

    public function show($id)
    {               
        $result = ['status' => 200];
        try {
            $cliente = $this->clienteService->findById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($cliente, $result['status']);
    }

    public function update($id, ClienteRequest $request)
    {              
        $result = ['status' => Response::HTTP_OK];
        try {
            $cliente = $this->clienteService->update($id,$request->validated());
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($cliente, $result['status']);
    }

    public function destroy($id)
    {       
        return $this->clienteService->deleteById($id);        
    }
}
