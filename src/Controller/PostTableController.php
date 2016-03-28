<?php
namespace App\Controller;

use Cake\I18n\Time;
use App\Controller\AppController;


/**
* PostTable Controller
*
* @property \App\Model\Table\PostTableTable $PostTable
*/
class PostTableController extends AppController
{

    /**
    * Index method
    *
    * @return \Cake\Network\Response|null
    */
    public function index()
    {
        $postTable = $this->paginate($this->PostTable);
        $postEntity = $this->PostTable->newEntity();

        $this->set(compact('postTable','postEntity'));
        $this->set('_serialize', ['postTable']);
    }

    /**
    * View method
    *
    * @param string|null $id Post Table id.
    * @return \Cake\Network\Response|null
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function view($id = null)
    {
        $postTable = $this->PostTable->get($id, [
            'contain' => []
        ]);

        $this->set('postTable', $postTable);
        $this->set('_serialize', ['postTable']);
    }

    /**
    * Add method
    *
    * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
    */
    public function add( $postEntity )
    {
        $postEntity = $this->PostTable->newEntity();

        if ($this->request->is('post')) {
            $postEntity = $this->PostTable->patchEntity($postEntity, $this->request->data);
            //name未入力を名無しさんとして処理
            if( $postEntity->name == null ){
                $postEntity->name = '名無しさん';
            }
            //画像アップロード処理---------------------------------
            $upload_file = $this->request->data['upload'];
            $postEntity->image = $upload_file['name'];
            if( $upload_file['name'] ){
                $path = "img/uploads/{$upload_file['name']}";
                move_uploaded_file( $upload_file['tmp_name'], $path);
                list($sw, $sh) = getimagesize($path);
                $dw = 128;
                $dh = $dw * $sh / $sw;
                $src = imagecreatefromjpeg($path);
                $dst = imagecreatetruecolor($dw, $dh);
                imagecopyresized($dst, $src, 0, 0, 0, 0, $dw, $dh, $sw, $sh);
                imagejpeg($dst, "img/uploads/t_{$upload_file['name']}");
            }
            //-------------------------------------------------
            $postEntity->date = Time();
            if ($this->PostTable->save($postEntity)) {
                $this->Flash->success(__('The post table has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The post table could not be saved. Please, try again.'));
            }
        }
    }

    /**
    * Edit method
    *
    * @param string|null $id Post Table id.
    * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
    * @throws \Cake\Network\Exception\NotFoundException When record not found.
    */
    public function edit($id = null)
    {
        $postTable = $this->PostTable->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postTable = $this->PostTable->patchEntity($postTable, $this->request->data);
            if ($this->PostTable->save($postTable)) {
                $this->Flash->success(__('The post table has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The post table could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('postTable'));
        $this->set('_serialize', ['postTable']);
    }

    /**
    * Delete method
    *
    * @param string|null $id Post Table id.
    * @return \Cake\Network\Response|null Redirects to index.
    * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postTable = $this->PostTable->get($id);
        if ($this->PostTable->delete($postTable)) {
            $this->Flash->success(__('The post table has been deleted.'));
        } else {
            $this->Flash->error(__('The post table could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
