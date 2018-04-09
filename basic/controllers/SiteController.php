<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\web\Request;

use app\models\LoginForm;
use app\models\ContactForm;
use app\models\AdminForm;
use app\models\post;

use yii\data\ActiveDataProvider;

use yii\db\ActiveRecord;
use yii\db\Query;

class SiteController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}

		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
		]);
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionAdmin()
	{

		$form = new AdminForm();
		$testDB = new post();

		$postDB = post::find()->all();

		if($form->load(Yii::$app->request->post()) && $form->validate()) {
			$name = Html::encode($form->name);
			$content = Html::encode($form->content);
			$title = Html::encode($form->title);
			$form->file = UploadedFile::getInstance($form, 'file');
			$form->file->saveAs('photos/'.$form->file->baseName.'.'.$form->file->extension);
		}

		if($_POST['AdminForm']) {
			$testDB->name = $form->name;
			$testDB->content = $form->content;
			$testDB->title = $form->title;
			$testDB->picture = $form->file;
			$testDB->save();
		}

		return $this->render('admin', [
			'form' => $form,
			'name' => $name,
			'content' => $content,
			'postDB' => $postDB,
			'req' => $form->name,
			'file' => $form->file
		]);
	}
}
