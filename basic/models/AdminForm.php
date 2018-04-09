<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

	class AdminForm extends Model
	{
		public $name;
		public $content;
		public $file;
		public $title;

		public function rules()
		{
			return [
				[['name', 'content', 'title', 'file'], 'required'],
				[['file'], 'file', 'extensions' => 'jpg, png']
			];

		}

		// public function upload()
		// {
		// 	if($this->validate()) {
		// 		$this->file->saveAs('photos/'.$this->file->baseName.'.'.$this->file->extension);
		// 	} else {
		// 		return false;
		// 	}
		// }
	}	
?>