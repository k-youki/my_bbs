<?php
namespace App\Model\Table;

use App\Model\Entity\PostTable;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* PostTable Model
*
*/
class PostTableTable extends Table {

    /**
    * Initialize method
    *
    * @param array $config The configuration for the Table.
    * @return void
    */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('post_table');
        $this->displayField('name');
        $this->primaryKey('id');
    }

    /**
    * Default validation rules.
    *
    * @param \Cake\Validation\Validator $validator Validator instance.
    * @return \Cake\Validation\Validator
    */
    public function validationDefault(Validator $validator) {
        $validator
        ->integer('id')
        ->allowEmpty('id', 'create');

        $validator
        ->requirePresence('name', 'create')
        ->allowEmpty('name');

        $validator
        ->requirePresence('contents', 'create')
        ->notEmpty('contents');

        $validator
        ->requirePresence('image', 'create')
        ->allowEmpty('image');

        $validator
        ->dateTime('date')
        ->requirePresence('date', 'create')
        ->allowEmpty('date');

        return $validator;
    }

    public function img_upload($upload_file)
    {
        if ($upload_file['name']) {
            $path = "img/uploads/{$upload_file['name']}";
            move_uploaded_file($upload_file['tmp_name'], $path);
            list($sw, $sh) = getimagesize($path);
            $dw = 128;
            $dh = $dw * $sh / $sw;
            $src = imagecreatefromjpeg($path);
            $dst = imagecreatetruecolor($dw, $dh);
            imagecopyresized($dst, $src, 0, 0, 0, 0, $dw, $dh, $sw, $sh);
            imagejpeg($dst, "img/uploads/thumbnails/".$upload_file['name']);
        }
    }
}
