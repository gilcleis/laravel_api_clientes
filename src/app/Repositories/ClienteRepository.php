<?php
namespace App\Repositories;

use App\Models\Cliente;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ClienteRepository
    {
        protected Cliente $cliente;

        /**
         * ClienteRepository constructor.
         *
         * @param  Cliente  $cliente
         */
        public function __construct(Cliente $cliente)
        {
            $this->cliente = $cliente;
        }


        /**
         * @return Cliente[]
         */
        public function getAll()
        {
            return $this->cliente->orderBy('nome', 'asc')->paginate(6);
        }

        public function getResultadoPaginado(int $paginate = 12, string $column = 'id', string $order = 'DESC') 
        {
            return $this->cliente->orderBy($column,$order)->paginate($paginate);
        }

        /**
         * @param $id
         *
         * @return Cliente[]|Collection
         */
        public function getById($id)
        {
            return $this->cliente->where('id', $id)->get();
        }

        /**
         * @param $id
         *
         * @return Cliente|null
         */
        public function findById($id): ?Cliente
        {
            return $this->cliente->find($id);
        }

        /**
         * @param $data
         *
         * @return Cliente
         */
        public function save($data)
        {
            /** @var Cliente $model */
            $model = new $this->cliente;

            $model->fill($data);
            $model->save();

            return $model->fresh();

        }

        /**
         * @param $data
         * @param $id
         *
         * @return Cliente
         */
        public function update($id,$data): Cliente
        {
            $model = $this->cliente->find($id);
            $model->fill($data);
            $model->update();
            return $model;
        }

        /**
         * @param $id
         *
         * @return Cliente
         * @throws Exception
         */
        public function delete($id)
        {
            $model = $this->cliente->find($id);
            $model->delete();
            return $model;

        }

       


    }