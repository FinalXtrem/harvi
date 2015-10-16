<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

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

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionStat($sort = false, $order = false, $refresh = false)
    {
        if (!$sort && !$order) {
            $sort = 'AC';
            $order = 'desc';
        }
        if (!$sort) {
            $sort = 'AC';
        }
        if (!$order) {
            $order = 'asc';
        }
        $verdicts = [
            'AC' => 'Accepted',
            'OLE' => 'Output Limit Exceeded',
            'TLE' => 'Time Limit Exceeded',
            'CE' => 'Compile Error',
            'MLE' => 'Memory Limit Exceeded',
            'RTE' => 'Run Time Error',
            'WA' => 'Wrong Answer',
        ];
        if ($refresh == 1) {
            Yii::$app->cache->delete('datausers');
            $this->redirect(['site/stat']);
        }
        $users = Yii::$app->cache->get('datausers');
        if ($users === false) {
            $users = [
                ['nim' => '1801373990', 'name' => 'Riany', 'username' => 'rianysantoso', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801374223', 'name' => 'Billy Saputra', 'username' => 'billysaputra', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801374646', 'name' => 'Paulus Robin', 'username' => 'paulusrobin', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801377742', 'name' => 'Boby Hartanto', 'username' => 'bobyhartanto', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801380573', 'name' => 'Andrew Dean Bachtiar', 'username' => 'andrew', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801381430', 'name' => 'Metta Handika', 'username' => 'mettahandika', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801382042', 'name' => 'Stanley Giovany', 'username' => 'stanleygiovany', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801382295', 'name' => 'Griffin Seannery', 'username' => 'griff88', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801384350', 'name' => 'Yacob', 'username' => 'yacob21', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801384590', 'name' => 'Jason Nathanael', 'username' => 'jasonn', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801385555', 'name' => 'Arief Surya', 'username' => 'conglip', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801385901', 'name' => 'Vania Christ Fina', 'username' => 'cehaa12', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801385990', 'name' => 'Velinda Dwi Puspa', 'username' => 'vlinda', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801386476', 'name' => 'Ario Manon Sejati', 'username' => 'manjatgones', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801389282', 'name' => 'Firda Sahidi', 'username' => 'firdarinoa', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801391122', 'name' => 'Fernando Prayogo', 'username' => 'nandohendo', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801391495', 'name' => 'Fransiscus Wiraputra', 'username' => 'fransis10', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801391816', 'name' => 'Ricky Ray', 'username' => 'rr27', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801397391', 'name' => 'William', 'username' => 'william06', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801399270', 'name' => 'Yukianto Darmawan Wijaya', 'username' => 'yukianto', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801400101', 'name' => 'Mika Octo Frentzen', 'username' => 'strider', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801400846', 'name' => 'Aurelia Friska Widjaja', 'username' => 'aureliafriska', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801409580', 'name' => 'Jerry Luis', 'username' => 'jerry', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801414744', 'name' => 'Raoul Vendreo Achdiyat', 'username' => 'rva', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801417733', 'name' => 'Tadeo Lemuel Christian Lianda', 'username' => 'tadeolcl', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801417815', 'name' => 'Theodore Junot Harbangan', 'username' => 'junot', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801418894', 'name' => 'Petter John', 'username' => 'petterjohn', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801426800', 'name' => 'Jonathan Saputra Halim ( Joy )', 'username' => 'raphaeljonathan88', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801427324', 'name' => 'Rezadi Falah', 'username' => 'rezadif', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801431201', 'name' => 'Willi Septiansyah', 'username' => 'williseptiansyah', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801434191', 'name' => 'Rengkuan Richard Joshua Timothy', 'username' => 'rjtimothy', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801435282', 'name' => 'Lusya Rani Situmorang', 'username' => 'lusyarani', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801441556', 'name' => 'Dionisius Andrian Hadipurnawan', 'username' => 'dionhadipurnawan', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1801451292', 'name' => 'Rahma Aisyah Qadary', 'username' => 'rqadary', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
            ];
            foreach ($users as $i => $value) {
                if (isset($value['username']) && $value['username'] != '') {
                    $temp = Json::decode($this->callAPI('POST', 'https://jollybeeoj.com/submission/statistic/user/u/' . $value['username']));
                    if ($temp != null) {
                        foreach ($verdicts as $j => $value2) {
                            $key = array_search($value2, array_column($temp, 'verdictDisplayName'));
                            $users[$i][$j] = $key === false ? 0 : $temp[$key]['count'];
                        }
                    }else $users[$i]['AC'] = -1;
                }
                $users[$i]['TM'] = max(min(ceil($users[$i]['AC'] * 100 / 39),100),0);
            }
            Yii::$app->cache->set('datausers', $users);
        }
        $verdicts['TM'] = 'Assignment';
        array_multisort(array_column($users, $sort), ($order == 'asc' ? SORT_ASC : ($order == 'desc' ? SORT_DESC : SORT_ASC)), $users);

        return $this->render('stat', ['users' => $users, 'sort' => $sort, 'order' => $order, 'verdicts' => $verdicts]);
    }

    public function actionStat2($sort = false, $order = false, $refresh = false)
    {
        if (!$sort && !$order) {
            $sort = 'AC';
            $order = 'desc';
        }
        if (!$sort) {
            $sort = 'AC';
        }
        if (!$order) {
            $order = 'asc';
        }
        $verdicts = [
            'AC' => 'Accepted',
            'OLE' => 'Output Limit Exceeded',
            'TLE' => 'Time Limit Exceeded',
            'CE' => 'Compile Error',
            'MLE' => 'Memory Limit Exceeded',
            'RTE' => 'Run Time Error',
            'WA' => 'Wrong Answer',
        ];
        if ($refresh == 1) {
            Yii::$app->cache->delete('datausers2');
            $this->redirect(['site/stat2']);
        }
        $users = Yii::$app->cache->get('datausers2');
        if ($users === false) {
            $users = [
                ['nim' => '1901457284', 'name' => 'Kevin Gunadi', 'username' => 'kevingunadi', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901504021', 'name' => 'Syifa Nur Azizah', 'username' => 'syfanrazzh', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901504715', 'name' => 'Moehammad Mahruz Fadhillah', 'username' => ' fadelmhmmd', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901505655', 'name' => 'Devo Avidianto Pratama', 'username' => 'devoav', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901506292', 'name' => 'Wilson Virgiyanto Djapri', 'username' => 'wilsondjap', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901506563', 'name' => 'Khemal Malik', 'username' => 'khemal ', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901517415', 'name' => 'Stefan Alexander', 'username' => 'disidia123', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901517674', 'name' => 'Mietha Apriyanti Dewi', 'username' => 'miethaapriyanti', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901520025', 'name' => 'Muhammad Ekky Firmansyah', 'username' => 'ekkyf', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901520706', 'name' => 'Aulia Abrar', 'username' => 'lbrr711', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901522762', 'name' => 'Fajar Nurahman', 'username' => ' fnur96', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901522806', 'name' => 'Alief Syah Fikry', 'username' => 'alief', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901530266', 'name' => 'Julianti Cahyadi', 'username' => 'julianticahyadi', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901531041', 'name' => 'Muhammad Raditya Pratama', 'username' => 'radityapratama', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
                ['nim' => '1901531483', 'name' => 'Muhammad Fadel Ghifary', 'username' => 'ghifary06', 'AC' => 0, 'OLE' => 0, 'TLE' => 0, 'CE' => 0, 'MLE' => 0, 'RTE' => 0, 'WA' => 0],
            ];
            foreach ($users as $i => $value) {
                if (isset($value['username']) && $value['username'] != '') {
                    $temp = Json::decode($this->callAPI('POST', 'https://jollybeeoj.com/submission/statistic/user/u/' . $value['username']));
                    if ($temp != null) {
                        foreach ($verdicts as $j => $value2) {
                            $key = array_search($value2, array_column($temp, 'verdictDisplayName'));
                            $users[$i][$j] = $key === false ? 0 : $temp[$key]['count'];
                        }
                    }
                }
            }
            Yii::$app->cache->set('datausers2', $users, 299);
        }
        array_multisort(array_column($users, $sort), ($order == 'asc' ? SORT_ASC : ($order == 'desc' ? SORT_DESC : SORT_ASC)), $users);

        return $this->render('stat2', ['users' => $users, 'sort' => $sort, 'order' => $order, 'verdicts' => $verdicts]);
    }

    public function actionStat3($sort = false, $order = false, $refresh = false)
    {
        if (!$sort && !$order) {
            $sort = 'AC';
            $order = 'desc';
        }
        if (!$sort) {
            $sort = 'AC';
        }
        if (!$order) {
            $order = 'asc';
        }
        $verdicts = [
            'AC' => 'Accepted',
            'OLE' => 'Output Limit Exceeded',
            'TLE' => 'Time Limit Exceeded',
            'CE' => 'Compile Error',
            'MLE' => 'Memory Limit Exceeded',
            'RTE' => 'Run Time Error',
            'WA' => 'Wrong Answer',
        ];
        if ($refresh == 1) {
            Yii::$app->cache->delete('datausers3');
            $this->redirect(['site/stat3']);
        }
        $users = Yii::$app->cache->get('datausers3');
        if ($users === false) {
            $users = [
                ['nim'=>'1901460240','name'=>'Luciana Dian Santami','username'=>'lucianalim','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901460474','name'=>'Robby Pranata','username'=>'yirens','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901460663','name'=>'Andrew Belamy Himawan','username'=>'','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901460890','name'=>'Cedric Trihutomo Susanto','username'=>'cedric711','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901460972','name'=>'Kelvin','username'=>'kelvin','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901461035','name'=>'Yulian','username'=>'akusukadora','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901461331','name'=>'Jordan','username'=>'jordank125','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901461445','name'=>'Andika Kandrianto','username'=>'andikandrianto','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901461602','name'=>'Adithia Sudimano Mauntana','username'=>'vendetta','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901461911','name'=>'Annisa Rizki Nugroho','username'=>'annisarizkin','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901462076','name'=>'Reinhard Agung Prasetyo','username'=>'reinhardap','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901462441','name'=>'Morris','username'=>'morrisgandii','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901462486','name'=>'Benny Trico Liumanto','username'=>'bennytricoliumanto','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901462536','name'=>'Irvan Stevanus','username'=>'irvanstevanus01','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901462782','name'=>'Kimiko Manggala Yusuf','username'=>'mikaelkimiko','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901462795','name'=>'Herbeth','username'=>'herbeth','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901462813','name'=>'Ferdian Herlianto','username'=>'frostamoune','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901463002','name'=>'Ibrahim Tifal Atha Amani','username'=>'','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901463122','name'=>'Kevin Ronaldo','username'=>'dangobo','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901463816','name'=>'Andre','username'=>'constance','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901464560','name'=>'Irvan Famadi','username'=>'irvanfamadi','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901464655','name'=>'Koes Andrey Ferdinand','username'=>'ferdinand','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901464680','name'=>'Tommy Halim','username'=>'tommy53','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901465355','name'=>'Adrian Lukito Lo','username'=>'adrianlukito','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901465393','name'=>'Darryl Prayudha Darmawan','username'=>'linxiaoril','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901465525','name'=>'Jason Anggarah','username'=>'jasonjiu','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901465600','name'=>'Ian Argus Chandra','username'=>'ianargusch','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901466130','name'=>'Darren Widarta','username'=>'darren','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901466282','name'=>'Yonathan Marhan Wijaya','username'=>'silvercrow','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901476011','name'=>'Gunawan','username'=>'','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901486952','name'=>'Joshua','username'=>'joshualalihatu','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
                ['nim'=>'1901528910','name'=>'Andrew Belamy Himawan','username'=>'','AC'=>0,'OLE'=>0,'TLE'=>0,'CE'=>0,'MLE'=>0,'RTE'=>0,'WA'=>0],
            ];
            foreach ($users as $i => $value) {
                if (isset($value['username']) && $value['username'] != '') {
                    $temp = Json::decode($this->callAPI('POST', 'https://jollybeeoj.com/submission/statistic/user/u/' . $value['username']));
                    if ($temp != null) {
                        foreach ($verdicts as $j => $value2) {
                            $key = array_search($value2, array_column($temp, 'verdictDisplayName'));
                            $users[$i][$j] = $key === false ? 0 : $temp[$key]['count'];
                        }
                    }
                }
            }
            Yii::$app->cache->set('datausers3', $users, 299);
        }
        array_multisort(array_column($users, $sort), ($order == 'asc' ? SORT_ASC : ($order == 'desc' ? SORT_DESC : SORT_ASC)), $users);

        return $this->render('stat3', ['users' => $users, 'sort' => $sort, 'order' => $order, 'verdicts' => $verdicts]);
    }

    /**
     * @param $method
     * @param $url
     * @param bool|false $data
     * @return mixed
     */
    function callAPI($method, $url, $data = false)
    {
        $curl = curl_init($url);
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        //curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Origin: https://jollybeeoj.com',
            'Access-Control-Request-Method: POST',
            'Access-Control-Headers: X-Requested-With']);
        curl_setopt($curl, CURLOPT_VERBOSE, true);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}
