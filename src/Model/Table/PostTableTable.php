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

    public function img_upload($image_file)
    {
        if ($image_file['name']) {
            $path = "img/uploads/{$image_file['name']}";
            move_uploaded_file($image_file['tmp_name'], $path);

            $new_width = 128;

            // 元画像のファイルサイズを取得
            list($original_width, $original_height) = getimagesize($path);

            //元画像の比率を計算し、高さを設定
            $proportion = $original_width / $original_height;
            $new_height = $new_width / $proportion;

            //高さが幅より大きい場合は、高さを幅に合わせ、横幅を縮小
            if($proportion < 1){
                $new_height = $new_width;
                $new_width = $new_width * $proportion;
            }

            //$file_type = strtolower(end(explode('.', $image_file)));
            $file_type =  pathinfo($image_file['name'], PATHINFO_EXTENSION);;

            if ($file_type === "jpg" || $file_type === "jpeg") {

                $original_image = ImageCreateFromJPEG($path); //JPEGファイルを読み込む
                $new_image = ImageCreateTrueColor($new_width, $new_height); // 画像作成

            } elseif ($file_type === "gif") {

                $original_image = ImageCreateFromGIF($path); //GIFファイルを読み込む
                $new_image = ImageCreateTrueColor($new_width, $new_height); // 画像作成

                /* ----- 透過問題解決 ------ */
                $alpha = imagecolortransparent($original_image);  // 元画像から透過色を取得する
                imagefill($new_image, 0, 0, $alpha);       // その色でキャンバスを塗りつぶす
                imagecolortransparent($new_image, $alpha); // 塗りつぶした色を透過色として指定する

            } elseif ($file_type === "png") {

                $original_image = ImageCreateFromPNG($path); //PNGファイルを読み込む
                $new_image = ImageCreateTrueColor($new_width, $new_height); // 画像作成

                /* ----- 透過問題解決 ------ */
                imagealphablending($new_image, false);  // アルファブレンディングをoffにする
                imagesavealpha($new_image, true);       // 完全なアルファチャネル情報を保存するフラグをonにする

            } else {
                // 何も当てはまらなかった場合の処理は書いてませんので注意！
                return;

            }

            // 元画像から再サンプリング
            ImageCopyResampled($new_image,$original_image,0,0,0,0,$new_width,$new_height,$original_width,$original_height);

            // 画像をブラウザに表示
            if ($file_type === "jpg" || $file_type === "jpeg") {
                imagejpeg($new_image, "img/uploads/thumbnails/".$image_file['name']);
            } elseif ($file_type === "gif") {
                ImageGIF($new_image, "img/uploads/thumbnails/".$image_file['name']);
            } elseif ($file_type === "png") {
                ImagePNG($new_image, "img/uploads/thumbnails/".$image_file['name']);
            }
            // メモリを開放する
            imagedestroy($new_image);
            imagedestroy($original_image);
        }
    }
}
