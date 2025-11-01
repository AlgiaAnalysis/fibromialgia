<?php
    namespace App\Http\Controllers\dao;

    use Illuminate\Support\Facades\Auth;

    class GenericCtrl {
        public $model = null;
        public $modelName = null;

        public function __construct($model = "") {
            $this->model = app("App\\Models\\".$model);
            $this->modelName = $model;
        }

        public function save($data) {
            $model = $this->model::create($data);

            $user = Auth::user();

            // $actionLogCtrl = new ActionLogCtrl();
            // $actionLogCtrl->save([
            //     "acl_model" => $this->modelName,
            //     "acl_action" => "create",
            //     "acl_description" => "Registro criado",
            //     "acl_object" => $model->toJson(),
            //     "acl_date" => date("Y-m-d"),
            //     "acl_time" => date("H:i:s"),
            //     "acl_model_id" => $model->getKey(),
            //     "users_usr_id" => $user->usr_id ?? null,
            // ]);

            return $model;
        }

        public function update($id, $data) {
            $registry = $this->getObject($id);
            $oldObject = $registry->toJson();

            $registry->update($data);
            $registry->refresh();

            $user = Auth::user();

            $actionLogCtrl = new ActionLogCtrl();
            $actionLogCtrl->save([
                "acl_model" => $this->modelName,
                "acl_action" => "update",
                "acl_description" => "Registro atualizado",
                "acl_object" => $oldObject,
                "acl_date" => date("Y-m-d"),
                "acl_time" => date("H:i:s"),
                "acl_model_id" => $registry->getKey(),
                "users_usr_id" => $user->usr_id ?? null,
            ]);

            return $registry;
        }

        public function getAll() {
            return $this->model::select()->get();
        }

        /**
         * @return object|int
         */
        public function getObjectByField($field, $value, $first = true, $count = false)
        {
            $query = $this->model::where($field, $value);

            if ($count) {
                // retorna apenas o número de registros
                return $query->count();
            }

            if ($first) {
                // retorna o primeiro registro (ou null)
                return $query->first();
            }

            // retorna todos os registros encontrados
            return $query->get();
        }

        /**
         * @return object
         */
        public function getObjectByFields(array $fields, array $values, $first=true) {
            $query = $this->model::query();
        
            foreach ($fields as $index => $field) {
                $query->where($field, $values[$index]);
            }
            
            return $first ? $query->first() : $query->get();
        }

        /**
         * @return object
         */
        public function getObject($id) {
            return $this->model::find($id);
        }

        public function delete($id) {
            $registry = $this->model::findOrFail($id);

            $objectJson = $registry->toJson();
            $modelId    = $registry->getKey();

            $deleted = $registry->delete();

            if ($deleted) {
                (new ActionLogCtrl())->save([
                    "acl_model" => $this->modelName,
                    "acl_action" => "delete",
                    "acl_description" => "Registro deletado",
                    "acl_object" => $objectJson,
                    "acl_date" => date("Y-m-d"),
                    "acl_time" => date("H:i:s"),
                    "acl_model_id" => $modelId,
                    "users_usr_id" => Auth::user()->usr_id ?? null,
                ]);
            }

            return $deleted;
        }

        public function getRemoteData($value, $remoteConfig) {
            $remoteEntity = app("App\\Models\\".$remoteConfig['remoteEntity']);
        
            return $remoteEntity::where(
                $remoteConfig['remoteAtrr'],
                $value,
            )->pluck($remoteConfig['value'], $remoteConfig['key'])->toArray();

        }
    }