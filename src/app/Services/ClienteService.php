<?php


    namespace App\Services;


    use App\Http\Requests\ClienteRequest;
    use App\Models\Cliente;
    use App\Repositories\ClienteRepository;
    use Exception;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use \Illuminate\Support\Facades\Validator;
    use InvalidArgumentException;
    use Throwable;


    class ClienteService
    {
        protected ClienteRepository $clienteRepository;

        public function __construct(ClienteRepository $clienteRepository)
        {
            $this->clienteRepository = $clienteRepository;
        }


        public function getAll()
        {
            return $this->clienteRepository->getAll();
        }

        public function getResultadoPaginado(int $paginate, string $column, string $order) 
        {
            return $this->clienteRepository->getResultadoPaginado($paginate, $column,  $order) ;
        }

        public function findById($id)
        {
            return $this->clienteRepository->findById($id);
        }


        public function save($data)
        {
            $rules     = new ClienteRequest();
           
            $validator = Validator::make($data, $rules->rules());
            
            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }
            return $this->clienteRepository->save($data);
        }


        public function update($id,$data)
        {
            //dd($id,$data);
            $rules     = new ClienteRequest();
            $validator = Validator::make($data, $rules->rules());

            if ($validator->fails()) {
                throw new InvalidArgumentException($validator->errors()->first());
            }

            DB::beginTransaction();

            try {
                $model = $this->clienteRepository->update($id,$data);

            } catch (Exception $e) {
                DB::rollBack();
                Log::info($e->getMessage());

                throw new InvalidArgumentException('Não foi possível atualizar o registro');
            }

            DB::commit();

            return $model;
        }


        public function deleteById($id)
        {

            DB::beginTransaction();

            try {
                $model = $this->clienteRepository->delete($id);

            } catch (Exception $e) {
                DB::rollBack();
                Log::info($e->getMessage());
                throw new InvalidArgumentException('Não foi possível remover o registro');
            }

            DB::commit();

            return $model;
        }



    }